<?php
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if (!defined('MEDIAWIKI'))
{
	echo "To install this extension, put the following line in LocalSettings.php: require_once( '\$IP/extensions/MyExtension/MyExtension.php' );";
    exit( 1 );
}
 
global $gc_site_path, $wgExtentionCredits, $wgAutoloadClasses, $wgExtensionMessagesFiles, $wgExtensionAliasesFiles, $wgSpecialPages;

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Logout Message',
	'author' => 'GCPEDIA Administration',
	'url' => $gc_site_path.'Extension:LogoutMessage',
	'description' => 'Tells user when logged out',
	'descriptionmsg' => 'gcAdmin-desc',
	'version' => '0.0.1',
);
 
$dir = dirname(__FILE__) . '/';
 
$wgAutoloadClasses['LogoutMsg'] = $dir . 'SpecialLogoutMsg_body.php'; # Tell MediaWiki to load the extension body.
$wgExtensionMessagesFiles['LogoutMsg'] = $dir . 'SpecialLogoutMsg.i18n.php';
$wgExtensionAliasesFiles['LogoutMsg'] = $dir . 'SpecialLogoutMsg.alias.php';
$wgSpecialPages['LogoutMsg'] = 'LogoutMsg'; # Let MediaWiki know about your new special page.
	
?>