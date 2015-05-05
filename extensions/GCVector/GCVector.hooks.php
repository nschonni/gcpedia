<?php
/**
 * Hooks for GCVector extension
 * 
 * @file
 * @ingroup Extensions
 */

class GCVectorHooks {
	
	/* Protected Static Members */
	
	protected static $features = array(
		'collapsiblenav' => array(
			'preferences' => array(
				'gcvector-collapsiblenav' => array(
					'type' => 'toggle',
					'label-message' => 'gcvector-collapsiblenav-preference',
					'section' => 'rendering/advancedrendering',
				),
			),
			'requirements' => array(
				'gcvector-collapsiblenav' => true,
			),
			'configurations' => array(
				'wgCollapsibleNavBucketTest',
				'wgCollapsibleNavForceNewVersion',
			),
			'modules' => array( 'ext.gcvector.collapsibleNav' ),
		),
		'collapsibletabs' => array(
			'modules' => array( 'ext.gcvector.collapsibleTabs' ),
		),
		'editwarning' => array(
			'preferences' => array(
				// Ideally this would be 'gcvector-editwarning'
				'useeditwarning' => array(
					'type' => 'toggle',
					'label-message' => 'gcvector-editwarning-preference',
					'section' => 'editing/advancedediting',
				),
			),
			'requirements' => array(
				'useeditwarning' => true,
			),
			'modules' => array( 'ext.gcvector.editWarning' ),
		),
		'expandablesearch' => array(
			'requirements' => array( 'gcvector-simplesearch' => true ),
			'modules' => array( 'ext.gcvector.expandableSearch' ),
		),
		'footercleanup' => array(
			'modules' => array( 'ext.gcvector.footerCleanup' ),
		),
		'sectioneditlinks' => array(
			'modules' => array( 'ext.gcvector.sectionEditLinks' ),
			'configurations' => array(
				'wgGCVectorSectionEditLinksBucketTest',
				'wgGCVectorSectionEditLinksLotteryOdds',
				'wgGCVectorSectionEditLinksExperiment',
			),
			'requirements' => array(
				'gcvector-noexperiments' => false,
			),
		),
		'experiments' => array(
			'preferences' => array(
				'gcvector-noexperiments' => array(
					'type' => 'toggle',
					'label-message' => 'gcvector-noexperiments-preference',
					'section' => 'rendering/advancedrendering',
				),
			),
		),
	);
	
	/* Protected Static Methods */
	
	protected static function isEnabled( $name ) {
		global $wgGCVectorFeatures, $wgUser;
		
		// Features with global set to true are always enabled
		if ( !isset( $wgGCVectorFeatures[$name] ) || $wgGCVectorFeatures[$name]['global'] ) {
			return true;
		}
		// Features with user preference control can have any number of preferences to be specific values to be enabled
		if ( $wgGCVectorFeatures[$name]['user'] ) {
			if ( isset( self::$features[$name]['requirements'] ) ) {
				foreach ( self::$features[$name]['requirements'] as $requirement => $value ) {
					// Important! We really do want fuzzy evaluation here
					if ( $wgUser->getOption( $requirement ) != $value ) {
						return false;
					}
				}
			}
			return true;
		}
		// Features controlled by $wgGCVectorFeatures with both global and user set to false are awlways disabled 
		return false;
	}
	
	/* Static Methods */
	
	/**
	 * BeforePageDisplay hook
	 * 
	 * Adds the modules to the page
	 * 
	 * @param $out OutputPage output page
	 * @param $skin Skin current skin
	 */
	public static function beforePageDisplay( $out, $skin ) {
		if ( $skin instanceof SkinGCVector ) {
			// Add modules for enabled features
			foreach ( self::$features as $name => $feature ) {
				if ( isset( $feature['modules'] ) && self::isEnabled( $name ) ) {
					$out->addModules( $feature['modules'] );
				}
			}
		}
		return true;
	}
	
	/**
	 * GetPreferences hook
	 * 
	 * Adds GCVector-releated items to the preferences
	 * 
	 * @param $user User current user
	 * @param $defaultPreferences array list of default user preference controls
	 */
	public static function getPreferences( $user, &$defaultPreferences ) {
		global $wgGCVectorFeatures;
		
		foreach ( self::$features as $name => $feature ) {
			if (
				isset( $feature['preferences'] ) &&
				( !isset( $wgGCVectorFeatures[$name] ) || $wgGCVectorFeatures[$name]['user'] )
			) {
				foreach ( $feature['preferences'] as $key => $options ) {
					$defaultPreferences[$key] = $options;
				}
			}
		}
		return true;
	}
	
	/**
	 * ResourceLoaderGetConfigVars hook
	 * 
	 * Adds enabled/disabled switches for GCVector modules
	 */
	public static function resourceLoaderGetConfigVars( &$vars ) {
		global $wgGCVectorFeatures;
		
		$configurations = array();
		foreach ( self::$features as $name => $feature ) {
			if (
				isset( $feature['configurations'] ) &&
				( !isset( $wgGCVectorFeatures[$name] ) || self::isEnabled( $name ) )
			) {
				foreach ( $feature['configurations'] as $configuration ) {
					global $$configuration;
					$configurations[$configuration] = $$configuration;
				}
			}
		}
		if ( count( $configurations ) ) {
			$vars = array_merge( $vars, $configurations );
		}
		return true;
	}

	/**
	 * @param $vars array
	 * @return bool
	 */
	public static function makeGlobalVariablesScript( &$vars ) {
		// Build and export old-style wgGCVectorEnabledModules object for back compat
		$enabledModules = array();
		foreach ( self::$features as $name => $feature ) {
			$enabledModules[$name] = self::isEnabled( $name );
		}
		
		$vars['wgGCVectorEnabledModules'] = $enabledModules;
		return true;
	}
}
