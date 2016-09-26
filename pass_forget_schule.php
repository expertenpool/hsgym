<?php
	$login_error = 0;
	if($_POST["form1_aktiv"]){
		if (strlen($_POST['email_schule']) == 0) {
			$login_error = 1;
		}
		if ($login_error == 0) {
			$zufall_reset_link = md5(rand(1, 1000000).time());

			include ("mysql_connect.php");
			$sql = sprintf("SELECT * FROM schule WHERE (email = '%s')",
				mysql_real_escape_string($_POST['email_schule']));
			$res = mysql_db_query( "hsgym-ep", $sql );
	
			$num_rows = mysql_num_rows($res); 
			if ($num_rows > 0) {
				//echo "ja";
				$sql = sprintf("UPDATE schule SET reset_link = '%s', reset_time = '%s' WHERE (email = '%s')",
					mysql_real_escape_string($zufall_reset_link),
					mysql_real_escape_string(time()),
					mysql_real_escape_string($_POST['email_schule']));
				$res = mysql_db_query( "hsgym-ep", $sql );
							//
				//
				$mailTo = $_POST['email_schule'];
				//$mailFrom = "From: hsgym-expertenpool.ethz.ch <info@hsgym-expertenpool.ethz.ch>";
				$mailFrom = "From: hsgym-expertenpool.ch <info@hsgym-expertenpool.ch>";
				$mailSubject = "Passwort-Reset - HSGYM Expertenpool ";
				$mailBody = "Guten Tag \n\nSie sind als Schule im Expertenpool der HSGYM angemeldet.\n";
				$mailBody .= "\nSie haben Ihr Passwort vergessen und deshalb dieses E-Mail angefordert.";
				$mailBody .= "\nUm ein neues Passwort zu setzen, klicken Sie auf diesen Aktivierungslink:";
				$mailBody .= "\n\nhttp://www.hsgym-expertenpool.ch/pass_reset.php?v0=schule&v1=".$_POST['email_schule']."&v2=".$zufall_reset_link;
				$mailBody .= "\n\nSollten Sie diese E-Mail gar nicht verlangt haben, betrachten Sie diese bitte als gegenstandslos an.";
				mail($mailTo, utf8_decode($mailSubject), utf8_decode($mailBody), $mailFrom);
				//
				//http://localhost/Expertenpool/pass_reset.php?v0=experte&v1=george@margaris.de&v2=490f7821536f3b8ada2cbf7116d25c44
				//
			}
			$_SESSION['info_zeile'] = "Falls ein Schul-Konto mit dieser E-Mail-Adresse existiert und aktiviert ist, dann wurde soeben ein E-Mail abgesendet. <br/>Bitte folgen Sie den Anweisungen in diesem E-Mail.";
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
			<div id="content_left">
				
				<form method="post">
					<p>Sie haben sich als Schule registriert, jedoch Ihr Passwort vergessen?</p>
					<p>Bitte geben Sie die E-Mail-Adresse an, mit der Sie sich registriert haben:</p>
					<br/>
					<p>
					<table style="font-size: 1em;">
						<tr>
							<td style="width:70px" valign="top">
								E-Mail:
							</td>
							<td style="width:230px;" valign="top">
								
								<input type="password" autocomplete="off" name="email_schule" value="" style="width: 220px">
							</td>
							<td style="width:70px" valign="top">
								<input type="hidden" name="form1_aktiv" value="1"/>
								<input type="image" name="submit" src="assets/button_email_abschicken.png">
							</td>
						</tr>
					</table>
					<?php
						if($login_error == 1){
						?>
						<p><font color="#FF0000">Bitte eine gültige E-Mail-Adresse eingeben!</font></p>
						<?php
						};
					?>
					</p>
				</form>
			</div>
		</td>
		<td style="width:450px" valign="top">
			<div id="content_right">
				<p>Sie erhalten anschliessend eine E-Mail mit einem 24 Stunden lang gültigen Aktivierungslink.</p>
				<p>Durch Klick auf den Aktivierungslink werden Sie auf eine Spezialseite geleitet, wo Sie die Möglichkeit haben, Ihr Passwort neu zu setzen.</p>
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

