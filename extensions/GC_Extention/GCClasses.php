<?	
/***********************************************************************************************************************************************************/
/***********************/
/***       CLASSES  	   ***/
/**********************/


/*
	GCOUT CLASS
	-----------------------------------------------------------------------------------------------------------------------
	
	Class used to collect testing and debugging data to later be displayed in mediawiki. 
	
	It main used comes in using it in conjunction with a mediawiki hook to safely display the output (one is already set in the hooks section, further below)
	
	-----------------------------------------------------------------------------------------------------------------------
*/
class GCOut
{
	static 	$display_tests 					= true;			// toggles whether tests are actually displayed when getOutput() is called
	static 	$collapse_error_box_by_default	= 'false';		// sets where the dialogs created by the addErrorBox() are collapsed by default or not
	
	static $output;											// main output buffer or container containing an output in string format
	
	/*
		add text to the output buffer
		
		@arguments:
			$text:		a string with the text you wish to add
		
		contract:
			precondition:	$text be a string safe data type
	*/
	static function add($text)
	{
		self::$output .= $text;
	}
	
	// clears the output buffer
	static function clear()
	{
		self::$output = "";
	}
	
	/*
		getOuput()
		-----------------------------------------------------------------------------------------------------------------------
		
		returns the string contained within the output buffer if the local static variable $display_tests is set to true
		
		@return:
			type:			string
			value:			output buffer value (self::$output)
		
		contract:
			postcondition:	return assignment value must be a string safe data container
	
		-----------------------------------------------------------------------------------------------------------------------
	*/
	
	static function getOutput()
	{
		if (self::$display_tests)
			return self::$output;
		else
			return "";
	}
	
	/*
		addArray()
		-----------------------------------------------------------------------------------------------------------------------
		
		adds an array to the output buffer in the string format 'array_key => array_value \n'
		
		@arguments
			$array:		an array of elements used to add to the output buffer
		
		contract:
			precondition:	argument must be an array data type

		-----------------------------------------------------------------------------------------------------------------------
	*/
	static function addArray($array)
	{
		if(is_array($array))
			foreach($array as $key => $value)
				self::$output .= "$key => $value <br/>";
	}
	
	/*
		addErrorBox()
		-----------------------------------------------------------------------------------------------------------------------
		adds an error dialog (in html/css/javascript format) to be displayed to screen. the dialog initiates a traceback 
		to where it was called and displayed the traceback information with the $title and $message arguments passed.
		Additionally if the $continue argument is false the php is stopped and the error is output using the die() 
		function
		
		@arguments:
			$title:				the title of the dialog box
			$message:				an additional message providing additional error information
			$continue	(default: true):	continue running php or die and post the outPage as the error	
		
		contract:	
			precondition: 			$title, $message arguments must be of type string
								$continue arugment must be of type boolean

		-----------------------------------------------------------------------------------------------------------------------
	*/
	static function addErrorBox($title, $message, $continue=true)
	{
		$traceback_array 	= debug_backtrace();
		$file 				= $traceback_array[0]['file'];
		$line 				= $traceback_array[0]['line'];
		
		$traceback 			= 
<<<END
<tr><td class='td_title'>File:		</td>	<td>$file		</td></tr>
<tr><td class='td_title'>Line:		</td>	<td>$line		</td></tr>
END;
		
		$title 				= " | ERROR: ".strtoupper($title);
		$closed_on_load		= self::$collapse_error_box_by_default;
		
		$output 			= 
<<<END

<script type="text/javascript">

var closed_on_load = $closed_on_load;

var title = '$title';

function hideErrorBox()
{	
	document.getElementById('test_title').onclick = toggleErrorBox;
	
	if (closed_on_load)
	{
		document.getElementById('test_contents').style.display = "None";
		document.getElementById('test_title').innerHTML = "+" + title;
	}
	else
		document.getElementById('test_title').innerHTML = "-" + title;
}

function toggleErrorBox()
{	
	if (document.getElementById('test_contents').style.display == "none")
	{
		document.getElementById('test_contents').style.display = "Block";
		document.getElementById('test_title').innerHTML = "-" + title;
	}
	else
	{
		document.getElementById('test_contents').style.display = "None"
		document.getElementById('test_title').innerHTML = "+" + title;
	}
}

window.onload = hideErrorBox;

</script>

<style type="text/css">
	#test_container
	{
		border: 			2px solid black;
		background-color:	#eee;
	}
	#test_title
	{
		border-bottom:		2px solid black;
		background-color:	#aaa;
		padding-left: 		5px;
		color:				#fff;
		font-weight:		bold;
	}
	
	#closeBttn
	{
		text-align: right;
	}
	
	#test_contents
	{
		padding: 			10px;
	}
	
	#test_contents table
	{
		background-color: 	#eee;
	}
	
	#test_contents table tr .td_title
	{
		padding-right: 		20px;
		color: 				red;
	}
	
</style>
	 
<div id="test_container">

	<div id="test_title">$title</div>
	<div id="test_contents">
		<table>
			<tr><td class='td_title'>Message:</td><td>$message</td></tr>
			$traceback
		</table>
	</div>

</div>

END;
		self::add($output);

		if (!$continue)
			die(self::getOutput());
	}
}




