<?php

/*
 * GCSpecialPage
 * ----------------------------------------------------------------------------
 *
 * A class used to automate the adding of multiple pages to a special page
 * (specically GCAdmin) by means of changing rendered page content via GET
 * variable changes.
 *
 * View,
 *
 * http://www.gcpedia.gc.ca/index.php/GCPEDIA:Development/creatingAGCAdminPage
 *
 * for information on how to use add pages
 *
 * contract:
 *
 *      preconditions:
 *
 *              * requires class GCAdmin
 *              * all callback functions must:
 *                  - be static members of GCAdmin
 *                  - require no arguments
 *                  - return true or the rendered page content (must be string
 *                    data type) to signal success
 *              * $url must be a valid link
 *              * $home must be a anchor with a valid link to the main special page
 *
 */
class GCSpecialPage
{
    public      $callbacks = array();
    public      $mainlinks;
    public      $url;
    public      $home;

    function __construct($url = '', $home = '')
    {
        $this->url  = $url;
        $this->home = $home;
    }

    # add a callback function
    function addPage($get_variable, $callback, $value)
    {
        $this->callbacks[] = array ('get' => $get_variable , 'callback' => $callback , 'value' => $value);
    }

    function addMainLink($get_variable, $callback, $title, $value)
    {
        $this->addPage($get_variable, $callback, $value);
        $this->mainlinks[] = GCPath::htmlLink($this->url.$get_variable."=".$value, $title);
    }

    # create the page
    function generatePage()
    {
        foreach ( $_GET as $getVar => $getValue )
        {
            $getVar     = htmlentities($getVar);
            $getValue   = htmlentities($getValue);

            $callback   = $this->chkGet($getVar, $getValue);

            if ( $callback >= 0 )
            {
                $output         = $this->home;
                $callback_func  = $this->callbacks[$callback]['callback'];
                $output         .= GCAdmin::$callback_func();
                
                if ( $output )
                    return $output;
                else
                    return "An error has with one of the callback functions";
            }
        }

        return $this->defaultPage();
    }

    private function chkGet( $getVar , $getValue )
    {
        $i = 0;
        foreach ( $this->callbacks as $callback_array )
        {
            extract($callback_array);

            if ( $getVar == $get && $getValue == $value )
                return $i;

            $i++;
        }
        
        return -1;
    }

    # generate the default page layout, no GET arguments
    function defaultPage()
    {
        $output = "A list of administrative functions for GCPEDIA<br/><br/>";

        foreach( $this->mainlinks as $link)
            $output .= $link."<br/>";

        return $output;
    }
}

class GCAdmin extends SpecialPage 
{
	private $output;
    private $page;

    static $home;
    static $url;
    static $HomePageLink;
	
	function __construct() 
	{
		parent::__construct( 'GCAdmin' );
		wfLoadExtensionMessages('GCAdmin');

        global $wgTitle;

        GCAdmin::$home			= $wgTitle->getFullURL();
        GCAdmin::$url			= $wgTitle->getFullURL(true);
        GCAdmin::$HomePageLink	= GCPath::htmlLink( GCAdmin::$home,'return to main menu' )."<br/><br/>";
        $this->page             = new GCSpecialPage( GCAdmin::$url, GCAdmin::$HomePageLink );

        # add main page links here
        #                          GET name     |   function name           |   title of link to page                           |   GET value
        $this->page->addMainLink( 'perform',        'confirmEmail',             'confirm user emails',                              'comfirmemail'  );
        $this->page->addMainLink( 'perform',        'sendMsgToFutureCharles',   'send messages to charles from future charles',     'emailcharles'  );


	}
	
	function stylesheet()
	{
		$styleText = 
<<<END
				<style>
				
					#test
					{
						border: 2px solid black;
						margin: 5px;
						padding: 5px;
						padding: 5px;
					}

                    .gcAdmin_userLst
                    {
                        background-color:   #eee;
                        border-style:       none;
                        width:              100%;
                    }

                    .gcAdmin_userLst tr
                    {
                        border-style:   none;
                        padding:        5px;
                    }

                    .gcAdmin_userLst tr:nth-child(even)
                    {
                        background: #ccc;
                    }
                    
                    .gcAdmin_userLst tr:nth-child(odd)
                    {
                        background: #eee;
                    }

                     .gcAdmin_userLst tr td
                    {
                        margin:         0px;
                        border-style:   none;
                        padding:        5px;
                    }
					
				</style>
				
END;
		$this->output .= $styleText;
	}
	
