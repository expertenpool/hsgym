<?php
	include ("mysql_connect.php");
	// Es werden alle zur Verfügung stehenden Fächer von der Datenbank abgeholt:
	$sql = sprintf("SELECT * FROM fach ORDER BY UPPER(name)");
	$res = mysql_db_query( "hsgym-ep", $sql );
	
	$fach_anzahl = mysql_num_rows($res); 
	$fach_DATA = array();
	$fach_DATA_ID = array();
	//
	while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
		array_push($fach_DATA, array($row[id], $row[name])); 
		$fach_DATA_ID[$row[id]] = $row[name];
	}
?>