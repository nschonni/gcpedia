<?php
/**
 * LanguageSelector extension - language selector on every page, also for visitors
 *
 * Features:
 *  * Automatic detection of the language to use for anonymous visitors
 *  * Ads selector for preferred language to every page (also works for anons)
 *
 * This can be combined with Polyglot and MultiLang to provide more internationalization support.
 *
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2007 Daniel Kinzler
 * @licence GNU General Public Licence 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

// check for the required gc classes
function lsClassError()
{
	global $path;
	$file_loc = __FILE__;
	echo 
<<<END
	<div style="border: 1px solid red;">
			<div style="border-bottom: 1px solid red; color: red; font-weight: bold;">GC LANGUAGE SELECTOR EXENTION ERROR</div>
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
			lsClassError();
	}
	else
		lsClassError();
}

$wgExtensionCredits['other'][] = array( 
	'name'           => 'Language Selector', 
	'author'         => 'Daniel Kinzler', 
	'url'            => 'http://mediawiki.org/wiki/Extension:LanguageSelector',
	'svn-date' => '$LastChangedDate: 2008-05-06 11:59:58 +0000 (Tue, 06 May 2008) $',
	'svn-revision' => '$LastChangedRevision: 34306 $',
	'description'    => 'language selector on every page, also for visitors',
	'descriptionmsg' => 'languageselector-desc',
);

define( 'LANGUAGE_SELECTOR_USE_CONTENT_LANG',    0 ); #no detection
define( 'LANGUAGE_SELECTOR_PREFER_CONTENT_LANG', 1 ); #use content language if accepted by the client
define( 'LANGUAGE_SELECTOR_PREFER_CLIENT_LANG',  2 ); #use language most preferred by the client

/**
* Language detection mode for anonymous visitors.
* Possible values:
* * LANGUAGE_SELECTOR_USE_CONTENT_LANG - use the $wgLanguageCode setting (default content language)
* * LANGUAGE_SELECTOR_PREFER_CONTENT_LANG - use the $wgLanguageCode setting, if accepted by the client
* * LANGUAGE_SELECTOR_USE_CONTENT_LANG - use the client's preferred language, if in $wgLanguageSelectorLanguages
*/
$wgLanguageSelectorDetectLanguage = LANGUAGE_SELECTOR_PREFER_CLIENT_LANG; 

/**
* Languages to offer in the language selector. Per default, this includes all languages MediaWiki knows
* about by virtue of $wgLanguageNames. A shorter list may be more usable, though.
* If the Polyglot extension is installed, $wgPolyglotLanguages is used as fallback.
*/
$wgLanguageSelectorLanguages = NULL;

define( 'LANGUAGE_SELECTOR_MANUAL',    			0 ); #don't place anywhere
define( 'LANGUAGE_SELECTOR_AT_TOP_OF_TEXT', 	1 ); #put at the top of page content
define( 'LANGUAGE_SELECTOR_IN_TOOLBOX',  		2 ); #put into toolbox
define( 'LANGUAGE_SELECTOR_AS_PORTLET', 		3 ); #as portlet
define( 'LANGUAGE_SELECTOR_INTO_SITENOTICE', 	11); #put after sitenotice text
define( 'LANGUAGE_SELECTOR_INTO_TITLE', 		12); #put after title text
define( 'LANGUAGE_SELECTOR_INTO_SUBTITLE', 		13); #put after subtitle text
define( 'LANGUAGE_SELECTOR_INTO_CATLINKS', 		14); #put after catlinks text

$wgLanguageSelectorLocation;

///// hook it up /////////////////////////////////////////////////////
$wgHooks['AbortNewAccount'][] = 'wfLanguageSelectorAbortNewAccount'; //abuse hook to inject default language option //FIXME: doesn't quite work it seems :(