	function addtext($text)
	{
		if (is_string($text))
			$this->output .= $text;
	}
	
	function renderPage()
	{
		global $wgOut;
		$wgOut->addHTML( $this->output );
	}
 
	static function query($query_string)
	{
		global $wgDBname, $wgDBserver, $wgDBuser, $wgDBpassword;
			
		$con = mysql_connect($wgDBserver,$wgDBuser,$wgDBpassword);
		mysql_select_db($wgDBname);
		$result = mysql_query($query_string);
		mysql_close($con);
		
		return $result;
	}
	
	function spClassError()
	{
		global $wgRequest, $path;
		$file_loc = __FILE__;
		$error_msg = 
<<<END
		<div style="border: 1px solid red;">
				<div style="border-bottom: 1px solid red; color: red; font-weight: bold;">GC ADMIN SPECIALPAGE ERROR</div>
				<div style="padding: 10px;">
					There is an error in the extention file, <br/><br/>
					
					<span style="margin-left: 20px; color: blue;">$file_loc </span><br/><br/>
				
					You are missing <span style="color: blue;">GCClasses.php</span>, which is required to run this extention. You can download this file from
					<a href="" target="_blank">here</a><br/><br/>
					
					Once downloaded, please install file in the proper location, as show below:<br/><br/>
					
					<span style="margin-left: 20px; color: blue;">$path[1]/GCClasses.php</span>
				</div>
		</div>
END;
		$this->addText($error_msg);
	}
	
	function initialChecks()
	{
		if (!in_array('GCPath',get_declared_classes()))
		{
			global $path, $IP;
			if (is_file("$path[1]/GCClasses.php"))
			{
				if (!require_once("$path[1]/GCClasses.php"))
					return false;
				else 
					return true;
			}
			else
				return false;
		}
		else 
			return true;
	}
	
	function doPage()
	{
		global $wgRequest, $wgTitle, $wgUser;
		
		# Get request data from, e.g.
		$param          = $wgRequest->getText('param');

        # Check if the user has sysop rights
		if(!in_array("sysop",$wgUser->getEffectiveGroups()))
			header("Location: ".GCPath::pageURL('Main_Page'));

        //$this->addText($url);

        # generate the main page
        $main_page = $this->page->generatePage();
        $this->addText($main_page);
	}

    static function confirmUser(&$user)
    {
        if(!$user->isEmailConfirmed())
        {
            $registrationDate = date( "Y m d" , strtotime($user->getRegistration()) );
            $touchedDate = date( "m, d, Y" , strtotime($user->mTouched));

            $line = "<tr>
                        <td><input name='$user->mId' type='checkbox' /></td>
                        <td style='color: #a00;'>$user->mId</td>
                        <td style='font-weight: bold'>$user->mName</td>
                        <td>$user->mEmail</td>
                        <td>( <span style='color: #888;'>registered:</span> $registrationDate,  
                              <span style='color: #888;'>last logged in:</span> $touchedDate )
                        </td>
                    </tr>";
            return $line;
        }
        return "";
    }

	function execute( $par ) 
	{
		$this->setHeaders();
		$this->stylesheet();

		if($this->initialChecks())
			$this->doPage();
		else
			$this->spClassError();
		
		$this->renderPage();
	}

    static function test($value)
    {
        return "this is a test";
    }


