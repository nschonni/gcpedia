<?php

function acClassError()
{
	global $path;
	$file_loc = __FILE__;
	echo <<<END
	<div style="border: 1px solid red;">
			<div style="border-bottom: 1px solid red; color: red; font-weight: bold;">GC ACCESS CONTROL EXENTION ERROR</div>
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
}

if (!in_array('GCPath',get_declared_classes()))
{
	global $path, $IP;
	if (is_file("$path[1]/GCClasses.php"))
	{
		if (!require_once("$path[1]/GCClasses.php"))
			acClassError();
	}
	else
		acClassError();
}

$wgWikiVersion 							= 1.7;						// Set this to 1.6 or higher, if you use mediaWiki 1.6.X, this is for compatibility reasons
$wgAccessControlAnonymousGroupName 		= "anon";			// The name of the group the anonymous users belongs to
$wgAccessControlDisableMessages 			= true; // if false, show a Line on Top of each secured Page, which says, which Groups are allowed to see this page.
$wgAccessControlGroupPrefix 			= "Usergroup"; // The Prefix for the Usergroup-Pages
//$wgAccessControlNoAccessPage 			= $wgScriptPath . "?title=No_Access"; // To this Page will these users redirected who are not allowed to see the page.


## 
$wgAccessControlNoAccessPage 			= GCPath::pageURL('No_Access');
$wgUseMediaWikiGroups 					= false; // use the groups from MediaWiki instead of own Usergroup pages
$wgAdminCanReadAll 						= true; // sysop users can read all restricted pages
$wgGroupLineText 						= "This page is only accessible for group %s !!!"; // The text for the showing on the restricted pages, for one group
$wgGroupsLineText 						= "This page is only accessible for group %s !!!"; // The text for the showing on the restricted pages, for more than one group
$wgAccesscontrolDebug 					= false;	// Debug log on
$wgAccesscontrolDebugFile 				= "$IP/config/debug.txt";	// Path to the debug log
$wgAccessControlEditGroupPrefix			= "acAdmin";

## 
foreach($wgGroupPermissions['user'] as $key => $value)
	$wgGroupPermissions[$wgAccessControlEditGroupPrefix][$key] = $value;

?>
