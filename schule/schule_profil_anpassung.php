<?php
	if (strlen($_POST['name_schule']) == 0) {
		$formular_error[0] = 1;
	}
	if (strlen($_POST['adresse_schule']) == 0) {
		$formular_error[1] = 1;
	}
	if ($_POST['region_wahl'] == 0) {
		$formular_error[5] = 1;
	}
	/*if (strlen($_POST['email_schule']) == 0) {
		$formular_error[2] = 1;
	}
	if (strlen($_POST['email_schule']) > 0) {
		if (isValidEmail($_POST['email_schule']) == 0) {
			$formular_error[3] = 1;
		}
	}
	if (strlen($_POST['passwort1_schule']) == 0 || strlen($_POST['passwort2_schule']) == 0) {
		$formular_error[5] = 1;
	}
	if (strlen($_POST['passwort1_schule']) > 0 && strlen($_POST['passwort2_schule']) > 0) {
		if ($_POST['passwort1_schule'] != $_POST['passwort2_schule']) {
			$formular_error[5] = 1;
		}
		if ($_POST['passwort1_schule'] == $_POST['passwort2_schule']) {
			if (strlen($_POST['passwort1_schule']) < 6) {
				$formular_error[6] = 1;
			}
		}
	}*/
	//echo $_POST['email_versand_schule'];
	if (isset($_POST['email_versand_schule'])) {
		$_POST['email_versand_schule'] = 1;
	}
	if (!isset($_POST['email_versand_schule'])) {
		$_POST['email_versand_schule'] = 0;
	}
	//wenn vorerst ok, dann Formular-Error 4 falls Email schon verwendet wird:
	if($formular_error[0] == 0 && $formular_error[1] == 0 && $formular_error[2] == 0 && $formular_error[3] == 0 && $formular_error[5] == 0 && $formular_error[6] == 0){
		include ("mysql_connect.php");
		//
			$sql = sprintf("UPDATE schule SET name = '%s', adresse = '%s', region = '%s', email_zusage = '%s' WHERE (id = '%s')",
			mysql_real_escape_string($_POST['name_schule']),
			mysql_real_escape_string($_POST['adresse_schule']),
			mysql_real_escape_string($_POST['region_wahl']),
			mysql_real_escape_string($_POST['email_versand_schule']),
			mysql_real_escape_string($_SESSION['mysql_id']));
			//
			$res = mysql_db_query( "hsgym-ep", $sql );
			//Globale Variabeln anpassen:
			$_SESSION['mysql_name'] = $_POST['name_schule'];
			$_SESSION['mysql_adresse'] = $_POST['adresse_schule'];
			$_SESSION['mysql_region'] = $_POST['region_wahl'];
			$_SESSION['mysql_email_zusage'] = $_POST['email_versand_schule'];
			//zurück zur hauptseite:
			$_SESSION['info_zeile'] = "Profil-Anpassung erfolgreich durchgeführt!";
			//header('Location: ./schule.php?rubrik=1');
	}
	//
?>