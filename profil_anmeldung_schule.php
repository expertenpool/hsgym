<?php
	session_start();
	//generelle Funktionen einbinden:
	include("functions/functions.php");
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
	if ($_SESSION['login_path'] != 1) {
		session_destroy();
		header('Location: ./');
	}
	//Formular abchecken:
	$formular_error = array(0, 0, 0, 0, 0, 0, 0,0,0);
	if($_POST["form_aktiv"]){
		include("profil_anmeldung/formular_check_schule.php");
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
	<body>
	
	<div align="center">
	<?php include("header/header.php");?>
	
	<?php include("navigation/navigation_leer.php");?>

	<div id="schatten">
		
	<div id="content_carrier">
	<table style="position:relative; top:0px; z-index:99;">
	<tr>
		<?php include("profil_anmeldung/formular_schule.php");?>
	</tr>
	</table>
	</div>
	
	</div>
		
	<?php include("footer.php"); ?>
	
	</div>
	</body>
</html>

