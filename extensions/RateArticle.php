<?php
require('Ratings/_drawrating.php'); 
if ( ! defined( 'MEDIAWIKI' ) )
	die();

//--------------------------------------------------
// See http://www.leerwiki.nl for either updates
// or other extensions such as the Ajax Rating Script-,
// Image shadow- or EditpageMultipleInputboxes extension. 
// good luck with your Wiki! 
// B.Vahrmeijer
//----------------------------------------------------

$wgExtensionCredits['parserhook'][] = array(
'name' => 'AJAX RATING BAR V2.5 25-09-2007 Based on Masugadesign',
'author' => 'Boudewijn Vahrmeijer',
'url' => 'http://www.leerwiki.nl',
'version' => '1.11,1.10.1/1.9.3/1.9.2/1.8.2',
'description' => 'Ajax Rating Bar for MediaWiki',
);

########## Settings ##########
$pathToRating='/extensions/Ratings/'; //if your path is www.yoursite.com/wiki than change this to /wiki/extensions


########## Hooks #############
$wgHooks['SkinTemplateSetupPageCss'][] = array("wfAjaxScriptRSS");    
$wgHooks['BeforePageDisplay'][] = array("wfRateArticleForm");


########## Functions #########
function wfAjaxScriptRSS(&$out) {
	global $pathToRating;
$out='/*<![CDATA[*/
			@import "'.$pathToRating.'css/rating.css";
		/*]]>*/';

return true;
}

function wfRateArticleForm(&$out) {
	global $wgArticle,$pathToRating;
	if ($wgArticle == null) return $out;	
	if ($wgArticle->getTitle()->mNamespace != 0) return  $out;

	$out->mBodytext.='<script type="text/javascript" language="javascript" src="'.$pathToRating.'js/behavior.js"></script>';
	$out->mBodytext.='<script type="text/javascript" language="javascript" src="'.$pathToRating.'js/rating.js"></script>';
	//$out->mBodytext.='<link rel="stylesheet" type="text/css" href="'.$pathToRating.'css/rating.css" />';
	//die($wgArticle->getID());
	
	$out->mBodytext.=rating_bar($wgArticle->getID(),5);
	
	return $out;
}

?>