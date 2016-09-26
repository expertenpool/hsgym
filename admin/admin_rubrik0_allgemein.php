<?php
//echo "are checking?";
//echo $_POST["zugang_sperren"];
	$formular_cat1_error = array(0, 0);
	if (strlen($_POST["general_passwort"]) == 0) {
		$formular_cat1_error[0] = 1;
	}
	if (!is_numeric($_POST["anzahl_zusagen"]) || $_POST["anzahl_zusagen"]<0) {
		$formular_cat1_error[1] = 1;
	}
		//echo $_POST["general_passwort"]; 
		//$_SESSION['mysql_general_passwort']
		//echo $_POST["anzahl_zusagen"];
		//$_SESSION['mysql_anzahl_zusagen']
	//wenn vorerst ok, dann
	if ($formular_cat1_error[0] == 0 && $formular_cat1_error[1] == 0) {
		$asdf = 0;
		if ($_POST["zugang_sperren"] == "on") {
			$asdf = 1;
		}
		$sql = sprintf("UPDATE einstellungen SET zugang_sperren = '%s', general_passwort = '%s', anzahl_zusagen = '%s' WHERE (id = '1')",
				mysql_real_escape_string($asdf),
				mysql_real_escape_string($_POST["general_passwort"]),
				mysql_real_escape_string($_POST["anzahl_zusagen"]));
			$res = mysql_db_query( "hsgym-ep", $sql );
			$_SESSION['info_zeile'] = "Zugang, Generalpasswort und maximale Anzahl Zusagen wurden abgespeichert!";
			include("./functions/get_einstellungen.php");
	}
	//
?>