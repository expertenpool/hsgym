<?php
	if (strlen($_POST['name_schule']) == 0) {
		$formular_error[0] = 1;
	}
	if (strlen($_POST['adresse_schule']) == 0) {
		$formular_error[1] = 1;
	}
	if (strlen($_POST['email_schule']) == 0) {
		$formular_error[2] = 1;
	}
	if (strlen($_POST['email_schule']) > 0) {
		if (isValidEmail($_POST['email_schule']) == 0) {
			$formular_error[3] = 1;
		}
	}
	if (strlen($_POST['passwort1_schule']) == 0 || strlen($_POST['passwort2_schule']) == 0) {
		$formular_error[5] = 1;
	}
	if (strlen($_POST['passwort1_schule']) > 0 && strlen($_POST['passwort2_schule']) > 0) {
		if ($_POST['passwort1_schule'] != $_POST['passwort2_schule']) {
			$formular_error[5] = 1;
		}
		if ($_POST['passwort1_schule'] == $_POST['passwort2_schule']) {
			if (strlen($_POST['passwort1_schule']) < 6) {
				$formular_error[6] = 1;
			}
		}
	}
	
	if ($_POST['region_wahl'] == 0) {
		$formular_error[7] = 1;
	}
	//wenn vorerst ok, dann Formular-Error 4 falls Email schon verwendet wird:
	if($formular_error[0] == 0 && $formular_error[1] == 0 && $formular_error[2] == 0 && $formular_error[3] == 0 && $formular_error[5] == 0 && $formular_error[6] == 0){
		include ("mysql_connect.php");
		//
		$sql = sprintf("SELECT * FROM schule WHERE (email = '%s')",
		mysql_real_escape_string($_POST['email_schule']));
		$res = mysql_db_query( "hsgym-ep", $sql );
	
		$num_rows = mysql_num_rows($res); 
		
		if ($num_rows == 1) {
			$formular_error[4] = 1;
		}
		if ($num_rows == 0) {
			$pass = md5($_POST['passwort1_schule']);
			//
			$aktivierungs_link = md5($_POST['name_schule'].time());
			$reset_link = 0;
			$reset_time = 0;
			$last_login = time();
			$sql = sprintf("INSERT INTO schule VALUES (null,'%s','%s','%s','%s','1','%s','%s','%s','%s','%s')",
			mysql_real_escape_string($_POST['name_schule']),
			mysql_real_escape_string($_POST['adresse_schule']),
			mysql_real_escape_string($_POST['region_wahl']),
			mysql_real_escape_string($_POST['email_schule']),
			mysql_real_escape_string($pass),
			mysql_real_escape_string($aktivierungs_link),
			mysql_real_escape_string($reset_link),
			mysql_real_escape_string($reset_time),
			mysql_real_escape_string($last_login));
			//
			$res = mysql_db_query( "hsgym-ep", $sql );
			//zurück zur hauptseite:
			$_SESSION['info_zeile'] = "E-Mail wurde gesendet. Bitte folgen Sie den Anweisungen in der E-Mail.";
			//
			$mailTo = $_POST['email_schule'];
			$mailFrom = "From: hsgym-expertenpool.ch <info@hsgym-expertenpool.ch>";
			$mailSubject = "Registrierung (Schule) - HSGYM Expertenpool ";
			$mailBody = "Guten Tag ".$_POST['name_schule']."\n\nSie haben sich als Schule im HSGYM-Expertenpool angemeldet.\n";
			$mailBody .= "\nUm die Gültigkeit Ihrer E-Mail-Adresse zu verifizieren klicken Sie auf diesen Aktivierungslink:";
			$mailBody .= "\n\nhttp://www.hsgym-expertenpool.ch/?v0=schule&v1=".$_POST['email_schule']."&v2=".$aktivierungs_link;
			$mailBody .= "\n\n";
            mail($mailTo, utf8_decode($mailSubject), utf8_decode($mailBody), $mailFrom);
			//
			header('Location: ./');
		}
	}
	//
?>