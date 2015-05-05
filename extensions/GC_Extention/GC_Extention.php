<?php
/* 
 * GCPEDIA EXTENTION
 */

//error_reporting(~E_ALL & ~E_NOTICE);

$extention_path = $IP.'/extensions/GC_Extention/';

require_once( $extention_path."GCClasses.php" );

/* install access control utility */
#require_once( $extention_path."GC_accesscontrolSettings/accesscontrolSettings.php" );
#include( $extention_path."GC_accesscontrolSettings/accesscontrol.php" );

/* install language selector utility */
require_once( $extention_path."GC_LanguageSelector/LanguageSelector.php" );
$wgLanguageSelectorLanguages = array("en", "fr");
$wgLanguageSelectorLocation = LANGUAGE_SELECTOR_AT_TOP_OF_TEXT;
$wgLanguageSelectorDetectLanguage = LANGUAGE_SELECTOR_PREFER_CLIENT_LANG;

/* install gcadmin special page */
//require_once( $extention_path."specialPages/SpecialGCAdmin.php" );

?>
