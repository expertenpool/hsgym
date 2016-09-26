<?php
	if (strlen($_POST['name_experte']) == 0) {
		$formular_error[0] = 1;
	}
	if (strlen($_POST['adresse_experte']) == 0) {
		$formular_error[1] = 1;
	}
	if (strlen($_POST['email_experte']) == 0) {
		$formular_error[2] = 1;
	}
	if (strlen($_POST['email_experte']) > 0) {
		if (isValidEmail($_POST['email_experte']) == 0) {
			$formular_error[3] = 1;
		}
	}
	if (strlen($_POST['passwort1_experte']) == 0 || strlen($_POST['passwort2_experte']) == 0) {
		$formular_error[5] = 1;
	}
	if (strlen($_POST['passwort1_experte']) > 0 && strlen($_POST['passwort2_experte']) > 0) {
		if ($_POST['passwort1_experte'] != $_POST['passwort2_experte']) {
			$formular_error[5] = 1;
		}
		if ($_POST['passwort1_experte'] == $_POST['passwort2_experte']) {
			if (strlen($_POST['passwort1_experte']) < 6) {
				$formular_error[6] = 1;
			}
		}
	}
	//
	$fach_string = ";";
	for($i2=0;$i2<100;$i2++){ 
		if ($_POST['fach_wahl'.$i2] != 0) {
			$fach_string .= $_POST['fach_wahl'.$i2].";";
		}
	}
	$region_string = ";";
	for ($i2 = 0; $i2 < 100; $i2++) { 
		if ($_POST['region_werte'][$i2] != 0) {
			$region_string .= $_POST['region_werte'][$i2].";";
		}
	}
	//
	$zeitplan_string = "000000000000";
	//echo $zeitplan_string."<br/>";
	//echo $_POST['zeitplan_wahl'].":  ";
	for ($i2 = 0; $i2 <count($_POST['zeitplan_werte']); $i2++) { 
		//echo $_POST['zeitplan_werte'][$i2].",";
		$zeitplan_string[$_POST['zeitplan_werte'][$i2]] = "1";
	}
	//wenn vorerst ok, dann Formular-Error 4 falls Email schon verwendet wird:
	if($formular_error[0] == 0 && $formular_error[1] == 0 && $formular_error[2] == 0 && $formular_error[3] == 0 && $formular_error[5] == 0 && $formular_error[6] == 0){
		include ("mysql_connect.php");
		//
		$sql = sprintf("SELECT * FROM experte WHERE (email = '%s')",
		mysql_real_escape_string($_POST['email_experte']));
		$res = mysql_db_query( "hsgym-ep", $sql );
	
		$num_rows = mysql_num_rows($res); 
		
		if ($num_rows == 1) {
			$formular_error[4] = 1;
		}
		if ($num_rows == 0) {
			$pass = md5($_POST['passwort1_experte']);
			//
			$aktivierungs_link = md5($_POST['name_experte'].time());
			$reset_link = 0;
			$reset_time = 0;
			$last_login = time();
			$sql = sprintf("INSERT INTO experte VALUES (null,'%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
			mysql_real_escape_string($_POST['name_experte']),
			mysql_real_escape_string($_POST['titel_experte']),
			mysql_real_escape_string($_POST['institut_experte']),
			mysql_real_escape_string($_POST['adresse_experte']),
			mysql_real_escape_string($_POST['email_experte']),
			mysql_real_escape_string(0),//$_POST['region_art_experte']),
			mysql_real_escape_string($region_string),
			mysql_real_escape_string(0),//$_POST['zeitplan_art_experte']),
			mysql_real_escape_string($zeitplan_string),
			mysql_real_escape_string(0),//$_POST['pruefungs_art_experte']),
			mysql_real_escape_string($fach_string),
			mysql_real_escape_string($pass),
			mysql_real_escape_string($aktivierungs_link),
			mysql_real_escape_string($reset_link),
			mysql_real_escape_string($reset_time),
			mysql_real_escape_string($last_login));
			//
			$res = mysql_db_query( "hsgym-ep", $sql );
		
			//
			$_SESSION['info_zeile'] = "E-Mail wurde gesendet. Bitte folgen Sie den Anweisungen in der E-Mail.";
			//
			$mailTo = $_POST['email_experte'];
			$mailFrom = "From: hsgym-expertenpool.ch <info@hsgym-expertenpool.ch>";
			//$mailFrom = "From: hsgym-expertenpool.ethz.ch <info@hsgym-expertenpool.ethz.ch>";
			$mailSubject = "Registrierung (Experte) - HSGYM Expertenpool ";
			$mailBody = "Guten Tag ".$_POST['name_experte']."\n\nSie haben sich als Experte im HSGYM-Expertenpool angemeldet.\n";
			$mailBody .= "\nUm die Gültigkeit Ihrer E-Mail-Adresse zu verifizieren, klicken Sie auf diesen Aktivierungslink:";
			$mailBody .= "\n\nhttp://www.hsgym-expertenpool.ch/?v0=experte&v1=".$_POST['email_experte']."&v2=".$aktivierungs_link;
			$mailBody .= "\n\n";
            mail($mailTo, utf8_decode($mailSubject), utf8_decode($mailBody), $mailFrom);
			//
				//zurück zur hauptseite:
			header('Location: ./');
		}
	}
	//
?>