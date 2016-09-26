<?php
	include ("mysql_connect.php");
	// Es werden alle zur Verfügung stehenden Regionen (Kantone etc) von der Datenbank abgeholt:
	$sql = sprintf("SELECT * FROM region ORDER BY UPPER(name)");
	$res = mysql_db_query( "hsgym-ep", $sql );
	
	$region_anzahl = mysql_num_rows($res); 
	$region_DATA = array();
	$region_DATA_ID = array();
	$region_DATA_sichtbarkeit = array();
	//
	while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
		array_push($region_DATA, array($row[id], $row[name], $row[sichtbarkeit])); 
		$region_DATA_ID[$row[id]] = $row[name];
		$region_DATA_sichtbarkeit[$row[id]] = $row[sichtbarkeit];
	}
?>