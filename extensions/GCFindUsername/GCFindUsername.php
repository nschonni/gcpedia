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
	// count the number of occurances of email - disabled, to be used later if necessary
	/*$queryc = "SELECT count(*) FROM " .$dbr->tableName('user') ." WHERE user_email = \"". $q ."\"";

	$resultc = $dbr->doQuery($queryc);
	$rowc = $dbr->fetchRow($resultc);*/
	
	
	// find and return the FIRST username associated with the email
	$query = "SELECT user_name FROM " .$dbr->tableName('user') ." WHERE user_email = \"". $q ."\"";

	/* Tamara: changed  this line:
	
	$result = $dbr->doQuery($query);
	to:		$result = $dbr->query($query);
	
	as per instructions on http://www.mediawiki.org/wiki/Special:Code/MediaWiki/90458
	that specify to use query() instead of doQuery()
	*/
	
	$result = $dbr->query($query);
	$row = $dbr->fetchRow($result);
	
	echo $row[0];
	
	return "";
	
}
 
 ?>