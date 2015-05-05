<?php
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if (!defined('MEDIAWIKI'))
{
	echo "To install this extension, put the following line in LocalSettings.php: require_once( '\$IP/extensions/MyExtension/MyExtension.php' );";
    exit( 1 );
}
 
global $gc_site_path, $wgExtentionCredits, $wgAutoloadClasses, $wgExtensionMessagesFiles, $wgExtensionAliasesFiles, $wgSpecialPages;

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'GCAdmin',
	'author' => 'GCPEDIA Administration',
	'url' => $gc_site_path.'Extension:GCAdmin',
	'description' => 'Administration functions for GCPEDIA',
	'descriptionmsg' => 'gcAdmin-desc',
	'version' => '0.0.1',
);
 
$dir = dirname(__FILE__) . '/';
 
$wgAutoloadClasses['GCAdmin'] = $dir . 'SpecialGCAdmin_body.php'; # Tell MediaWiki to load the extension body.
$wgExtensionMessagesFiles['GCAdmin'] = $dir . 'SpecialGCAdmin.i18n.php';
$wgExtensionAliasesFiles['GCAdmin'] = $dir . 'SpecialGCAdmin.alias.php';
$wgSpecialPages['GCAdmin'] = 'GCAdmin'; # Let MediaWiki know about your new special page.
	
?>