<?php
class GCAdmin extends SpecialPage 
{
	private $output;
	
	function __construct() 
	{
		parent::__construct( 'GCAdmin' );
		wfLoadExtensionMessages('GCAdmin');
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
 
	function query($query_string)
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
		
		$home			= $wgTitle->getFullURL();
		$url			= $wgTitle->getFullURL(true);
		$HomePageLink	= GCPath::htmlLink($home,'return to main menu')."<br/><br/>";
		
		# Get request data from, e.g.
		$param = $wgRequest->getText('param');		
		
		if(!in_array("sysop",$wgUser->getEffectiveGroups()))
			header("Location: ".GCPath::pageURL('Main_Page'));
		
		$maillog = "/var/log/maillog";
		if (htmlentities($_POST['emailusers'])=='send confirmation email')
		{
			$result = $this->query("SELECT user_id FROM user;");
			
			if (!$result)
			{
				$this->addText(mysql_error());
				return;
			}
			$this->addText("Email confirmations have been sent to those listed below<br/><br/>");
			
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
						$this->addText("Sent to $user->mName<br/>");
					}
			}
			
			$this->addText("<br/>".GCPath::htmlLink($url.'perform=comfirmemail','return to unconfirmed user list')."<br/>");
			$this->addText($HomePageLink);
		}
		else if (htmlentities($_GET['perform'])=='comfirmemail')
		{
			$this->addText($HomePageLink);
			
			$result = $this->query("SELECT user_id FROM user;");
		
			if (!$result)
				$this->addText("An error has occurred while accessing use database, error is as follows:<br/>".mysql_error()."<br/>Ending script....<br/>Script Terminated.<br/></div>--- END ---<br/></div>");
	 
			$this->addText("<form action='".$url."perform=comfirmemail' method='POST'>");
            $this->addText('<div style="border: 2px solid #777; padding: 10px; background-color: #eee;"><select name="evalType"><option value="g">greater than</option><option value="l">less than</option></select> - ');
            $this->addText('day:<select name="day">');
            for ($i=1; $i <= 31; $i++) $this->addText("<option value='$i'>$i</option>");
            $this->addText('</select> month:<select name="month">');
            for ($i=1; $i <= 12; $i++) $this->addText("<option value='$i'>$i</option>");
            $this->addText('</select> year:<select name="year"><option value="2008">2008</option><option value="2009">2009</option></select>');
            $this->addText(' <input type="submit" name="filterbyDate" value="filter by date" /></div>');		

			
			
             if (htmlentities($_POST['filterbyDate'])=='filter by date')
             {
                 $this->addText("<table class='gcAdmin_userLst' cellspacing='0'>");
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
                        $this->confirmUser($user);
                }
                $this->addText("</table><br/><br/><input type='submit' value='send confirmation email' name='emailusers' />");
			}
			$this->addText("</form><br/>$HomePageLink");
		}
		else if (htmlentities($_GET['perform'])=='emailcharles')
		{
			$body = "Dear Charles\n\nThis is a message from future Charles. I've written this to warn you to watch out for the coffee, it's been poisoned.\n\nFuture messages will follow.\n\nYours truley\n\nFuture Charles";
			
			$user = new User();
			$user->mName = 'Charles.degrasse';
			$user->mFrom = 'name';
			$user->load();
			$user->sendMail('watchout for the coffee', $body, $user->mEmail);
			$this->addText("message sent, $HomePageLink");
		}
		else if (htmlentities($_GET['perform'])=='maillog')
		{
			if( file_exists ($maillog) )
			{
				$logfile = `tail -n 2000 $maillog`;
				$lines = explode( "\n", $logfile);
	
				//$lines = file($maillog);

				$count = count($lines);
				for ($i = $count-2001; $i < $count; $i++) {
					if ( strpos($lines[$i], ': to=') !== FALSE )
						$this->addText('<span style="white-space:nowrap;background:#cccccc;">' . htmlspecialchars($lines[$i]) . "</span><br />\n");
					else
						$this->addText('<span style="white-space:nowrap;">' . htmlspecialchars($lines[$i]) . "</span><br />\n");
				}
			}
			else
			{
				$this->addText("<p>Can't open maillog</p>");
			}
		}
		else
		{
			$this->addText("A list of administrative functions for GCPEDIA<br/><br/>");
			$this->addText(GCPath::htmlLink($url.'perform=comfirmemail','Send unconfirmed email confirmations')."<br/>");
			$this->addText(GCPath::htmlLink($url.'perform=maillog','View maillog (last 2000 lines, Takes a minute to load!)')."<br/>");
			$this->addText(GCPath::htmlLink($url.'perform=emailcharles','Send charles an email from future charles')."<br/>");
			$this->addText("<br />Sendmail: ");
			if( file_exists ($maillog) )
			{
				$output = `tail -n 1 $maillog`;
				//if ( (strpos($output, "Connection refused by [127.0.0.1]") !== FALSE) && (strpos($output, "Permission denied") !== FALSE) )
				if ( strpos($output, "stat=Sent") === FALSE )
				{
					$this->addText('<span style="color:red;"<b>DOWN</b><br/>');
				}
				else
				{
					$this->addText('<span style="color:green;"<b>UP</b><br/>');
				}
			}
			else
			{
				$this->addText('<span style="color:red;"<b>Can\'t open maillog</b><br/>');
			}
		}
	}

    function confirmUser(&$user)
    {
        if(!$user->isEmailConfirmed())
        {
            $registrationDate = date( "Y m d" , strtotime($user->getRegistration()) );

            $line = "<tr>
                        <td><input name='$user->mId' type='checkbox' /></td>
                        <td style='color: #a00;'>$user->mId</td>
                        <td style='font-weight: bold'>$user->mName</td>
                        <td>$user->mEmail</td>
                        <td>( <span style='color: #888;'>registered:</span> $registrationDate )</td>
                    </tr>";
            $this->addText("$line");
        }
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
}
?>