// GCPEDIA CHANGE: this gets the current value of the cookie set by this exention, it is used by the hook function onUserCreation to determine the user's preferred language, see the function for more detail
// kept around mostly incase referenced somewhere else but using gcGetUserLanguage() function directly is preferable
$gc_userLang = gcGetUserLanguage();
	
// GCPEDIA CHANGE: add some hooks! see the functions for more details
$wgHooks['AddNewAccount'][]	= 'onUserCreation';			// hook for when a user account is created, creating it in their language of choice

$wgExtensionFunctions[] = "wfLanguageSelectorExtension";

$wgLanguageSelectorRequestedLanguage = NULL;

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['LanguageSelector'] = $dir . 'LanguageSelector.i18n.php';


function wgLanguageSelectorSetHook() {
	global $wgParser;
	$wgParser->setHook('languageselector', 'wfLanguageSelectorTag' );
	return true;
	}

function wfLanguageSelectorExtension() {
	wfLoadExtensionMessages( 'LanguageSelector' );
	global $wgLanguageSelectorLanguages, $wgLanguageSelectorDetectLanguage, $wgLanguageSelectorRequestedLanguage, $wgLanguageSelectorLocation;
	global $wgUser, $wgLang, $wgRequest, $wgCookiePrefix, $wgCookiePath, $wgOut, $wgJsMimeType, $wgHooks;
	
	if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
		$wgHooks['ParserFirstCallInit'][] = 'wgLanguageSelectorSetHook';
	} else {
		wgLanguageSelectorSetHook();
	}

	if ( $wgLanguageSelectorLanguages === NULL ) {
		$wgLanguageSelectorLanguages = @$GLOBALS['wgPolyglotLanguages'];
	}
	
	if ( $wgLanguageSelectorLanguages === NULL ) {
		$wgLanguageSelectorLanguages = array_keys( Language::getLanguageNames( true ) );
	}

	$setlang = $wgRequest->getVal('setlang');
	if ($setlang && !in_array($setlang, $wgLanguageSelectorLanguages)) $setlang = NULL; //ignore invalid

	if ($setlang) {
		setcookie($wgCookiePrefix.'LanguageSelectorLanguage', $setlang, 0, $wgCookiePath);
		$wgLanguageSelectorRequestedLanguage = $setlang;
	}
	else {
		$wgLanguageSelectorRequestedLanguage = @$_COOKIE[$wgCookiePrefix.'LanguageSelectorLanguage'];
	}

	if ( !$wgUser->isAnon() && $setlang ) {
		if ($setlang != $wgUser->getOption('language')) {
			$wgUser->setOption('language', $wgLanguageSelectorRequestedLanguage);
			$wgUser->saveSettings();
		}
	}

	if ( $wgUser->isAnon() && !$wgRequest->getVal( 'uselang' )) {

		//NOTE: we need this for anons, so squids don't get confused.
		//      but something is still wrong with caching...
		header('Vary: Cookie', false); //hrm, this is pretty BAD.
		header('Vary: Accept-Language', false);
		 
		if ( $wgLanguageSelectorRequestedLanguage || $wgLanguageSelectorDetectLanguage != LANGUAGE_SELECTOR_USE_CONTENT_LANG ) {

			if (!class_exists('StubAutoLang')) {
				class StubAutoLang extends StubObject {
					function __construct() {
						parent::__construct( 'wgLang' );
					}
				
					function __call( $name, $args ) {
						return $this->_call( $name, $args );
					}
				
					//partially copied from StubObject.php. There should be a better way...
					function _newObject() {
						global $wgContLanguageCode, $wgContLang, $wgLanguageSelectorDetectLanguage, $wgLanguageSelectorRequestedLanguage;
	
						$code = $wgLanguageSelectorRequestedLanguage;
						if (!$code) $code = wfLanguageSelectorDetectLanguage($wgLanguageSelectorDetectLanguage);
				
						if( $code == $wgContLanguageCode ) {
							return $wgContLang;
						} else {
							$obj = Language::factory( $code );
							return $obj;
						}
					}
				}
			}
	
			$wgLang = new StubAutoLang;
		}
	}
	
	global $wgUser;
	
	if ($wgLanguageSelectorLocation != LANGUAGE_SELECTOR_MANUAL)
	{ 										// kept around just in case: && ( $wgUser->mRealName == "" || !(isset($wgUser->mRealName)))) {
		switch($wgLanguageSelectorLocation) 
		{
			case LANGUAGE_SELECTOR_AT_TOP_OF_TEXT: $wgHooks['BeforePageDisplay'][] = 'wfLanguageSelectorBeforePageDisplay'; break;
			case LANGUAGE_SELECTOR_IN_TOOLBOX: $wgHooks['MonoBookTemplateToolboxEnd'][] = 'wfLanguageSelectorSkinHook'; break;
			// GCPEDIA CHANGE: able to add to sidebar now
			case LANGUAGE_SELECTOR_AT_TOP_OF_SIDEBAR: $wgHooks['BeforeSideBar'][] = 'wfLanguageSelectorBeforeSidebarDisplay'; break;
			case LANGUAGE_SELECTOR_AT_TOP_OF_MAINPAGE: $wgHooks['BeforePageContent'][] = 'gcLanguageSelectorBeforePageDisplay';
			default:
				$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'wfLanguageSelectorSkinTemplateOutputPageBeforeExec'; break;
		}
	}

	$wgOut->addScript('<script type="'.$wgJsMimeType.'">
		addOnloadHook(function() { 
			var i = 1;
			while ( true ) {
				var btn = document.getElementById("languageselector-commit-"+i);
				var sel = document.getElementById("languageselector-select-"+i);
				var idx = i;

				if (!btn) break;

				btn.style.display = "none";
				sel.onchange = function() { this.parentNode.submit(); };

				i++;
			}
		});
	</script>');
}

