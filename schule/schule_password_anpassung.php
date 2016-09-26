<?php
//echo "are checking?";
	if (strlen($_POST['passwort_alt_schule']) == 0) {
		$formular_error[0] = 1;
	}
	/*if (strlen($_POST['email_schule']) == 0) {
		$formular_error[2] = 1;
	}
	if (strlen($_POST['email_schule']) > 0) {
		if (isValidEmail($_POST['email_schule']) == 0) {
			$formular_error[3] = 1;
		}
	}
	*/
	if (strlen($_POST['passwort_neu1_schule']) == 0 || strlen($_POST['passwort_neu2_schule']) == 0) {
		$formular_error[5] = 1;
	}
	if (strlen($_POST['passwort_neu1_schule']) > 0 && strlen($_POST['passwort_neu2_schule']) > 0) {
		if ($_POST['passwort_neu1_schule'] != $_POST['passwort_neu2_schule']) {
			$formular_error[5] = 1;
		}
		if ($_POST['passwort_neu1_schule'] == $_POST['passwort_neu2_schule']) {
			if (strlen($_POST['passwort_neu1_schule']) < 6) {
				$formular_error[6] = 1;
			}
		}
	}
	/*if($formular_error[5] == 1 || $formular_error[6] ==1){
		$_POST['passwort_neu1_schule'] = "";
		$_POST['passwort_neu2_schule'] = "";
	}*/
	//wenn vorerst ok, dann Formular-Error 4 falls Email schon verwendet wird:
	if ($formular_error[0] == 0 && $formular_error[5] == 0 && $formular_error[6] == 0) {
		//echo "are in last";
		include ("mysql_connect.php");
		//Check machen ob Passwort stimmt:
		$sql = sprintf("SELECT * FROM schule WHERE (email = '%s' AND passwort = '%s')",
		mysql_real_escape_string($_SESSION['mysql_email']),
		mysql_real_escape_string(md5($_POST['passwort_alt_schule'])));
		$res = mysql_db_query( "hsgym-ep", $sql );
	
		$num_rows = mysql_num_rows($res); 
		if ($num_rows > 0) {
		//Ok, jetzt userdaten der datenbank auswerten:
			$ausgabe = mysql_fetch_array ($res);
			$original_passwort = $ausgabe[passwort];
			//echo ", ausgabe: ".$ausgabe;
			if ($original_passwort == md5($_POST['passwort_alt_schule'])) {
			//echo "good";
				$sql = sprintf("UPDATE schule SET passwort = '%s' WHERE (id = '%s')",
				mysql_real_escape_string(md5($_POST['passwort_neu1_schule'])),
				mysql_real_escape_string($_SESSION['mysql_id']));
				//
				$res = mysql_db_query( "hsgym-ep", $sql );
				//Globale Variabeln anpassen:
				//zurück zur hauptseite:
				$_SESSION['info_zeile'] = "Passwort-Änderung erfolgreich durchgeführt!";
				//header('Location: ./schule.php?rubrik=1');
			}
			if ($original_passwort != md5($_POST['passwort_alt_schule'])) {
			//echo "not good";
				$formular_error[7] = 1;
			}
			//sind sowieso das alte und neue passwort genau gleich?
			if (md5($_POST['passwort_alt_schule']) == md5($_POST['passwort_neu1_schule'])) {
			//echo "not good";
				$formular_error[8] = 1;
				$_SESSION['info_zeile'] = "";
			}
			//Alle Felder löschen:
				$_POST['passwort_alt_schule'] = "";
				$_POST['passwort_neu1_schule'] = "";
				$_POST['passwort_neu2_schule'] = "";
				
		}
	}
	//
?>