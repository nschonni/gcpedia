<?php
/**
 * GoogleTranslate extension
 * @author Per Feldvoss Olsen (based on code by Adam Meyer)
 * @copyright © 2008 Per Feldvoss Olsen 
 */
 
//See below under "function wfAjaxGoogleTranslate" for configuration
 
if( !defined( 'MEDIAWIKI' ) ) {
        echo( "This file is part of an extension to the MediaWiki software and cannot be used standalone.\n" );
        die( 1 );
}
 
$wgExtensionFunctions[] = 'wfAjaxtranslate';
$wgAjaxExportList[] = 'wfAjaxGoogleTranslate';
$wgHooks['AlternateEdit'][] = 'wfAjaxGoogleTranslateHeaders';
 
$wgExtensionCredits['other'][] = array(
    'name'=> 'GoogleTranslate',
    'author'=> 'Per Feldvoss Olsen',
    'version'=> '0.2',
    'url' => 'http://www.mediawiki.org/wiki/Extension:GoogleTranslate',
    'description'=> 'Ajax-based link translation that translates edittext from/to via GoogleTranslate'
);
 
function wfAjaxtranslate() {
        global $wgUseAjax, $wgOut, $wgTitle;
        if (!$wgUseAjax) {
                wfDebug('wfAjaxtranslate: $wgUseAjax is not enabled, aborting extension setup.');
                return;
        }
}
 
function wfAjaxGoogleTranslate( $term ) {
 
        //configure the following to change settings
        $limit = 8; //number of results to spit back
        $location = 1; //set to 1 to search anywhere in the article name, set to 0 to search only at the begining
 
 
        global $wgContLang, $wgOut;
        $response = new AjaxResponse();
        $db = wfGetDB( DB_SLAVE );
        $l = new Linker;
 
        $term = str_replace(' ', '_', $term);
 
        if($location == 1){
 
                $res = $db->select( 'page', 'page_title',
                                array(  'page_namespace' => 0,
                                        "UPPER(page_title) LIKE '%" .$db->strencode( strtoupper ($term)). "%'" ),
                                        "wfSajaxSearch",
                                        array( 'LIMIT' => $limit )
                                );
        }else{             
 
                $res = $db->select( 'page', 'page_title',
                        array(  'page_namespace' => 0,
                                "UPPER(page_title) LIKE '". $db->strencode( strtoupper ($term)) ."%'" ),
                                "wfSajaxSearch",
                                array( 'LIMIT' => $limit )
                        );         
        }
 
        $r = "";    
        while ($row = $db->fetchObject( $res ) ){
                $r .= '<li><a href="javascript:Insertlink(\''.addslashes(str_replace('_', ' ', $row->page_title)).'\')">'.str_replace('_', ' ', $row->page_title). "</li>\n";
 
        }
        $html ='<ul>' .$r .'</ul>';
 
        return $html;
}
 
function wfAjaxGoogleTranslateHeaders(){
        global $wgOut;
        wfAjaxSetGoogleTranslateHeaders($wgOut);
        return true;
}
 
 
function wfAjaxSetGoogleTranslateHeaders($outputPage) {
        global $wgJsMimeType, $wgStylePath, $wgScriptPath;
        $outputPage->addLink( 
                array( 
                        'rel' => 'stylesheet', 
                        'type' => 'text/css', 
                        'href' => $wgScriptPath.'/extensions/GoogleTranslate/GoogleTranslate.css' 
                ) 
        );
        $outputPage->addScript( "<script type=\"{$wgJsMimeType}\" src=\"$wgScriptPath/extensions/GoogleTranslate/GoogleTranslate.js\">"."</script>\n");
        $outputPage->addScript( "<script type=\"{$wgJsMimeType}\">hookEvent(\"load\", mwGoogleTranslateButton);</script>\n" );
        $outputPage->addScript( '<script type="text/javascript" src="http://www.google.com/jsapi"></script>' );
      	$outputPage->addScript( '<script type="text/javascript">google.load("language", "1");</script>' ); 
 
}