// GCPEDIA CHANGE: new function to handle output for sidebar hook
function wfLanguageSelectorBeforeSidebarDisplay(&$out, &$sk) {
	
	$out->addHTML('<div style="font-weight: bold; text-align: center; width: 150px;">Language of Choice</div>');
	$out->addHTML('<div style="width: 145px; border: 1px solid #aaa; text-align: center; padding: 20px 0px 20px 0px; margin-left: 5px; background-color: #ddd;">');
	$out->addHTML(wfLanguageSelectorHTML());
	
	return true;
}

function wfLanguageSelectorBeforePageDisplay( &$out ) {
	$html = wfLanguageSelectorHTML();
	$out->mBodytext = $html . $out->mBodytext;
	return true;
}

function wfLanguageSelectorSkinHook( &$out ) {
	$html = wfLanguageSelectorHTML();
	print $html;
	return true;
}

function wfLanguageSelectorTag($input, $args) {
	$style = @$args['style'];
	$class = @$args['class'];
	$selectorstyle = @$args['selectorstyle'];
	$buttonstyle = @$args['buttonstyle'];

	if ($style) $style = htmlspecialchars($style);
	if ($class) $class = htmlspecialchars($class);
	if ($selectorstyle) $selectorstyle = htmlspecialchars($selectorstyle);
	if ($buttonstyle) $buttonstyle = htmlspecialchars($buttonstyle);

	return wfLanguageSelectorHTML( $style, $class, $selectorstyle, $buttonstyle );
}

