<?php
/**
 * GCVector extension
 * 
 * @file
 * @ingroup Extensions
 * 
 * @author Trevor Parscal <trevor@wikimedia.org>
 * @author Roan Kattouw <roan.kattouw@gmail.com>
 * @author Nimish Gautam <nimish@wikimedia.org>
 * @author Adam Miller <amiller@wikimedia.org>
 * @license GPL v2 or later
 * @version 0.3.0
 */

/* Configuration */

// Each module may be configured individually to be globally on/off or user preference based
$wgGCVectorFeatures = array(
	'collapsiblenav' => array( 'global' => true, 'user' => true ),
	'collapsibletabs' => array( 'global' => true, 'user' => false ),
	'editwarning' => array( 'global' => false, 'user' => true ),
	// The follwing are experimental and likely unstable - use at your own risk
	'expandablesearch' => array( 'global' => false, 'user' => false ),
	'footercleanup' => array( 'global' => false, 'user' => false ),
	'sectioneditlinks' => array( 'global' => false, 'user' => false ),
);

// The GCVector skin has a basic version of simple search, which is a prerequisite for the enhanced one
$wgDefaultUserOptions['gcvector-simplesearch'] = 1;

// Enable bucket testing for new version of collapsible nav
$wgCollapsibleNavBucketTest = false;
// Force the new version
$wgCollapsibleNavForceNewVersion = false;

// Enable bucket testing for new version of section edit links
$wgGCVectorSectionEditLinksBucketTest = false;
// Percentage of users who's use of section edit links will be tracked - half of which will see the
// new section edit links - default 5%
$wgGCVectorSectionEditLinksLotteryOdds = 5;
// Version number of the current experiment - Buckets from previous experiments will be overwritten
// with new values when this is incremented, so as to allow accurate re-distribution. When changing
// the lottery odds, this needs to change too, or you will have inaccurate data.
$wgGCVectorSectionEditLinksExperiment = 0;

/* Setup */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'GCVector',
	'author' => array( 'Trevor Parscal', 'Roan Kattouw', 'Nimish Gautam', 'Adam Miller' ),
	'version' => '0.3.0',
	'url' => 'https://www.mediawiki.org/wiki/Extension:GCVector',
	'descriptionmsg' => 'gcvector-desc',
);
$wgAutoloadClasses['GCVectorHooks'] = dirname( __FILE__ ) . '/GCVector.hooks.php';
$wgExtensionMessagesFiles['GCVector'] = dirname( __FILE__ ) . '/GCVector.i18n.php';
$wgHooks['BeforePageDisplay'][] = 'GCVectorHooks::beforePageDisplay';
$wgHooks['GetPreferences'][] = 'GCVectorHooks::getPreferences';
$wgHooks['ResourceLoaderGetConfigVars'][] = 'GCVectorHooks::resourceLoaderGetConfigVars';
$wgHooks['MakeGlobalVariablesScript'][] = 'GCVectorHooks::makeGlobalVariablesScript';

$gcvectorResourceTemplate = array(
	'localBasePath' => dirname( __FILE__ ) . '/modules',
	'remoteExtPath' => 'GCVector/modules',
	'group' => 'ext.gcvector',
);
$wgResourceModules += array(
	'ext.gcvector.collapsibleNav' => $gcvectorResourceTemplate + array(
		'scripts' => 'ext.gcvector.collapsibleNav.js',
		'styles' => 'ext.gcvector.collapsibleNav.css',
		'messages' => array(
			'gcvector-collapsiblenav-more',
		),
		'dependencies' => array(
			'mediawiki.util',
			'jquery.client',
			'jquery.cookie',
			'jquery.tabIndex',
		),
	),
	'ext.gcvector.collapsibleTabs' => $gcvectorResourceTemplate + array(
		'scripts' => 'ext.gcvector.collapsibleTabs.js',
		'dependencies' => array(
			'jquery.collapsibleTabs',
			'jquery.delayedBind',
		),
	),
	'ext.gcvector.editWarning' => $gcvectorResourceTemplate + array(
		'scripts' => 'ext.gcvector.editWarning.js',
		'messages' => array(
			'gcvector-editwarning-warning',
		),
	),
	'ext.gcvector.expandableSearch' => $gcvectorResourceTemplate + array(
		'scripts' => 'ext.gcvector.expandableSearch.js',
		'styles' => 'ext.gcvector.expandableSearch.css',
		'dependencies' => array(
			'jquery.client',
			'jquery.expandableField',
			'jquery.delayedBind',
		),
	),
	'ext.gcvector.footerCleanup' => $gcvectorResourceTemplate + array(
		'scripts' => array(
			'jquery.footerCollapsibleList.js',
			'ext.gcvector.footerCleanup.js',
		),
		'styles' => 'ext.gcvector.footerCleanup.css',
		'messages' => array (
			'gcvector-footercleanup-transclusion',
			'gcvector-footercleanup-templates',
			'gcvector-footercleanup-categories',
		),
		'dependencies' => array(
			// The message require plural support at javascript.
			'mediawiki.jqueryMsg',
			'jquery.cookie'
		),
		'position' => 'top',
	),
	'ext.gcvector.sectionEditLinks' => $gcvectorResourceTemplate + array(
		'scripts' => 'ext.gcvector.sectionEditLinks.js',
		'styles' => 'ext.gcvector.sectionEditLinks.css',
		'dependencies' => array(
			'jquery.cookie',
			'jquery.clickTracking',
		),
	),
);