/*
	GCPATH CLASS
	-----------------------------------------------------------------------------------------------------------------------
	
	a static class used for generating include and url paths. Also safely adds include files and logs successful and unsuccessful includes in the GCOut::output variable
	this is necessary with mediawiki due to the fact that the pagenames are appended to a default page, generally index.php

	contract:
		precondition:	requires the GCOut Class

	-----------------------------------------------------------------------------------------------------------------------
*/


class GCPath
{
	const gcIncludePath 		= "includes/gcpedia_changes";
	const index					= "/index.php";
	const show_bad_include 		= false;
	const show_includes 		= false;
	
	/*
		pageURL()
		-----------------------------------------------------------------------------------------------------------------------
		
		generates a mediawiki based url based on the pagename passed through the $page argument variable

		@arguments
			$page		a string that contains the name of the mediawiki page
		
		@return
			type:			string
			value:			the webpage url for the mediawiki page requested
			
		contract:
			precondition:	requires the following mediawiki globals to be set
							$wgServer
							$wgScriptPath
							$wgArticlePath
			
			postcondition:	requires a variable of type string to accept the return value

		-----------------------------------------------------------------------------------------------------------------------
	*/
	static function pageURL($page='')
	{
		global $wgServer, $wgScriptPath, $wgArticlePath;
		$site_path = $wgServer.$wgScriptPath;
		
		if ($wgArticlePath)
			$normal_path = $wgArticlePath;
		else
			$normal_path = $site_path.self::index."/$1";
			
		switch(func_num_args())
		{
			case 0:
				return $site_path; break;
			case 1:
				return str_replace("$1",$page,$normal_path); break;
			default:
				$url = "$site_path".self::index."?title=$page";
				$args = func_get_args();
				array_shift($args);
				foreach ($args as $getVar)
				{
					if(is_array($getVar))
						$url .= self::addMultipleGet($getVar);
					elseif(is_string($getVar))
						$url .= "&$getVar";
				}
				return $url;
				break;
		}
	}
	
	/*
		addMultipleGet()
		-----------------------------------------------------------------------------------------------------------------------
		
		creates a string of GET variables, appendable to a url, from the key => value pairs of the passed array

		@arguments
			$array		an array of 'variable name' => 'variable value' pairs describing a set of GET variables to be created
		
		@return
			type:			string
			value:			a url ready list of GET variables

		contract:
			precondition:	arguments must be an array
						argument must contain key => value pairs that describe the variable name => variable value of the GET variables

			postcondition:	return container must be able to contain a string
						must be appended to a url that already contains one GET variable

		-----------------------------------------------------------------------------------------------------------------------
	*/
	static function addMultipleGet($array)
	{
		$getList;
		if (is_array($array))
			foreach ($array as $key => $value)
				$getList .= "&$key=$value";
		return $getList;
	}
	
	/*
		gcIncludeURL()
		-----------------------------------------------------------------------------------------------------------------------
		
		creates an include path based on the path set in self::gcIncludePath

		@arguments
			$file		a string containing the filename of the file to be included
		
		@return
			type:		string
			value:		the completed path to the file location
			
		contract:
			precondition:	$file must be of type string or a NULL value
			
			postcondition:	return container must be able to conation a string

		-----------------------------------------------------------------------------------------------------------------------
	*/
	static function gcIncludeURL($file=false)
	{
		if($file)
			return self::gcIncludePath."/$file";
		else
			return self::gcIncludePath;
	}
	
