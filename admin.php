<?php
session_start();
session_regenerate_id(); 

$_SESSION['login_path'] = 0;
$login_error = 0;

//generelle Funktionen einbinden:
include("functions/functions.php");
//
if($_POST["form_aktiv"]) {
	if(strlen($_POST['email_admin']) == 0) {
		$login_error = 5;
	}
	if(strlen($_POST['passwort_admin']) == 0) {
		$login_error = 6;
	}
	if(strlen($_POST['email_admin']) == 0 && strlen($_POST['passwort_admin']) == 0) {
		$login_error = 7;
	}
	if(strlen($_POST['email_admin']) && strlen($_POST['passwort_admin'])) {
	//database login check:
		include("admin/login_check_admin.php");
	}
}
//falls session= eingeloggt, dann direkt weiterleiten:
//Login für Experten:
if($_SESSION['login_path'] == 1){
	header('Location: admin_index.php');
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
	<?php include("header/header_admin_leer.php");?>

	<?php include("navigation/navigation_leer.php");?>

	<div id="schatten" style="position:relative; top:0px; z-index:2;">
		
	<?php include("info_zeile.php"); ?>
	
	<div id="content_carrier">
		
	<table style="position:relative; top:0px; z-index:99;">
	<tr>
		<td style="border-right: 1px solid #000000; width:450px" valign="top">
			<?php include("admin/admin_left.php");?>
		</td>
		<td style="width:450px" valign="top">
			
		</td>
	</tr>
	</table>
	</div>
	
	</div>
	
	<?php include("footer.php"); ?>

	</div>
	
	</body>
</html>

