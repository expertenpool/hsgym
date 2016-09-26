<?php
	session_start();
	//
	include("./functions/get_fach_entries.php");
	include("./functions/get_region_entries.php");
	include("./functions/get_experte_entries.php");
	include("./functions/get_einstellungen.php");
	//
	if (isset($_SESSION['last_visit'])) {
		$laufzeit = time()-$_SESSION['last_visit'];
		if ($laufzeit > 3600) {
			//unset($_SESSION['last_visit']);
			session_destroy();
			header('Location: ./');
		}
	}
	//
	if (!isset($_SESSION['last_visit'])) {
		session_destroy();
		header('Location: ./');
	}
	if ($_SESSION['login_path'] != 3) {
		session_destroy();
		header('Location: ./');
	}
	//Rubrik-Variable
	if(!isset($_GET['rubrik'])){
		$rubrik = 1;
	}
	if(isset($_GET['rubrik'])){
		$rubrik = $_GET['rubrik'];
	}
	//Sort Variable
	if(!isset($_GET['sort'])){
		$sort = 0;
	}
	if(isset($_GET['sort'])){
		$sort = $_GET['sort'];
	}
	//Password Variable
	if(!isset($_GET['password'])){
		$password = 0;
	}
	if(isset($_GET['password'])){
		$password = $_GET['password'];
	}
	//Cancel Variable
	if(!isset($_GET['cancel'])){
		$cancel = 0;
	}
	if(isset($_GET['cancel'])){
		$cancel = $_GET['cancel'];
	}
	//
	//Formular abchecken:
	//Rubrik 1 stuff
	$formular_error = array(0, 0, 0, 0, 0, 0, 0, 0, 0);
	//erster Aufruf dieser Seite noch vor Formular-Aktivision:
	if(!$_POST["form_aktiv"]){
		$_POST['region_wahl'] = $_SESSION['mysql_region'];
		$_POST['email_versand_schule'] = $_SESSION['mysql_email_zusage'];
	}
	//
	if($_POST["form_aktiv"]){
		include("schule/schule_profil_anpassung.php");
	}
	if($_POST["form_password"]){
		include("schule/schule_password_anpassung.php");
	}
	if($_POST["form_cancel"]){
		include("schule/schule_cancel_execute.php");
	}
	//Rubrik 0 Stuff:
	if (!$_POST["form_anfrage_aktiv"]) {
		//beim ersten Aufruf der Rubrik 0, immer "schriftlich und mündlich" setzen:
		$_POST['pruefungs_art_experte'] = 0;
		//beim ersten Aufruf der Rubrik 0, immer "Gerichtet an alle Experten" setzen:
		$_POST['gerichtet_an_alle_schule'] = 0;
		//datum estmalig anpassen:
		
		//date.timezone = ;
		date_default_timezone_set("Europe/Zurich");
		$date_array = getdate();
		$monat = array("Jan","Feb", "Mar", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez");
		
		$_SESSION['anzahl_daten'] = 1;
		for ($anz_dat = 0; $anz_dat < $_SESSION['anzahl_daten']; $anz_dat++) { 
			$_POST['termin_von_tag_wahl_'.$anz_dat] = $date_array[mday];
			$_POST['termin_von_monat_wahl_'.$anz_dat] = $monat[$date_array[mon] - 1];
			$_POST['termin_von_jahr_wahl_'.$anz_dat] = $date_array[year];
			$_POST['termin_von_stunde_wahl_'.$anz_dat] = $date_array[hours];
			$_POST['termin_von_minute_wahl_'.$anz_dat] = $date_array[minutes];
			$_POST['termin_bis_stunde_wahl_'.$anz_dat] = $date_array[hours];
			$_POST['termin_bis_minute_wahl_'.$anz_dat] = $date_array[minutes];
		}
		//
		//
		$tempo = explode(";", $_SESSION['mysql_begutachtung_zeitraum']);
		
		$_POST['korrektur_von_tag_wahl'] = $tempo[0];
		$_POST['korrektur_von_monat_wahl'] = $tempo[1];
		$_POST['korrektur_von_jahr_wahl'] = $tempo[2];
		//
		$_POST['korrektur_bis_tag_wahl'] = $tempo[3];
		$_POST['korrektur_bis_monat_wahl'] = $tempo[4];
		$_POST['korrektur_bis_jahr_wahl'] = $tempo[5];
	}
	if($_POST["form_anfrage_aktiv"] == 1){
		include("schule/schule_anfrage_abschicken.php");
	}
	if ($_POST["form_anfrage_aktiv"] == 2) {
		// Grunddatum wieder setzen, falls User umgeswitcht hat (mündlich, schriftlich)
		if (!isset($_POST['korrektur_von_tag_wahl'])) {
			date_default_timezone_set("Europe/Zurich");
			$date_array = getdate();
			$monat = array("Jan","Feb", "Mar", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez");
			$_POST['korrektur_von_tag_wahl'] = $date_array[mday];
			$_POST['korrektur_von_monat_wahl'] = $monat[$date_array[mon] - 1];
			$_POST['korrektur_von_jahr_wahl'] = $date_array[year];
			//
			$_POST['korrektur_bis_tag_wahl'] = $date_array[mday];
			$_POST['korrektur_bis_monat_wahl'] = $monat[$date_array[mon] - 1];
			$_POST['korrektur_bis_jahr_wahl'] = $date_array[year];
		}
		if (!isset($_POST['termin_von_tag_wahl_0'])) {
			date_default_timezone_set("Europe/Zurich");
			$date_array = getdate();
			$monat = array("Jan", "Feb", "Mar", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez");
			$_SESSION['anzahl_daten'] = 1;
			for ($anz_dat = 0; $anz_dat < $_SESSION['anzahl_daten']; $anz_dat++) { 
				$_POST['termin_von_tag_wahl_'.$anz_dat] = $date_array[mday];
				$_POST['termin_von_monat_wahl_'.$anz_dat] = $monat[$date_array[mon] - 1];
				$_POST['termin_von_jahr_wahl_'.$anz_dat] = $date_array[year];
				$_POST['termin_von_stunde_wahl_'.$anz_dat] = $date_array[hours];
				$_POST['termin_von_minute_wahl_'.$anz_dat] = $date_array[minutes];
				//
				/*$_POST['termin_bis_tag_wahl'] = $date_array[mday];
				$_POST['termin_bis_monat_wahl'] = $monat[$date_array[mon] - 1];
				$_POST['termin_bis_jahr_wahl'] = $date_array[year];*/
				$_POST['termin_bis_stunde_wahl_'.$anz_dat] = $date_array[hours];
				$_POST['termin_bis_minute_wahl_'.$anz_dat] = $date_array[minutes];
			}
		}
	}
	if($_POST["form_anfrage_aktiv"] == 3){
		include("schule/schule_anfrage_loeschen.php");
	}
	//neue specials:
	//"Termin hinzufügen" gedrückt:
	if ($_POST["form_anfrage_aktiv"] == 101) {
		date_default_timezone_set("Europe/Zurich");
		$date_array = getdate();
		$monat = array("Jan", "Feb", "Mar", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez");
		$_SESSION['anzahl_daten'] += 1;
		for ($anz_dat = $_SESSION['anzahl_daten']-1; $anz_dat < $_SESSION['anzahl_daten']; $anz_dat++) { 
			$_POST['termin_von_tag_wahl_'.$anz_dat] = $date_array[mday];
			$_POST['termin_von_monat_wahl_'.$anz_dat] = $monat[$date_array[mon] - 1];
			$_POST['termin_von_jahr_wahl_'.$anz_dat] = $date_array[year];
			$_POST['termin_von_stunde_wahl_'.$anz_dat] = $date_array[hours];
			$_POST['termin_von_minute_wahl_'.$anz_dat] = $date_array[minutes];
			$_POST['termin_bis_stunde_wahl_'.$anz_dat] = $date_array[hours];
			$_POST['termin_bis_minute_wahl_'.$anz_dat] = $date_array[minutes];
		}
		//Falls 2 Termina jetzt da, soll das neue das Datum des alten gleich übernehmen:
		if ($_SESSION['anzahl_daten'] > 1) {
			$_POST['termin_von_tag_wahl_'.intval($_SESSION['anzahl_daten']-1)] = $_POST['termin_von_tag_wahl_'.intval($_SESSION['anzahl_daten']-2)];
			$_POST['termin_von_monat_wahl_'.intval($_SESSION['anzahl_daten']-1)] = $_POST['termin_von_monat_wahl_'.intval($_SESSION['anzahl_daten']-2)] ;
			$_POST['termin_von_jahr_wahl_'.intval($_SESSION['anzahl_daten']-1)] = $_POST['termin_von_jahr_wahl_'.intval($_SESSION['anzahl_daten']-2)];
		}
	}
	//ein Datum löschen:
	if ($_POST["form_anfrage_aktiv"] >= 2000) {
		$welches = intval($_POST["form_anfrage_aktiv"]-2000);
		//echo intval($_POST["form_anfrage_aktiv"]-2000);
		for ($anz_dat = $welches; $anz_dat < $_SESSION['anzahl_daten']-1; $anz_dat++) { 
			$_POST['termin_von_tag_wahl_'.$anz_dat] = $_POST['termin_von_tag_wahl_'.intval($anz_dat+1)];
			$_POST['termin_von_monat_wahl_'.$anz_dat] = $_POST['termin_von_monat_wahl_'.intval($anz_dat+1)];
			$_POST['termin_von_jahr_wahl_'.$anz_dat] = $_POST['termin_von_jahr_wahl_'.intval($anz_dat+1)];
			$_POST['termin_von_stunde_wahl_'.$anz_dat] = $_POST['termin_von_stunde_wahl_'.intval($anz_dat+1)];
			$_POST['termin_von_minute_wahl_'.$anz_dat] = $_POST['termin_von_minute_wahl_'.intval($anz_dat+1)];
			$_POST['termin_bis_stunde_wahl_'.$anz_dat] = $_POST['termin_bis_stunde_wahl_'.intval($anz_dat+1)];
			$_POST['termin_bis_minute_wahl_'.$anz_dat] = $_POST['termin_bis_minute_wahl_'.intval($anz_dat+1)];
		}
		unset($_POST['termin_von_tag_wahl_'.intval($_SESSION['anzahl_daten']-1)]);
		unset($_POST['termin_von_monat_wahl_'.intval($_SESSION['anzahl_daten']-1)]);
		unset($_POST['termin_von_jahr_wahl_'.intval($_SESSION['anzahl_daten']-1)]);
		unset($_POST['termin_von_stunde_wahl_'.intval($_SESSION['anzahl_daten']-1)]);
		unset($_POST['termin_von_minute_wahl_'.intval($_SESSION['anzahl_daten']-1)]);
		unset($_POST['termin_bis_stunde_wahl_'.intval($_SESSION['anzahl_daten']-1)]);
		unset($_POST['termin_bis_minute_wahl_'.intval($_SESSION['anzahl_daten']-1)]);
			
		$_SESSION['anzahl_daten'] -= 1;
		
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	   "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<title>Expertenpool</title>
		<meta http-equiv="pragma" content="no-cache">
		<meta http-equiv="cache-control" content="no-cache">
		<meta http-equiv="expires" content="0">
		<link rel="stylesheet" href="css/style.css" type="text/css" media="screen, projection" />
	</head>
	<body>
	
	<div align="center">
	<?php include("header/header_schule.php");?>
	
	<?php include("navigation/navigation_schule.php");?>

	<div id="schatten">
	
	<?php include("info_zeile.php"); ?>
	
	<div id="content_carrier">
	<?php 
		if($cancel == 0){
			if($password == 0){
				include("schule/schule_rubrik".$rubrik.".php");
			}
			if($password == 1){
				include("schule/schule_password.php");
			}
		}
		if($password == 0){
			if($cancel == 1){
				include("schule/schule_cancel.php");
			}
		}
	?>
	</div>
	
	
	</div>
	
	<?php include("footer.php"); ?>
	
	</div>
	</body>
</html>

