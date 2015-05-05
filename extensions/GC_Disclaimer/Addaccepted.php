<?php
/**
 *
 * adds user to the accepted table
 *
 */
$wgAjaxExportList[] = 'Addaccepted';

//echo "<pre>";
//print_r($wgAjaxExportList);
//echo "</pre>";
$wgHooks['AddNewAccount'][] = 'Addnewuser';

function Addaccepted( $q )
{
	require_once('dbdisclaimer.php');
	$dbw = wfGetDB( DB_MASTER );
	

	$queryString = "SELECT 1 FROM `accepted`  WHERE Username = '".$q."'";
	$result = $dbw->query($queryString);
	$row = $dbw->fetchRow( $result );
	
	if($row[0]!='')
	{
		$queryString = "UPDATE IGNORE `accepted` SET date = '".date("d.m.y")."' WHERE Username = '".$q."'";
		$dbw->query($queryString);
	}	
	else
	{
		$queryString = "INSERT INTO `accepted` (Username, date) VALUES (\"".$q."\", '".date("d.m.y")."')";
		$dbw->query($queryString);
	}	
	
	return true;
	
}

function Addnewuser( $user )
{

	$dbr = wfGetDB( DB_MASTER );
	
	$queryString = "INSERT INTO `accepted` (Username, date) VALUES (\"". $user->getName() ."\", '".date("d.m.y")."')";
	
	$result = $dbr->query($queryString);
	
	
	return true;
	
}



?>