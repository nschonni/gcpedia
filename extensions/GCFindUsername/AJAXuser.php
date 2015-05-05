<?php
/**
 * FindUsername.php
 * User search by email
 * 		php file for ajax
 * 
 * Author: Ilia Salem
 *
 */
$wgAjaxExportList[] = 'findUsername'; 
 
function findUsername( $q )
{
	global $wgLang;
	$dbr = wfGetDB( DB_SLAVE ); 
	
	// count the number of occurances of email - disabled, to be used later if necessary
	/*$queryc = "SELECT count(*) FROM " .$dbr->tableName('user') ." WHERE user_email = \"". $q ."\"";

	$resultc = $dbr->doQuery($queryc);
	$rowc = $dbr->fetchRow($resultc);*/
	$q = mysql_real_escape_string($q);
	
	// find and return the FIRST username associated with the email
	$query = "SELECT user_name FROM " .$dbr->tableName('user') ." WHERE user_email = \"". $q ."\"";
	
	$result = $dbr->query($query);
	$row = $dbr->fetchRow($result);
	
	if($row){
		echo $row[0];
	}else{
		if($wgLang->getCode() == 'fr') {
			echo "Nom d'utilisateur n'existe pas"; // Translated; verify
		}else{
			echo "Username not found";
		}
	}
	
	return "";
	
}
 
 ?>