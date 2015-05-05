<?php
/**
 * GCSimple Skin
 */
if(!defined('MEDIAWIKI')){
	die(1);
}

$wgExtensionCredits['skin'][] = array(
	'path' => __FILE__,
	'name' => 'GCSimple',
	'descriptionmsg' => 'A very simple skin.',
);

$wgValidSkinNames['gcsimple'] = 'GCSimple';
$wgAutoloadClasses['SkinGCSimple'] = dirname(__FILE__).'/GCSimple.skin.php';
$wgExtensionMessagesFiles['GCSimple'] = dirname(__FILE__).'/GCSimple.i18n.php';

$wgResourceModules['skins.gcsimple'] = array(
	'remoteBasePath' => &$GLOBALS['wgStylePath'],
	'localBasePath' => &$GLOBALS['wgStyleDirectory'],
);
