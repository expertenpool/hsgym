<?php
session_start();
session_regenerate_id(); 

$_SESSION['login_path'] = 0;
$login_error = 0;

$_SESSION['password_redirect'] = "false";
//generelle Funktionen einbinden:
include("functions/functions.php");
//

include("./functions/get_einstellungen.php");

//CANCELATION:
if($_SESSION['cancel_erfolgreich'] == "true") {
	$_SESSION['cancel_erfolgreich'] = "false";
	$_SESSION['info_zeile'] = "Konto erfolgreich gelöscht.";
	//unset($_COOKIE);
	//unset($_POST);
	//setcookie('email_schule',"",time() - 3600);
	//setcookie('passwort_schule', "", time() - 3600);
	/*$_POST['email_experte'] = "";
	$_POST['passwort_experte'] = "";
	$_COOKIE['email_experte'] = "";
	$_COOKIE['passwort_experte'] = "";*/
}

//DIRECT LOGIN: //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$_SESSION['redirect'] = 1;

if($_GET['v0'] == "direct_login") {
	//redirect ist direkt die rubrik, also 0 oder 1...
	$_POST['redirect'] = $_GET['v4'];
	if($_GET['v1'] == "experte") {
		$_POST['email_experte'] = $_GET['v2'];
		$_POST['passwort_experte'] = $_GET['v3'];
		if(strlen($_POST['email_experte']) && strlen($_POST['passwort_experte'])) {
			//database login check:
			include("login/direct_login_check_experte.php");
		}
	}
	if($_GET['v1'] == "schule") {
		$_POST['email_schule'] = $_GET['v2'];
		$_POST['passwort_schule'] = $_GET['v3'];
		if(strlen($_POST['email_schule']) && strlen($_POST['passwort_schule'])) {
			//database login check:
			include("login/direct_login_check_schule.php");
		}
	}
}

if($_POST["form1_aktiv"]){
	if(strlen($_POST['passwort_allgemein']) == 0) {
		$login_error = 4;
	}
	if(strlen($_POST['passwort_allgemein'])) {
		//passwort check:
		include("login/login_check_firsttime.php");
	}
}
if($_POST["form2_aktiv"]) {
	if(strlen($_POST['email_schule']) == 0) {
		$login_error = 5;
	}
	if(strlen($_POST['passwort_schule']) == 0) {
		$login_error = 6;
	}
	if(strlen($_POST['email_schule']) == 0 && strlen($_POST['passwort_schule']) == 0) {
		$login_error = 7;
	}
	if(strlen($_POST['email_schule']) && strlen($_POST['passwort_schule'])) {
	//database login check:
		include("login/login_check_schule.php");
	}
}
if($_POST["form3_aktiv"]) {
	if(strlen($_POST['email_experte']) == 0) {
		$login_error = 8;
	}
	if(strlen($_POST['passwort_experte']) == 0) {
		$login_error = 9;
	}
	if(strlen($_POST['email_experte']) == 0 && strlen($_POST['passwort_experte']) == 0) {
		$login_error = 10;
	}
	if(strlen($_POST['email_experte']) && strlen($_POST['passwort_experte'])) {
	//database login check:
		include("login/login_check_experte.php");
	}
}
//falls session= eingeloggt, dann direkt weiterleiten:
//schul-profil-anmelden:
if($_SESSION['login_path'] == 1){
	header('Location: profil_anmeldung_schule.php');
}
//experte-profil-anmelden:
if($_SESSION['login_path'] == 2){
	header('Location: profil_anmeldung_experte.php');
}
//Login für Schulen:
if($_SESSION['login_path'] == 3){
	header('Location: schule.php?rubrik='.$_SESSION['redirect']);
}
//Login für Experten:
if($_SESSION['login_path'] == 4){
	header('Location: experte.php?rubrik='.$_SESSION['redirect']);
}
//
//wegen aktivierungslink weiterleiten:
if($_GET['v0'] == "experte") {
	//header('Location: aktivierung.php?v0='.$_GET['v0']);
		include ("mysql_connect.php");
	$sql = sprintf("SELECT * FROM experte WHERE (email = '%s' AND aktivierungs_link = '%s')",
		mysql_real_escape_string($_GET['v1']),
		mysql_real_escape_string($_GET['v2']));
	$res = mysql_db_query( "hsgym-ep", $sql );
	$num_rows = mysql_num_rows($res); 
	if ($num_rows > 0) {
	//
		$sql = sprintf("UPDATE experte SET aktivierungs_link = '-1' WHERE (email = '%s' AND aktivierungs_link = '%s')",
			mysql_real_escape_string($_GET['v1']),
			mysql_real_escape_string($_GET['v2']));
		$res = mysql_db_query( "hsgym-ep", $sql );
			
		$_SESSION['info_zeile'] = "Aktivierung geglückt. Sie können sich jetzt als Expertin/Experte rechts unten einloggen.";
	//
	} else {
			$_SESSION['info_zeile'] = "Aktivierung nicht möglich. Falsche Daten.";
	}
}
if($_GET['v0'] == "schule") {
	//header('Location: aktivierung.php?v0='.$_GET['v0']);
		include ("mysql_connect.php");
	$sql = sprintf("SELECT * FROM schule WHERE (email = '%s' AND aktivierungs_link = '%s')",
		mysql_real_escape_string($_GET['v1']),
		mysql_real_escape_string($_GET['v2']));
	$res = mysql_db_query( "hsgym-ep", $sql );
	$num_rows = mysql_num_rows($res); 
	if ($num_rows > 0) {
	//
		$sql = sprintf("UPDATE schule SET aktivierungs_link = '-1' WHERE (email = '%s' AND aktivierungs_link = '%s')",
			mysql_real_escape_string($_GET['v1']),
			mysql_real_escape_string($_GET['v2']));
		$res = mysql_db_query( "hsgym-ep", $sql );
			
		$_SESSION['info_zeile'] = "Aktivierung geglückt. Sie können sich jetzt als Schule rechts oben einloggen.";
	//
	} else {
			$_SESSION['info_zeile'] = "Aktivierung nicht möglich. Falsche Daten.";
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

	<div id="schatten" style="position:relative; top:0px; z-index:2;">
		
	<?php include("info_zeile.php"); ?>
	
	<div id="content_carrier">
		
	<table style="position:relative; top:0px; z-index:99;">
	<tr>
		<td style="border-right: 1px solid #000000; width:450px" valign="top">
			<?php include("login/login_left.php");?>
		</td>
			<?php include("login/login_right.php");?>
	</tr>
	</table>
	</div>
	
	</div>
	
	<?php include("footer.php"); ?>

	</div>
	
	</body>
</html>

