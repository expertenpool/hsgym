<?php
	include ("mysql_connect.php");
	//
	//echo $_POST["papierkorb_geklickt"];
	//Alle bereits zugesagten Objekte herholen:
	$bereits_zugesagtes_fach_schon_da = array();
	//
	$sql_zusage = "SELECT fach_id FROM anfrage";
	$res_zusage = mysql_db_query( "hsgym-ep", $sql_zusage );
	while ($row_zusage = mysql_fetch_array($res_zusage, MYSQL_ASSOC)) {
		//echo $row_zusage[fach_id];
		if($bereits_zugesagtes_fach_schon_da[$row_zusage[fach_id]] != 1){
			$bereits_zugesagtes_fach_schon_da[$row_zusage[fach_id]] = 1;
		}
	}
	$sql_zusage = "SELECT fach FROM experte";
	$res_zusage = mysql_db_query( "hsgym-ep", $sql_zusage );
	while ($row_zusage = mysql_fetch_array($res_zusage, MYSQL_ASSOC)) {
		$temp_fach = explode(";", $row_zusage[fach]);
		for ($i = 1; $i < count($temp_fach) - 1; $i++) {
			if($bereits_zugesagtes_fach_schon_da[$temp_fach[$i]] != 1){
				$bereits_zugesagtes_fach_schon_da[$temp_fach[$i]] = 1;
			}
		}
	}
	//
	//
	if($bereits_zugesagtes_fach_schon_da[$_POST["papierkorb_geklickt"] ]!= 1){
		include ("mysql_connect.php");
		//
		$sql = sprintf("DELETE FROM fach WHERE( id = '%s') LIMIT 1",
		mysql_real_escape_string($_POST["papierkorb_geklickt"]));
		//
		$res = mysql_db_query( "hsgym-ep", $sql );
		//
		$_SESSION['info_zeile'] = "Das Fach wurde gelöscht!";
		//
	}
	if($bereits_zugesagtes_fach_schon_da[$_POST["papierkorb_geklickt"] ] == 1){
		//
		$_SESSION['info_zeile'] = "Das Fach konnte nicht gelöscht werden, da es in der Zwischenzeit von einer Schule/ einem Experten verwendet wird!";
		//
	}
?>
