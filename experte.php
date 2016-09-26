<?php
	session_start();
	//
	include("./functions/get_fach_entries.php");
	include("./functions/get_region_entries.php");
	//
	include ("experte/bereits_zugesagte.php");
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
	if ($_SESSION['login_path'] != 4) {
		session_destroy();
		header('Location: ./');
	}
	//
	//Rubrik Variable
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
	$formular_error = array(0, 0, 0, 0, 0, 0, 0,0,0);
	if($_POST["form_aktiv"] == 1){
		include("experte/experte_profil_anpassung.php");
	}
	if($_POST["form_password"]){
		include("experte/experte_password_anpassung.php");
	}
	if($_POST["form_cancel"]){
		include("experte/experte_cancel_execute.php");
	}
	//
	//
	//
	if ($_POST["form_aktiv"]) {
		// Zeitplan auswahl mitübertragen wenn ein anderer POST Bereich updaten will, z.b. onchange-javascript
		$zeitplan_string = "000000000000";
		for ($i2 = 0; $i2 <count($_POST['zeitplan_werte']); $i2++) { 
			$zeitplan_string[$_POST['zeitplan_werte'][$i2]] = "1";
		}
		$_SESSION['mysql_zeitplan'] = $zeitplan_string;
		$temp_zeitplan = $_SESSION['mysql_zeitplan'];
		for ($i = 0; $i <= 11; $i++) {
			$_POST['zeitplan_wahl'.$i] = $temp_zeitplan[$i];
		}
		// Region Auswahl mitübertragen wenn ein anderer POST Bereich updaten will, z.b. onchange-javascript
		$region_string = ";";
		for ($i2 = 0; $i2 < 100; $i2++) { 
			$region_string .= $_POST['region_werte'][$i2].";";
		}
		//echo $region_string;
		$_SESSION['mysql_region'] = $region_string;
		$temp_region = explode(";", $_SESSION['mysql_region']);
		for ($i = 1; $i < count($temp_region) - 1; $i++) {
			for ($i2 = 0; $i2 < count($region_DATA); $i2++) {
				if($region_DATA[$i2][0] == $temp_region[$i]){
					$_POST['region_wahl'.$i2] = $temp_region[$i];
				}
			}
		}
		//
		
	}
	if (!$_POST["form_aktiv"]) {
		$_POST['region_art_experte'] = $_SESSION['mysql_region_art'];
		$_POST['pruefungs_art_experte'] = $_SESSION['mysql_fach_art'];
		$_POST['zeitplan_art_experte'] = $_SESSION['mysql_zeitplan_art'];
		//Ganz zu Beginn beim experten Rubrik 1 die Fächer in Post-Variabeln reinschreiben
		$temp_fach = explode(";", $_SESSION['mysql_fach']);
		for($i=1; $i<count($temp_fach)-1;$i++){
			$_POST['fach_wahl'.$i] = $temp_fach[$i];
		}
		//
		$temp_zeitplan = $_SESSION['mysql_zeitplan'];
		for ($i = 0; $i <= 11; $i++) {
			$_POST['zeitplan_wahl'.$i] = $temp_zeitplan[$i];
		}
		//
		$temp_region = explode(";", $_SESSION['mysql_region']);
		for ($i = 1; $i < count($temp_region) - 1; $i++) {
			for ($i2 = 0; $i2 < count($region_DATA); $i2++) {
				if($region_DATA[$i2][0] == $temp_region[$i]){
					$_POST['region_wahl'.$i2] = $temp_region[$i];
				}
			}
		}
		//
	}
	//ECHO rubrik 1
	if ( $_POST["image_geklickt"]) {
		
		include("experte/absage_zusage.php");
	}
	//
	

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
	<body >

	<div align="center">
	<?php include("header/header_experte.php");?>
	
	<?php include("navigation/navigation_experte.php");?>
	
	<div id="schatten" >
	<?php 
	include("info_zeile.php"); 
	?>
	
	<div id="content_carrier">
	<?php 
		//echo $_SESSION['mysql_fach'];
		
		if($cancel == 0){
			if($password == 0){
				include("experte/experte_rubrik".$rubrik.".php");
			}
			if($password == 1){
				include("experte/experte_password.php");
			}
		}
		if($password == 0){
			if($cancel == 1){
				include("experte/experte_cancel.php");
			}
		}
	?>
	</div>
	
	</div>
	
	<?php include("footer.php"); ?>
	
	</div>
	
	</body>
</html>