	/*
		includeFile()
		-----------------------------------------------------------------------------------------------------------------------
		
		a function used to include files without producing php errors if the file fails to include. 
		
		the function also logs all files that are included as well as files that fail to include. the messages are toggled based on the variables GCPath::show_includes, GCPath::show_bad_include

		@arguments
			$path			a string containing the file path
		
		@return
			type:			boolean
		
		contract:
			precondition:	$path must be of type string
			
			postcondition:	return container must be able to handle type boolean

		-----------------------------------------------------------------------------------------------------------------------
	*/
	static function includeFile($path)
	{
		/* checks if file exists */	
		if(is_file($path))
				if (include_once $path)
				{
					if (GCPath::show_includes)
					{
						GCOut::add("<div style='border: 1px solid green; padding: 5px;'><div style='color: green; border-bottom: 1px solid green;'>INCLUDE:</div><br/>path: $path<br/>");
						$debug = debug_backtrace();
						foreach( $debug[0] as $key => $value)
							GCOut::add("$key: $value<br/>");
						GCOut::add("</div>");
					}
					return true;
				}
		
		/* setting if set to "true" will display on user screen include inforation for bad illegal includes */	
		if(GCPath::show_bad_include)
		{
			GCOut::add("<div style='border: 1px solid red; padding: 5px;'><div style='color: red; border-bottom: 1px solid red;'>INCLUDE ERROR:</div><br/>path: $path<br/>");
			$debug = debug_backtrace();
			foreach( $debug[0] as $key => $value)
					GCOut::add("$key: $value<br/>");
			GCOut::add("</div>");
		}
		
		return false;
	}
	
	/*
		htmlLink()
		-----------------------------------------------------------------------------------------------------------------------
		
		generates an html link based on argument parameters

		@arguments
			$url:				the hypertext reference of the anchor container
			$text:			the text that will represent the link
			$id (default NULL):	the id of the anchor container
			$title default NULL):	the title of the anchor container
		
		@return
			type: 				string
			value:				an HTML anchor based on the arugments provided
		contract:
			precondition:		$url must be of type string or an array
							$text must be of type string
			
			postcondition:		return container must be able to handle type string

		-----------------------------------------------------------------------------------------------------------------------
	*/
	static function htmlLink($url, $text, $id='', $title='')
	{
		if (is_array($url))
		{
			$link = "<a";
			foreach($url as $key => $value)
				$link .= " $key='$value'";
			$link .= ">$text</a>";
				
			return $link;
		}
		
		if($id)
			$id = "id='$id'";
		if($title)
			$title="title='$title'";
		
		return "<a $id href='".$url."' $title>$text</a>";
	}
}

/***********************************************************************************************************************************************************/

/***********************/
/***       GLOBALS   	   ***/
/**********************/


// add any here


	
/***********************************************************************************************************************************************************/

/***********************/
/***	 FUNCTIONS	   ***/
/**********************/

/*** functions used throughout the mediawiki app ***/



/***********************************************************************************************************************************************************/
	
/***********************/
/***	 SPECIAL PAGES	   ***/
/**********************/

//GCPath::includeFile(GCPath::gcIncludeURL("/specialPages/SpecialGCAdmin.php")); // special page containing administration functions


/***********************************************************************************************************************************************************/

/********************/
/***	 HOOKS	 ****/
/********************/

global $wgHooks;
$wgHooks['OutputPageBeforeHTML'][] = 'testOutput';				// used for outputing test data from GCOut to the mainpage by default;

/***********************************************************************************************************************************************************/

/*****************************/
/***	 HOOK FUNCTION	***/
/*****************************/

/*
	testOutput()
	-----------------------------------------------------------------------------------------------------------------------

	used for adding the static output from the GCOut class to the mainpage
	
	contract:
		precondition:	to be called only through the 'OutputPageBeforeHTML' mediawiki hook callback which must pass arguments
						$out as an OutputPage object
						$text as a HTML string
					Class GCOut required
	
	-----------------------------------------------------------------------------------------------------------------------
*/
function testOutput(&$out, &$text)
{	
	$out->addHTML(GCOut::getOutput());
	
	return true;
}

/***********************************************************************************************************************************************************/
	
?>