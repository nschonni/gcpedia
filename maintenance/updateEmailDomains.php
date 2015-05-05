<?php
/**
 * Update the list file which contains the list of domains in Special:UserLogin
 *
 * @author Matthew April <Matthew.April@tbs-sct.gc.ca>
 * @ingroup Maintenance
 */

require_once( dirname(__FILE__) . '/Maintenance.php' );

class UpdateDomains extends Maintenance {
	
	public function execute() {
		
		# init vars
		define("MIN_COUNT",	20); // user defined
		$parentDir = dirname(dirname(__FILE__));
		$dbr =& wfGetDB( DB_SLAVE );
		$outputCount = 0;
		
		$dateStamp = date('Y-m-d');
		
		$output = "<?php
		
		/* date created: $dateStamp */
		
		\$domainList = array( 'institution.gc.ca', ";
		
		# list to read from
		include("$parentDir/extensions/customUserCreateForm/templates/domains/MasterDomainList.php"); 
		
		foreach( $MasterDomainList as $domainName ) {
			
			# users with the domain in their email address
			$res = $dbr->select("user", "count(*)", "user_email LIKE '%$domainName'");
			
			# number of users with $domainName in their email address
			$domainCount = $dbr->fetchRow($res);
			
			
			if( $domainCount[0] > MIN_COUNT ) {
				//echo $domainName . ": " . $domainCount[0];
				$output .= "'". $domainName ."',";
				$outputCount ++;
			}

		}
		$output .= " ); ?>";
		if( $outputCount > 0 ) {
			
			# file to archive then write to
			$oldFile = "$parentDir/extensions/customUserCreateForm/templates/domains/DomainList.php";
			if( file_exists( $oldFile ) ) {
				$date = date("Y-m-d");
				$newFile = "$parentDir/extensions/customUserCreateForm/templates/domains/old-lists/DomainList_$date.php";
				rename( $oldFile, $newFile );
			}

			$file = fopen( $oldFile, "w" );
					fwrite( $file, $output );
					fclose( $file );
			
			echo "\nthe domain list was successfully updated!\n";
			echo "-----------------------------------------\n";
			echo "threshold: " . MIN_COUNT . "\n";
			echo "new domain count: $outputCount\n";
			echo "file created: $oldFile\n";
			
		} else {
		
			echo "\nupdate failed\n";
			echo "-----------------------------------------\n";
			echo "0 domains were available, your threshold might be too high\n";
		}
			
		
		
		
	}
	
}



/*****************************/
$maintClass = "UpdateDomains";
if( defined('RUN_MAINTENANCE_IF_MAIN') ) {

  require_once( RUN_MAINTENANCE_IF_MAIN );

} else {

  require_once( DO_MAINTENANCE ); # Make this work on versions before 1.17

}