function wfLanguageSelectorSkinTemplateOutputPageBeforeExec( &$skin, &$tpl ) {
	global $wgLanguageSelectorLocation, $wgLanguageSelectorLanguages;
	global $wgLang, $wgContLang, $wgTitle;

	if ($wgLanguageSelectorLocation == LANGUAGE_SELECTOR_AS_PORTLET) {
		$code = $wgLang->getCode();
		$lines = array();
		foreach ($wgLanguageSelectorLanguages as $ln) {
			$lines[] = array(
				$href = $wgTitle->getFullURL( 'setlang=' . $ln ),
				'text' => $wgContLang->getLanguageName($ln),
				'href' => $href,
				'id' => 'n-languageselector',
				'active' => ($ln == $code),
			);
		}
		
		$tpl->data['sidebar']['languageselector'] = $lines;
		return true;
	}

	$key = NULL;

	switch($wgLanguageSelectorLocation) {
		case LANGUAGE_SELECTOR_INTO_SITENOTICE: $key = 'sitenotice'; break;
		case LANGUAGE_SELECTOR_INTO_TITLE: $key = 'title'; break;
		case LANGUAGE_SELECTOR_INTO_SUBTITLE: $key = 'subtitle'; break;
		case LANGUAGE_SELECTOR_INTO_CATLINKS: $key = 'catlinks'; break;
	}
	
	if ($key) {
		$html = wfLanguageSelectorHTML();
		$tpl->set( $key, $tpl->data[ $key ] . $html );
	}

	return true;
}

function wfLanguageSelectorDetectLanguage($mode) {
	global $wgContLang, $wgLanguageSelectorLanguages;
	
	$contLang = $wgContLang->getCode();
	
	if (!$mode || $mode == LANGUAGE_SELECTOR_USE_CONTENT_LANG) {
		return $contLang;
	}

	/**
	* get accepted languages from Accept-Languages
	* HTTP header.
	*/
	$l= @$_SERVER["HTTP_ACCEPT_LANGUAGE"];
	
	if (empty($l)) return $contLang;
	
	$l= explode(',',$l);
	
	/**
	* normalize accepted languages
	*/
	$languages= array();
	foreach ($l as $lan) {
		$lan= trim($lan);
		
		$idx= strpos($lan,';');
		if ($idx !== false) {
			#FIXME: qualifiers are ignored, order is relevant!
			$lan= substr($lan,0,$idx);
			$lan= trim($lan);
		}

		$languages[]= $lan;
		
		$idx= strpos($lan,'-');
		if ($idx !== false) {
			$lan= substr($lan,0,$idx);
			$languages[]= $lan;
		}
	}

	/**
	* see if the content language is accepted by the 
	* client.
	*/
	if ( ($mode == LANGUAGE_SELECTOR_PREFER_CONTENT_LANG) 
		&& in_array($contLang,$languages) ) {
		return $contLang;
	}
	
	/**
	* look for a language that is acceptable to the client
	* and known to the wiki.
	*/
	foreach($wgLanguageSelectorLanguages as $code) {
		/**
		* TODO: only accept languages for which an implementation exists.
		*       this is disabled, because it's slow. Note that this code is
		*       executed for every page request!
		*/
		/*
		global $IP;
		$langfile="$IP/languages/Language".str_replace('-', '_', ucfirst($code)).".php";
		if(!file_exists($langfile)) {
			continue;
		}
		*/
		
		if (in_array($code,$languages)) {
			return $code;
		}
	}
		
	return $contLang;
}

function wfLanguageSelectorAbortNewAccount( &$u ) { //FIXME: doesn't quite work it seems :(
	global $wgUser;

	//inherit language;
	//if $wgUser->isAnon, this means remembering what the user selected
	//otherwise, it would mean inheriting the language from the user creating the account.
	if ($wgUser->isAnon()) {
		$u->setOption('language', $wgUser->getOption('language')); 
	}

	return true;
}

