
<?php
/*
															FUNCTIONS
	----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
*/
	$opt = array();
	
	function query($query_string)
	{
		mysql_connect('localhost','dbuser','dbpassword');
		mysql_select_db('wikidb_matt');
		$result = mysql_query($query_string);
		return $result;
	}
	
	/*
															VARIABLES
	----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	*/
/*	options available:
	
		riched_disable=1
		riched_start_disabled=1
		riched_use_popup=1 
		riched_use_toggle=1 
		riched_toggle_remember_state=0 
		riched_disable_ns_main=0 
		riched_disable_ns_talk=0
		riched_disable_ns_user=0
		riched_disable_ns_user_talk=0 
		riched_disable_ns_project=0
		riched_disable_ns_project_talk=0
		riched_disable_ns_image=0
		riched_disable_ns_image_talk=0
		riched_disable_ns_mediawiki=0
		riched_disable_ns_mediawiki_talk=0
		riched_disable_ns_template=0
		riched_disable_ns_template_talk=0
		riched_disable_ns_help=0
		riched_disable_ns_help_talk=0
		riched_disable_ns_category=0
		riched_disable_ns_category_talk=0
	*/
	
	/*** changes the request option, if the option is set to the 'change if' and changes it to the 'change to' value ***/
	
	$options['language'] = 'en';
		
	/*$options['riched_start_disabled'] 	= 1;
	$options['riched_use_toggle'] 		= 1;
	$options['riched_use_popup']		= 1;*/
	
	
	/*
														     IMPLEMENTATION
	----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	*/
	
	echo "<div style='margin: 5px; padding: 10px; border: 2px solid #a00;'>--- SETTING CHANGER 1.0 --- <br/><div style='color: #a00;'>Finding users...<br/>";
	
	$result = query("SELECT user_id, user_options FROM user;");
	
	if (!$result)
	{
		echo "An error has occurred while accessing use database, error is as follows:<br/>".mysql_error()."<br/>Ending script....<br/>Script Terminated.<br/></div>--- END ---<br/></div>";
		exit;
	}
	
	echo mysql_num_rows($result)." user(s) found<br/>Updating user preferences...<br/>";
	$counter = 0;
	
	while($row = mysql_fetch_array( $result )) 
	{	
		extract($row);
		
		$user = new User();
		$user->mId = $user_id;
		$user->mFrom = 'id';
		$user->load();
			
		foreach($options as $option => $value)
		{
			$user->setOption($option, $value);
		}
		
		$user->saveSettings();
		$counter++;
	}
	
	echo $counter . " user(s) updated<br/>Ending Script...<br/>Script Terminated.<br/></div>--- END ---<br/></div>";
?>