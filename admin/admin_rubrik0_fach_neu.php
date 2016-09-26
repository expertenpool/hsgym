<?php
	//session_start();
	include ("mysql_connect.php");
	//
	//echo $_POST["neues_fach"];
	
	$formular_cat4_error = array(0, 0);
	if (strlen($_POST["neues_fach"]) == 0) {
		$formular_cat4_error[0] = 1;
		$_SESSION['formular_cat4_error_zeile'] = "Bitte ein Prüfungsfach eingeben! ";
		header('Location: #anchor_fach');
	}
	
	for ($i = 0; $i < count($fach_DATA); $i++) {
		if (strtolower($_POST["neues_fach"]) == strtolower($fach_DATA[$i][1])) {
			$formular_cat4_error[1] = 1;
			$_SESSION['formular_cat4_error_zeile'] = "Prüfungsfach wird bereits verwendet! ";
			header('Location: #anchor_fach');
		}
	}
	//
	if($formular_cat4_error[0] == 0 && $formular_cat4_error[1] == 0){
		include ("mysql_connect.php");
		//
		$sql = sprintf("INSERT INTO fach VALUES (null,'%s')", mysql_real_escape_string($_POST["neues_fach"]));
		$res = mysql_db_query( "hsgym-ep", $sql );
		//
		$_SESSION['formular_cat4_error_zeile'] = "";
		$_SESSION['info_zeile'] = "Neues Fach wurde erfolgreich hinzugefügt!";
		//
		include("./functions/get_fach_entries.php");
		//
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
	}
	
?>
