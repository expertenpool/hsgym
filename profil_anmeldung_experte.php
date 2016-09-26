<?php
	session_start();
	//generelle Funktionen einbinden:
	include("functions/functions.php");
	//
	//
	include("./functions/get_fach_entries.php");
	include("./functions/get_region_entries.php");
	//
	//
	if (isset($_SESSION['last_visit'])) {
		$laufzeit = time()-$_SESSION['last_visit'];
		if ($laufzeit > 600) {
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
	if ($_SESSION['login_path'] != 2) {
		session_destroy();
		header('Location: ./');
	}
	//Formular abchecken:
	$formular_error = array(0, 0, 0, 0, 0, 0, 0,0,0);
	if($_POST["form_aktiv"] == 1){
		include("profil_anmeldung/formular_check_experte.php");
	}
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
		$_SESSION['mysql_region'] = $region_string;
		$temp_region = explode(";", $_SESSION['mysql_region']);
		for ($i = 1; $i < count($temp_region) - 1; $i++) {
			for ($i2 = 0; $i2 < count($region_DATA); $i2++) {
				if($region_DATA[$i2][0] == $temp_region[$i]){
					$_POST['region_wahl'.$i2] = $temp_region[$i];
				}
			}
		}
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
	<?php include("header/header.php");?>
	
	<?php include("navigation/navigation_leer.php");?>

	<div id="schatten">
		
	<div id="content_carrier">
	<table style="position:relative; top:0px; z-index:99;">
	<tr>
		<?php include("profil_anmeldung/formular_experte.php");?>
	</tr>
	</table>
	</div>
	
	</div>
	
	<?php include("footer.php"); ?>
	
	</div>
	</body>
</html>

