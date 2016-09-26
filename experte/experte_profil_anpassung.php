<?php
	session_start();
	if (strlen($_POST['name_experte']) == 0) {
		$formular_error[0] = 1;
	}
	if (strlen($_POST['adresse_experte']) == 0) {
		$formular_error[1] = 1;
	}
	/*if (strlen($_POST['email_experte']) == 0) {
		$formular_error[2] = 1;
	}
	if (strlen($_POST['email_experte']) > 0) {
		if (isValidEmail($_POST['email_experte']) == 0) {
			$formular_error[3] = 1;
		}
	}*/
	/*if (strlen($_POST['passwort1_experte']) == 0 || strlen($_POST['passwort2_experte']) == 0) {
		$formular_error[5] = 1;
	}
	if (strlen($_POST['passwort1_experte']) > 0 && strlen($_POST['passwort2_experte']) > 0) {
		if ($_POST['passwort1_experte'] != $_POST['passwort2_experte']) {
			$formular_error[5] = 1;
		}
		if ($_POST['passwort1_experte'] == $_POST['passwort2_experte']) {
			if (strlen($_POST['passwort1_experte']) < 6) {
				$formular_error[6] = 1;
			}
		}
	}*/

	$fach_string = ";";
	for($i2=0;$i2<count($bereits_zugesagte_fach);$i2++){ 
		$fach_string .=  $bereits_zugesagte_fach[$i2].";";
	}
	for($i2=0;$i2<100;$i2++){ 
		if ($_POST['fach_wahl'.$i2] != 0) {
			$fach_string .= $_POST['fach_wahl'.$i2].";";
		}
	}
	$region_string = ";";
	for ($i2 = 0; $i2 < 100; $i2++) { 
		if ($_POST['region_werte'][$i2] != 0) {
			$region_string .= $_POST['region_werte'][$i2].";";
		}
	}
	//
	$zeitplan_string = "000000000000";
	//echo $zeitplan_string."<br/>";
	//echo $_POST['zeitplan_wahl'].":  ";
	for ($i2 = 0; $i2 <count($_POST['zeitplan_werte']); $i2++) { 
		//echo $_POST['zeitplan_werte'][$i2].",";
		$zeitplan_string[$_POST['zeitplan_werte'][$i2]] = "1";
	}
	//echo "<br/>".$zeitplan_string."<br/>";
	//
	//wenn vorerst ok, dann Formular-Error 4 falls Email schon verwendet wird:
	if($formular_error[0] == 0 && $formular_error[1] == 0 && $formular_error[2] == 0 && $formular_error[3] == 0){
		include ("mysql_connect.php");
		//
		//echo $_POST['name_experte'].", ".$_POST['titel_experte'].", ".$_POST['institut_experte'].", ".$_POST['adresse_experte'].", ".$_POST['region_art_experte'].", ".$region_string."<br/>";
		//echo $_POST['zeitplan_art_experte'].", ".$zeitplan_string.", ".$_POST['pruefungs_art_experte'].", ".$fach_string.", ".$_SESSION['mysql_id'];

		//ERZWINGEN FUER NEUE VERSION:
		$_POST['region_art_experte'] = 0;
		$_POST['zeitplan_art_experte'] = 0;
		$_POST['pruefungs_art_experte'] = 0;
		
		$sql = sprintf("UPDATE experte SET name = '%s', titel = '%s', institut = '%s', adresse = '%s', region_art = '%s', region = '%s', zeitplan_art = '%s', zeitplan = '%s', fach_art = '%s', fach = '%s' WHERE (id = '%s')",
//		$sql = sprintf("UPDATE experte SET name = '%s', titel = '%s', institut = '%s', adresse = '%s', region_art = '%s' WHERE (id = '%s')",
		mysql_real_escape_string($_POST['name_experte']),
			mysql_real_escape_string($_POST['titel_experte']),
			mysql_real_escape_string($_POST['institut_experte']),
			mysql_real_escape_string($_POST['adresse_experte']),
			mysql_real_escape_string($_POST['region_art_experte']),
			mysql_real_escape_string($region_string),
			mysql_real_escape_string($_POST['zeitplan_art_experte']),
			mysql_real_escape_string($zeitplan_string),
			mysql_real_escape_string($_POST['pruefungs_art_experte']),
			mysql_real_escape_string($fach_string),
			mysql_real_escape_string($_SESSION['mysql_id']));
			//
			$res = mysql_db_query( "hsgym-ep", $sql );
			//Globale Variabeln anpassen:
			$_SESSION['mysql_name'] = $_POST['name_experte'];
			$_SESSION['mysql_titel'] = $_POST['titel_experte'];
			$_SESSION['mysql_institut'] = $_POST['institut_experte'];
			$_SESSION['mysql_adresse'] = $_POST['adresse_experte'];
			$_SESSION['mysql_region_art'] = $_POST['region_art_experte'];
			$_SESSION['mysql_region'] = $region_string;
			$_SESSION['mysql_zeitplan_art'] = $_POST['zeitplan_art_experte'];
			$_SESSION['mysql_zeitplan'] = $zeitplan_string;
			//
			$temp_region = explode(";", $_SESSION['mysql_region']);
			for ($i = 1; $i < count($temp_region) - 1; $i++) {
				for ($i2 = 0; $i2 < count($region_DATA); $i2++) {
					if ($region_DATA[$i2][0] == $temp_region[$i]) {
						//echo $temp_region[$i];
						$_POST['region_wahl'.$i2] = $temp_region[$i];
					}
				}
			}
			//
			$temp_zeitplan = $_SESSION['mysql_zeitplan'];
			for ($i = 0; $i <= 11; $i++) {
				$_POST['zeitplan_wahl'.$i] = $temp_zeitplan[$i];
			}
			//
			$_SESSION['mysql_fach_art'] = $_POST['pruefungs_art_experte'];
			$_SESSION['mysql_fach'] = $fach_string;
			//zurück zur hauptseite:
			$_SESSION['info_zeile'] = "Profil-Anpassung erfolgreich durchgeführt!";
			//header('Location: ./experte.php?rubrik=1');
	}
	//
?>