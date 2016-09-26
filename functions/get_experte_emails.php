<?php
	include ("mysql_connect.php");
	//
	$sql = "SELECT * FROM experte";
	$res = mysql_db_query( "hsgym-ep", $sql );
	
	$alle_experte_emails = array();
	$alle_experte_passworts = array();
	//
	while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
		array_push($alle_experte_emails, $row[email]); 
		array_push($alle_experte_passworts, $row[passwort]);
	}
?>