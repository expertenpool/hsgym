<?php
	include ("mysql_connect.php");
	// Es werden alle zur Verfügung stehenden experten von der Datenbank abgeholt:
	$sql = sprintf("SELECT * FROM experte ORDER BY UPPER(name)");
	$res = mysql_db_query( "hsgym-ep", $sql );
	
	$experte_anzahl = mysql_num_rows($res); 
	$experte_DATA = array();
	$experte_DATA_ID = array();
	$experte_DATA_EMAIL = array();
	//
	while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
		array_push($experte_DATA, array($row[id], $row[name], $row[institut])); 
		$experte_DATA_ID[$row[id]] = $row[name];
		$experte_DATA_NAME[$row[id]] = $row[name];
		$experte_DATA_EMAIL[$row[id]] = $row[email];
	}
?>