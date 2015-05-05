<?php
$wgExtensionMessagesFiles['GC_PreferenceAdjust'] =  dirname( __FILE__ ) . '/GC_PreferenceAdjust.i18n.php';
$wgHooks['GetPreferences'][] = "prefAdjust";

function prefAdjust($user, &$preferences ) {

	wfLoadExtensionMessages( 'GC_PreferenceAdjust' );	
	
	$preferences['usebetatoolbar']['section'] = 'editing/advEditor';
	$preferences['usebetatoolbar']['label-message'] = 'adjusted-wikieditor-toolbar-preference';

	$preferences['usebetatoolbar-cgd']['section'] = 'editing/advEditor';
	
	//$preferences['wikieditor-toolbar-hidesig']['section'] = 'editing/advEditor';
	
	//$preferences['wikieditor-template-editor']['section'] = 'editing/advEditor';
	
	//$preferences['wikieditor-templates']['section'] = 'editing/advEditor';
	
	$preferences['wikieditor-preview']['section'] = 'editing/advEditor';
	
	//$preferences['wikieditor-previewDialog']['section'] = 'editing/advEditor';
	
	$preferences['wikieditor-publish']['section'] = 'editing/advEditor';
	
	$preferences['usenavigabletoc']['section'] = 'editing/advEditor';
	
	
	return true;

}

?>