    # GET['perform'] = confirmemail
    static function confirmEmail()
	{
        $output;

        if (htmlentities($_POST['emailusers'])=='send confirmation email')
		{
			$result = GCAdmin::query("SELECT user_id FROM user;");

			if (!$result)
			{
				$output .= mysql_error();
				return;
			}

			while($row = mysql_fetch_array( $result ))
			{
				extract($row);

				$user = new User();
				$user->mId = $user_id;
				$user->mFrom = 'id';
				$user->load();

				if(!$user->isEmailConfirmed())
					if (htmlentities($_POST[$user->mId])=='on')
					{
						//$user->sendConfirmationMail();
//                        $expiration = null; // gets passed-by-ref and defined in next line.
//                        $token = $user->confirmationToken( $expiration );
//                        $url = $user->confirmationTokenUrl( $token );
//                        $invalidateURL = $user->invalidationTokenUrl( $token );
//                        $user->saveSettings();

                        //$expirationDate = date( "m, d, Y" , strtotime($expiration) );

                        $email_body =
<<<END

GCPEDIA, the wiki for federal public servants, is sending you this message in regards to activating your account under the user name $user->nName.
If you no longer wish to continue your account at GCPEDIA, and stop receiving these emails please click the link below

www.mycoollink.com \n

To confirm that this account really does belong to you, and to activate e-mail features on GCPEDIA, open this link in your browser:\n

$url \n

If you did not register the account, follow this link to cancel the e-mail address confirmation. $invalidateURL \n

This confirmation code will expire at $expirationDate. \n

Note: This is a system generated email, please do not respond to it. \n

END;
                        //$user->sendMail('GCPEDIA Account Confirmation', $email_body);
						$output .= "Sent to $user->mName<br/>";
					}
			}

			$output .= "<br/>".GCPath::htmlLink(GCAdmin::$url.'perform=comfirmemail','return to unconfirmed user list')."<br/>";
		}

        $result = GCAdmin::query("SELECT user_id FROM user;");

        if (!$result)
            $output .= "An error has occurred while accessing use database, error is as follows:<br/>".mysql_error()."<br/>Ending script....<br/>Script Terminated.<br/></div>--- END ---<br/></div>";

        $output .= "<form action='".GCAdmin::$url."perform=comfirmemail' method='POST'>";
        $output .= '<div style="height: 100%; border: 2px solid #777; padding: 10px; background-color: #eee;">';
        $output .= '<select name="evalType"><option value="g">greater than</option><option value="l">less than</option></select> - ';
        $output .= 'day:<select name="day">';

        for ($i=1; $i <= 31; $i++) $output .= "<option value='$i'>$i</option>";

        $output .= '</select> month:<select name="month">';

        for ($i=1; $i <= 12; $i++) $output .= "<option value='$i'>$i</option>";

        $output .= '</select> year:<select name="year"><option value="2008">2008</option><option value="2009">2009</option></select>';
        $output .= '<input type="submit" name="filterbyDate" value="filter by date" /></div>';

         if (htmlentities($_POST['filterbyDate'])=='filter by date')
         {
            $output .= "<table class='gcAdmin_userLst' cellspacing='0'>";
            while($row = mysql_fetch_array( $result ))
            {
                extract($row);

                $user = new User();
                $user->mId = $user_id;
                $user->mFrom = 'id';
                $user->load();

                $year = htmlentities($_POST['year']);
                $month = htmlentities($_POST['month']);
                $day = htmlentities($_POST['day']);

                if (htmlentities($_POST['evalType']) == 'l')
                {   $first = mktime(0,0,0,$month,$day,$year); $second = strtotime($user->getRegistration()); }
                else
                {   $second = mktime(0,0,0,$month,$day,$year); $first = strtotime($user->getRegistration()); }

                if ( $first > $second )
                    $output .= GCAdmin::confirmUser($user);
            }
            $output .= "</table><br/><br/><input type='submit' value='send confirmation email' name='emailusers' />";
        }
        $output .= "</form><br/>$HomePageLink";

        return $output;
	}

    # $_GET['perform'] = emailcharles
    static function sendMsgToFutureCharles()
    {
        $body = "Dear Charles\n\nThis is a message from future Charles. I've written this to warn you to watch out for the coffee, it's been poisoned.\n\nFuture messages will follow.\n\nYours truley\n\nFuture Charles";

        $user = new User();
        $user->mName = 'Charles.degrasse';
        $user->mFrom = 'name';
        $user->load();
        //$user->sendMail('watchout for the coffee', $body);
        return "message sent";
    }
}

?>