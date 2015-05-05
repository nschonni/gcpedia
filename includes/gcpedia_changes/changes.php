<?	
/***********************************************************************************************************************************************************/
/***********************/
/***       CLASSES  	   ***/
/**********************/

// Static class used for adding test output
class GCOut
{
	static 	$display_tests = true;
	
	static $output;
	
	static function add($text)
	{
		self::$output .= $text;
	}
	
	static function getOutput()
	{
		if (self::$display_tests)
			return self::$output;
		else
			return "";
	}
	
	static function addArray($array)
	{
		if(is_array($array))
			foreach($array as $key => $value)
				self::$output .= "$key => $value <br/>";
	}
}

// Static class used for generating include and url paths. Also safely adds include files and logs successful and unsuccessful includes in the GCOut::output variable
class GCPath
{
	const gcIncludePath = "includes/gcpedia_changes";
	const show_bad_include = false;
	const show_includes = false;
	
	static function pageURL($page=false)
	{
		global $wgServer, $wgScriptPath;
		$site_path = $wgServer.$wgScriptPath;
		if($page)
			return "$site_path/index.php/$page";
		else
			return $site_path;
	}
	
	static function gcIncludeURL($file=false)
	{
		if($file)
			return self::gcIncludePath."/$file";
		else
			return self::gcIncludePath;
	}
	
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

GCPath::includeFile(GCPath::gcIncludeURL("/specialPages/SpecialGCAdmin.php")); // special page containing administration functions


/***********************************************************************************************************************************************************/

/********************/
/***	 HOOKS	 ****/
/********************/

global $wgHooks;
$wgHooks['OutputPageBeforeHTML'][] 					= 'testOutput';				// used for outputing test data;

/***********************************************************************************************************************************************************/

/*****************************/
/***	 HOOK FUNCTION	***/
/*****************************/

function testOutput(&$out, &$text)
{	
	$out->addHTML(GCOut::getOutput());
	
	return true;
}

/***********************************************************************************************************************************************************/
	
?>