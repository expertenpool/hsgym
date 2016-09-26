<?php
	include ("mysql_connect.php");

	//
	$sql = sprintf("SELECT * FROM schule WHERE (email = '%s' AND passwort = '%s')",
		mysql_real_escape_string($_POST['email_schule']),
		mysql_real_escape_string(md5($_POST['passwort_schule'])));
	$res = mysql_db_query( "hsgym-ep", $sql );
	
	$num_rows = mysql_num_rows($res); 
	if ($num_rows > 0) {
		//Ok, jetzt userdaten der datenbank auswerten:
		$ausgabe = mysql_fetch_array ($res);
		if($ausgabe[aktivierungs_link] == -1){
		$_SESSION['mysql_id'] = $ausgabe[id];
		$_SESSION['mysql_name'] = $ausgabe[name];
		$_SESSION['mysql_adresse'] = $ausgabe[adresse];
		$_SESSION['mysql_region'] = $ausgabe[region];
		$_SESSION['mysql_email'] = $ausgabe[email];
		$_SESSION['mysql_email_zusage'] = $ausgabe[email_zusage];
		//Last login eintragen:
		$sql = sprintf("UPDATE schule SET last_login = '%s' WHERE (id = '%s')",
			mysql_real_escape_string(time()),
			mysql_real_escape_string($_SESSION['mysql_id']));
		$res = mysql_db_query( "hsgym-ep", $sql );
		//
		$rubrik = 1;
		//
		$_SESSION['login_path'] = 3;
		//
		//session_start();
		//session_regenerate_id();   
		$_SESSION['last_visit'] = time();
		//Cookie setzen falls gewünscht:
		if ( isset($_POST['login_speichern_schule'])) {
			setcookie('email_schule', $_POST['email_schule'], time() + (3600 * 24 * 365 * 5));
			setcookie('passwort_schule', $_POST['passwort_schule'], time() + (3600 * 24 * 365 * 5));
			//ACHTUNG: Ebenfalls das Cookie des anderen login-bereichs löschen, damit nicht 2 logins gleichzeitig gespeichert:
			setcookie('email_experte',"",time() - 3600);
			setcookie('passwort_experte', "", time() - 3600);
			$_POST['email_experte'] = "";
			$_POST['passwort_experte'] = "";
		}
		//Cookie löschen falls gewünscht:
		if (!isset($_POST['login_speichern_schule'])) {
			setcookie('email_schule',"",time() - 3600);
			setcookie('passwort_schule', "", time() - 3600);
			$_POST['email_experte'] = "";
			$_POST['passwort_experte'] = "";
		}
		} else {
			$_SESSION['login_path'] = 0;
			$login_error = 20;
			$_POST['email_schule'] = "";
			$_POST['passwort_schule'] = "";
		}
		//
	} else {
		$_SESSION['login_path'] = 0;
		$login_error = 2;
		$_POST['email_schule'] = "";
		$_POST['passwort_schule'] = "";
	}
?>
