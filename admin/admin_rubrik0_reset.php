<?php
	include ("mysql_connect.php");
	//
	$res = mysql_db_query( "hsgym-ep", "DELETE FROM anfrage" );
	$res = mysql_db_query( "hsgym-ep", "DELETE FROM zusage" );
	$res = mysql_db_query( "hsgym-ep", "DELETE FROM absage" );
	//
	$_SESSION['info_zeile'] = "Expertenpool wurde zurückgesetzt!";
	//
?>
