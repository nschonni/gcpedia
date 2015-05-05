<?php
 
/**
* Special page to confirm a user's email address
* The user must have an email address specified for this to work
* (really this should only be used in lieu of the link in the email when the email isn't getting through)
* No logging is performed. Instead, an email is sent to that user notifying them of the confirmation.
*/
 
if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}
 
$wgExtensionCredits['specialpage'][] = array(
'name' => 'Confirm Users Email',
'author' => 'Ryan Schmidt',
'url' => 'http://www.mediawiki.org/wiki/Extension:ConfirmUsersEmail',
'version' => '2.0',
'description' => 'Allows bureaucrats to set other users as emailconfirmed',
);
$wgAutoloadClasses['ConfirmUsersEmail'] = dirname( __FILE__ ) . '/ConfirmUsersEmail.page.php';
$wgSpecialPages['ConfirmUsersEmail'] = 'ConfirmUsersEmail';
$wgAvailableRights[] = 'confirmusersemail';
 
$wgExtensionFunctions[] = 'efConfirmUsersEmail';
 
/**
* Determines who can use the extension; as a default, bureaucrats are permitted
*/
$wgGroupPermissions['bureaucrat']['confirmusersemail'] = true;
//Allows other users to set and change (and view) email addresses of other users
#$wgGroupPermissions['bureaucrat']['setemail'] = true;
 
/**
* Populate the message cache and register the special page
*/
function efConfirmUsersEmail() {
	global $wgMessageCache;
	require_once( dirname( __FILE__ ) . '/ConfirmUsersEmail.i18n.php' );
	foreach( efConfirmUsersEmailMessages() as $lang => $messages )
	$wgMessageCache->addMessages( $messages, $lang );
}