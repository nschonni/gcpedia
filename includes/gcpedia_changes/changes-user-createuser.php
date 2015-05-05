<?php

	/* 
		should be included in User.php in the getDefaultOptions() functions
		below the where the $variant variable's initial value is defined
		
		ex. below here
				$variant = $wgContLang->getPreferredVariant( false );
			
		this piece of code sets the users default language (when they create an account) to be whatever the set prior to creating the account
		this is meant to work in conjunction with the LanguageSelector extention so site viewers can define what language the want to see the page in and create an account in the language by default
		
		this differs from the standard wiki behavior which is to create all users with english as the default preffered language variant
		
		@note:  inorder for this to work changes.php must already be installed. This is because changes.php determines the value of the global $gc_userLang variable. Otherwise the user's default language will be
			undefined....which is really really bad
			
	*/

	global $gc_userLang;
	$variant = $gc_userLang;

?>