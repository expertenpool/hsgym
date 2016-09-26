<?php
	session_start();
	session_regenerate_id(); 

	$login_error = 0;
	$formular_error = array(0, 0, 0, 0, 0, 0, 0, 0, 0);
	if ($_POST["form_password"]) {
		
		if (strlen($_POST['passwort_neu1']) == 0 || strlen($_POST['passwort_neu2']) == 0) {
			$formular_error[5] = 1;
		}
		if (strlen($_POST['passwort_neu1']) > 0 && strlen($_POST['passwort_neu2']) > 0) {
			if ($_POST['passwort_neu1'] != $_POST['passwort_neu2']) {
				$formular_error[5] = 1;
			}
			if ($_POST['passwort_neu1'] == $_POST['passwort_neu2']) {
				if (strlen($_POST['passwort_neu1']) < 6) {
					$formular_error[6] = 1;
				}
			}
		}
		//
		if ($formular_error[5] == 0 && $formular_error[6] == 0) {
			include ("mysql_connect.php");
				
				if($_SESSION["mysql_typ"] == "experte"){
					$sql = sprintf("UPDATE experte SET reset_link = '%s', reset_time = '%s', passwort = '%s' WHERE (email = '%s')",
					mysql_real_escape_string("0"),
					mysql_real_escape_string("0"),
					mysql_real_escape_string(md5($_POST['passwort_neu1'])),
					mysql_real_escape_string($_SESSION["mysql_email"]));
				}
				if($_SESSION["mysql_typ"] == "schule"){
					$sql = sprintf("UPDATE schule SET reset_link = '%s', reset_time = '%s', passwort = '%s' WHERE (email = '%s')",
					mysql_real_escape_string("0"),
					mysql_real_escape_string("0"),
					mysql_real_escape_string(md5($_POST['passwort_neu1'])),
					mysql_real_escape_string($_SESSION["mysql_email"]));
				}
			$res = mysql_db_query( "hsgym-ep", $sql );
			$_SESSION['password_redirect'] = "ok";
			
			//header('Location: ./');
		}
	
	}
	//
	//
	if ($_GET['v0'] == "experte") {
		$_SESSION["passwort_reset_erlaubt"] = "nein";
		include ("mysql_connect.php");
	$sql = sprintf("SELECT * FROM experte WHERE (email = '%s' AND reset_link = '%s')",
		mysql_real_escape_string($_GET['v1']),
		mysql_real_escape_string($_GET['v2']));
	$res = mysql_db_query( "hsgym-ep", $sql );
	$num_rows = mysql_num_rows($res); 
	if ($num_rows > 0) {
		$_SESSION["passwort_reset_erlaubt"] = "ja";
		$ausgabe = mysql_fetch_array ($res);
		$vergangene_zeit = time() - $ausgabe[reset_time];
		$_SESSION["mysql_name"] = $ausgabe[name];
		$_SESSION["mysql_email"] = $ausgabe[email];
		$_SESSION["mysql_typ"] = "experte";
		if ($vergangene_zeit > 86400) {
			$_SESSION["passwort_reset_erlaubt"] = "ausgelaufen";
			$_SESSION['info_zeile'] = "Passwort-Reset nicht möglich. Aktivierungs-Link ist älter als 24 Stunden und deshalb nicht mehr gültig.";
		}
	} else {
			$_SESSION['info_zeile'] = "Passwort-Reset nicht möglich. Falsche Daten.";
	}
	}
	//
	//
	if ($_GET['v0'] == "schule") {
		$_SESSION["passwort_reset_erlaubt"] = "nein";
		include ("mysql_connect.php");
	$sql = sprintf("SELECT * FROM schule WHERE (email = '%s' AND reset_link = '%s')",
		mysql_real_escape_string($_GET['v1']),
		mysql_real_escape_string($_GET['v2']));
	$res = mysql_db_query( "hsgym-ep", $sql );
	$num_rows = mysql_num_rows($res); 
	if ($num_rows > 0) {
		$_SESSION["passwort_reset_erlaubt"] = "ja";
		$ausgabe = mysql_fetch_array ($res);
		$vergangene_zeit = time() - $ausgabe[reset_time];
		$_SESSION["mysql_name"] = $ausgabe[name];
		$_SESSION["mysql_email"] = $ausgabe[email];
		$_SESSION["mysql_typ"] = "schule";
		if ($vergangene_zeit > 86400) {
			$_SESSION["passwort_reset_erlaubt"] = "ausgelaufen";
			$_SESSION['info_zeile'] = "Passwort-Reset nicht möglich. Aktivierungs-Link ist älter als 24 Stunden und deshalb nicht mehr gültig.";
		}
	} else {
			$_SESSION['info_zeile'] = "Passwort-Reset nicht möglich. Falsche Daten.";
	}
	}
	//
	//
	if($_SESSION['password_redirect'] == "ok"){
		$_SESSION['info_zeile'] = "Passwort-Änderung erfolgreich.";
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

			<div id="content_left">
			<?php if($_SESSION['password_redirect'] == "ok"){ ?>
				<p>
					<a style="text-decoration: none;" href="./" target="_self">Hier einloggen >></a>
				</p>
			<?php } ?>
			<?php if($_SESSION["passwort_reset_erlaubt"] == "ja"){ ?>		
			<form method="post">
				<p><b>Passwort-Änderung</b></p>
				<p>Guten Tag <?php echo $_SESSION["mysql_name"]; ?></p>
				<p>Sie wurden auf diese Seite geleitet da Sie Ihr Passwort vergessen haben. <br/>Sie können hier ihr Passwort neu setzen.</p>

				<p>Neues Passwort zweimal eingeben:<br/>
				<input type="password" name="passwort_neu1" style="width: 420px" value="<?php if(isset($_POST['passwort_neu1'])){ echo $_POST['passwort_neu1']; }?>">
				<input type="password" name="passwort_neu2" style="width: 420px" value="<?php if(isset($_POST['passwort_neu2'])){ echo $_POST['passwort_neu2']; }?>"></p>

				<?php 	$error_string=""; 
				//if($formular_error[0] == 1){	$error_string .="Bitte altes Passwort eingeben! "; }

				if($formular_error[5] == 1) {	$error_string .= "Bitte Passwort zwei Mal eingeben."; }
				if($formular_error[6] == 1) {	$error_string .= "Passwort muss mindestens 6 Zeichen haben."; }
				if($formular_error[7] == 1){	$error_string .= "Altes Passwort ist ungültig."; }
				if(strlen($error_string)>0){ 	?>		<p><div style="padding-right: 20px"><font color="#FF0000"><?php echo $error_string; ?></font></div></p>	<?php	} ?>

				<input type="hidden" name="form_password" value="1"/>
				<p><div align="right" style="padding-right: 20px"><input type="image" name="submit" src="assets/button_passwort.png"></div></p>
			</form>
			<?php } ?>
			</div>
			</td>

			<td style="width:450px" valign="top">
			<div id="content_right">

			</div>
			</td>
		</tr>
	</table>
	</div>
	
	</div>
	
	<?php include("footer.php"); ?>

	</div>
	
	</body>
</html>

