<?php
	include ("mysql_connect.php");
	// Es werden alle zur Verfügung stehenden experten von der Datenbank abgeholt:
	$sql = sprintf("SELECT * FROM schule ORDER BY UPPER(name)");
	$res = mysql_db_query( "hsgym-ep", $sql );
	
	//$schule_anzahl = mysql_num_rows($res); 
	//$schule_DATA = array();
	$schule_DATA_NAME = array();
	$schule_DATA_EMAIL = array();
	//
	while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
		//array_push($schule_DATA, array($row[id], $row[name], $row[institut])); 
		$schule_DATA_NAME[$row[id]] = $row[name];
		$schule_DATA_EMAIL[$row[id]] = $row[email];
	}
?>