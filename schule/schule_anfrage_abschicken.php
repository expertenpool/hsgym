<?php
	date_default_timezone_set("Europe/Zurich");
	//month starts with 1-12: hour, minute, sek, month, day, year:
	//echo "are checking?";
	//echo "fach_wahl: ".$_POST['fach_wahl']."<br/>";
	//echo "pruefungs_art_experte: ".$_POST['pruefungs_art_experte']."<br/>";
	//echo "gerichtet_an_alle_schule: ".$_POST['gerichtet_an_alle_schule']."<br/>";
	//echo "gewählter Experte-ID: ".$_POST['experte_wahl']."<br/>";
	//
	//echo "termin_von_tag_wahl: ".$_POST['termin_von_tag_wahl']."<br/>";
	//
	if ($_POST['fach_wahl'] == 0) {
		$formular_error[0] = 1;
	}
	if ($_POST['gerichtet_an_alle_schule'] == 1 && $_POST['experte_wahl'] == 0) {
		$formular_error[1] = 1;
	}
	//Datum vergleich vorher nachher:
	$monat_andersrum["Jan"] = 1;
	$monat_andersrum["Feb"] = 2;
	$monat_andersrum["Mar"] = 3;
	$monat_andersrum["Apr"] = 4;
	$monat_andersrum["Mai"] = 5;
	$monat_andersrum["Jun"] = 6;
	$monat_andersrum["Jul"] = 7;
	$monat_andersrum["Aug"] = 8;
	$monat_andersrum["Sep"] = 9;
	$monat_andersrum["Okt"] = 10;
	$monat_andersrum["Nov"] = 11;
	$monat_andersrum["Dez"] = 12;
	//
	if ($_POST['pruefungs_art_experte'] == 0 || $_POST['pruefungs_art_experte'] == 2) {

		for ($anz_dat = 0; $anz_dat < $_SESSION['anzahl_daten']; $anz_dat++) { 
			//
			$utc_von = mktime($_POST['termin_von_stunde_wahl_'.$anz_dat], $_POST['termin_von_minute_wahl_'.$anz_dat], 0, $monat_andersrum[$_POST['termin_von_monat_wahl_'.$anz_dat]], $_POST['termin_von_tag_wahl_'.$anz_dat], $_POST['termin_von_jahr_wahl_'.$anz_dat]);
			$utc_bis = mktime($_POST['termin_bis_stunde_wahl_'.$anz_dat], $_POST['termin_bis_minute_wahl_'.$anz_dat], 0, $monat_andersrum[$_POST['termin_von_monat_wahl_'.$anz_dat]], $_POST['termin_von_tag_wahl_'.$anz_dat], $_POST['termin_von_jahr_wahl_'.$anz_dat]);
			//
			if ($utc_bis <= $utc_von) {
				$formular_error[2] = 1;
			}
		}
		
	}
	if($_POST['pruefungs_art_experte'] == 0 || $_POST['pruefungs_art_experte'] == 1){
		$utc_von = mktime(0, 0, 0, $monat_andersrum[$_POST['korrektur_von_monat_wahl']], $_POST['korrektur_von_tag_wahl'], $_POST['korrektur_von_jahr_wahl']);
		$utc_bis = mktime(0, 0, 0, $monat_andersrum[$_POST['korrektur_bis_monat_wahl']], $_POST['korrektur_bis_tag_wahl'], $_POST['korrektur_bis_jahr_wahl']);
		//
		if ($utc_bis <= $utc_von) {
			$formular_error[3] = 1;
		}
	}
	//
	//echo date("l", mktime(6, 37, 0, 10, 7, 2010));
	/*if (strlen($_POST['email_schule']) == 0) {
		$formular_error[2] = 1;
	}
	if (strlen($_POST['email_schule']) > 0) {
		if (isValidEmail($_POST['email_schule']) == 0) {
			$formular_error[3] = 1;
		}
	}
	*/
	//wenn vorerst ok, dann Formular-Error 4 falls Email schon verwendet wird:
	if ($formular_error[0] == 0 && $formular_error[1] == 0 && $formular_error[2] == 0 && $formular_error[3] == 0) {
		//echo "are in last";
		include ("mysql_connect.php");
		//
		
		
		$termin_string = "";
		for ($anz_dat = 0; $anz_dat < $_SESSION['anzahl_daten']; $anz_dat++) { 
			$termin_string .= $_POST['termin_von_tag_wahl_'.$anz_dat].";".$_POST['termin_von_monat_wahl_'.$anz_dat].";".$_POST['termin_von_jahr_wahl_'.$anz_dat].";";
			$termin_string .= $_POST['termin_von_stunde_wahl_'.$anz_dat].";".$_POST['termin_von_minute_wahl_'.$anz_dat].";";
			$termin_string .= $_POST['termin_bis_stunde_wahl_'.$anz_dat].";".$_POST['termin_bis_minute_wahl_'.$anz_dat].";";
			$termin_string .= "---123MARGARIS321---";
		}
		//
		$korrektur_string = $_POST['korrektur_von_tag_wahl'].";".$_POST['korrektur_von_monat_wahl'].";".$_POST['korrektur_von_jahr_wahl'].";";
		$korrektur_string .= $_POST['korrektur_bis_tag_wahl'].";".$_POST['korrektur_bis_monat_wahl'].";".$_POST['korrektur_bis_jahr_wahl'].";";
		//
		if ($_POST['gerichtet_an_alle_schule'] == 0){
			$gerichtet_an_string = 0;
		}
		if ($_POST['gerichtet_an_alle_schule'] == 1){
			$gerichtet_an_string = $_POST['experte_wahl'];
		}
		//
		$sql = sprintf("INSERT INTO anfrage VALUES( NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
		mysql_real_escape_string($_SESSION['mysql_id']),
		mysql_real_escape_string($_POST['fach_wahl']),
		mysql_real_escape_string($_POST['pruefungs_art_experte']),
		mysql_real_escape_string($termin_string),
		mysql_real_escape_string($korrektur_string),
		mysql_real_escape_string($gerichtet_an_string),
		mysql_real_escape_string($_POST['klassen_kuerzel']));
		//
		$res = mysql_db_query( "hsgym-ep", $sql );
		//Globale Variabeln anpassen:
		//zurück zur hauptseite:
		$_SESSION['info_zeile'] = "Anfrage erfolgreich erstellt!";
		//header('Location: ./schule.php?rubrik=1');
		$_SESSION['anzahl_daten'] = 1;
	}
	//
?>