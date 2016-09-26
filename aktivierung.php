<?php
session_start();
session_regenerate_id(); 
//
//wegen aktivierungslink weiterleiten:
/*if($_GET['v0']) {
	header('Location: aktivierung.php?v0='.$_GET['v0']);
}*/
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