//GCPEDIA CHANGE: menu now created differently
function wfLanguageSelectorHTML( $style = NULL, $class = NULL, $selectorstyle = NULL, $buttonstyle = NULL) {
	global $wgLanguageSelectorLanguages, $wgTitle, $wgLang, $wgContLang, $wgScript, $pageLanguageVariants, $wgUser;

	
	$output = "";
	
	/*if ($wgUser->isLoggedIn())
		return $output;*/
	
	static $id = 0;
	$id += 1;

	$code = $wgLang->getCode();

	if ( !$wgUser->isLoggedIn() ){
		$output = "<br /><style type='text/css'> 
						/* the language button container */
						div .langLink 
						{ 
							display: block;
							float: left;
							height: 15px;
							width: 60px; 
							padding: 1px;
							padding-bottom: 4px;
							margin: 2px; 
							margin-top:6px; 
							margin-bottom:8px;
							border: 1px inset #f55;
							text-align:center;
							background-color: #f33;
							color: #fff;
						}
						
						/* the container for the two language buttons */
						div .langLinks 
						{ 
							width: 150px;
							float: left; 
							height: 30px;
							padding-top: 0;
							padding-bottom: 1%;
						} 
						
						/* the container for the entire language bar */
						div .langBox 
						{ 
							float: left;
							padding: 1px; 
							padding-bottom: 3px; 
							padding-right: 0px; 
							margin: 0px;
							border: 1px double #CCC;
							width: 100%;
						}
						
						/* the container for the message beside the buttons */
						div .langMsg
						{
							float: left;
							width: 75%;
							margin-left:6px; 
							margin-right:6px; 
							text-align:left; 
							font-size:85%;
						}
					</style>
		
					<div class='langBox'>
						<div class='langLinks'>";
	}
	else {
				$output = "<br /><style type='text/css'> 
						/* the language button container */
						div .langLink 
						{ 
							display: block;
							height: 15px;
							width: 60px; 
							padding: 1px;
							padding-bottom: 4px;
							margin: 0;
							border: 1px inset #f55;
							float: left;
							text-align:center;
							
							
							display: inline;
							border: 1px solid #aaa;
							border-bottom: none;
							padding: 0 0 .2em 0;
							margin: 0 .3em 0 0;
							overflow: visible;
							background: white;
							
							color: #002bb8;
							text-decoration: none;
							
						}
						
						div .langLink  .selected {
							border-color: #fabd23;
							padding: 0 0 .1em 0;
							font-weight: bold;

						}
						
						/* the container for the two language buttons */
						div .langLinks 
						{ 
							width: 130px;
							float: left; 
							height: 20px;
							padding-top: 0;
							padding-bottom: 0;
														
							position: absolute;
							top: -1.6em;
							left: 55em;
							margin: 0;
							white-space: nowrap;
							width: 133px;
							line-height: 1.4em;
							overflow: visible;
							background: none;
							border-collapse: collapse;
							padding-left: 1em;
							list-style: none;
							font-size: 95%;
						} 
						
						
						
					</style>
		
					<div class='langBox'>
						<div class='langLinks'>";
	}
	
	foreach ($wgLanguageSelectorLanguages as $ln) 
	{
		global $wgOut;
		$pagename = $wgTitle;
		$url = "";
		
		//No idea what this is trying to do but it does absolutely nothing but generate errors.
		// The array "$wgOut->getLanguageLinks();" is empty..
		$langarray = $wgOut->getLanguageLinks();
		if(!empty($langarray))
		{
			
			if ( substr( $langarray[0], 0, 2 ) == $ln )
				$pagename = substr( $langarray[0], 3, strlen( $langarray[0] ) );
		}
		
		if ($url == "")
			$url = GCPath::pageURL( $pagename, "setlang=$ln&uselang=$ln" );
		
		if ($ln == $code) 	$output .= "<div class='langLink' style='font-weight: bold;' lang='fr' xml:lang='$ln'>".$wgContLang->getLanguageName($ln)."</div>";
		else 				$output .= "<a class='langLink' style='' lang='en' xml:lang='$ln' href=\"".$url."\">".$wgContLang->getLanguageName($ln)."</a>";

    }
	
	$output .= 		"</div>"; // <div class-'langLinks'> end
	$output .= 		"<div class='langMsg'>";
	
	/* Generate the language output message based on language code */
	if ( !$wgUser->isLoggedIn() ){
		if ( $wgLang->getCode() == 'en' ) {
			// Eng   text
			$output .= 'You are seeing this message because you have not logged in.  Log in to set your interface language preferences. To temporarily change your interface language select one of the buttons on the left.  When the current page is available in both languages you will see a link at the top of the left sidebar.';
		}
		else {
			// Fra   text
//		$output .= ' S&#xE9;lectionnez la langue de votre choix ici. Note : vous ne pourrez rien afficher sur GCPEDIA si vous n\'avez pas cr&#xE9;&#xE9; un compte et ouvert une session. Vous avez d&#xE9;j&#xE0; un compte? Indiquez la langue de votre choix gr&#xE2;ce &#xE0; l\'onglet " mes pr&#xE9;f&#xE9;rences " dans le haut de l\' &#xE9;cran.';
			$output .= ' Vous voyez ce message parce que vous n\'avez pas ouvert une session (se connecter). Une fois qu\'une session est ouverte vous pouvez changer votre langage d\'interface gr&#xE2;ce &#xE0; l\'onglet "mes pr&#xE9;f&#xE9;rences".  Pour changer temporairement votre langage d\'interface choisissez un des boutons du côt&#xE9; gauche.  Quand la page courante est disponible dans les deux langues vous verrez un hyperlien au dessus de la barre lat&#xE9;rale gauche.';
		}
	}
	
	$output .= 		'</div>'; // <div class='langMsg'> end 
	
	$output .= 	'</div><div style="clear:both;"></div>';	// <div class 'langBox'> end

	return $output;
}

