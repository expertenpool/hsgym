<?php
	include ("mysql_connect.php");
	//
	$sql = "SELECT * FROM schule";
	$res = mysql_db_query( "hsgym-ep", $sql );
	
	$alle_schule_emails = array();
	$alle_schule_passworts = array();
	//
	while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
		array_push($alle_schule_emails, $row[email]);
		array_push($alle_schule_passworts, $row[passwort]); 
	}
?>