/****************************************/
/************GCPEDIA HOOKS**************/
/**************************************/

/*** @hook assigned to: UserLogoutComplete ***/
/*
	onUserCreation()
	-----------------------------------------------------------------------------------------------------------------------

	this function is applied to a hook and is called after a new user is created
	
	this function is used to set the user's initial language settings to whatever language they were using (in the language selector)
	before they created the account. 
	
	this way user's don't get nasty surprises where they're using the system in french and suddenly it defaults to english.

	@returns:
		type:			boolean
		value:			true (safely continue mediawiki execution)

	contract:
		precondition:	to be called only through the 'AddNewAccount' mediawiki hook callback which must pass arguments
						$user as a User object
						$byEmail as a boolean

	-----------------------------------------------------------------------------------------------------------------------
*/
function onUserCreation($user, $byEmail='false')
{
	//global $gc_userLang;	// avoid using globals!
	$user->setOption('language', gcGetUserLanguage());
	$user->saveSettings();	
	return true;
}

/****************************************/
/************GCPEDIA FUNCTIONS***********/
/***************************************/

/*
	gcGetUserLanguage()
	-----------------------------------------------------------------------------------------------------------------------

	used to get the current language by evaluating Language Selector cookie, which determines which language a logged out user has selected

	@returns:
		type:			string
		value: 		the value returned is the language abbreviation determined by either the language selector exention
					(if the value it contains conforms to one of the predermined formats governed by the Language class) 
					or the default mediawiki langauge determined also through the Language Class

	contract:
		precondition:	requires 'Language' Class exist
		postcondition:	return assignment value must be a string safe data container

	-----------------------------------------------------------------------------------------------------------------------
*/

function gcGetUserLanguage()
{
	global $wgCookiePrefix;
	
	if(isset($_COOKIE[$wgCookiePrefix.'LanguageSelectorLanguage']))
	{
		$language_cookie = htmlentities($_COOKIE[$wgCookiePrefix.'LanguageSelectorLanguage']);	// get the cookie and handle it safely
		if (in_array($language_cookie, array_keys(Language::getLanguageNames( true ))))			// check if the cookie value is an acceptable language varient
			return $language_cookie;															// set the gcpedia global language variable to equal the value of the cookie
	}
	$default_lang = new Language();
	return $default_lang->getPreferredVariant( false ); 
}


