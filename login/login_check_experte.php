<?php
	include ("mysql_connect.php");
	//
	$sql = sprintf("SELECT * FROM experte WHERE (email = '%s' AND passwort = '%s')",
		mysql_real_escape_string($_POST['email_experte']),
		mysql_real_escape_string(md5($_POST['passwort_experte'])));
		$res = mysql_db_query( "hsgym-ep", $sql );
	
	$num_rows = mysql_num_rows($res); 
	if ($num_rows > 0) {
		//Ok, jetzt userdaten der datenbank auswerten:
		$ausgabe = mysql_fetch_array ($res);
		if($ausgabe[aktivierungs_link] == -1){
		$_SESSION['mysql_id'] = $ausgabe[id];
		$_SESSION['mysql_name'] = $ausgabe[name];
		$_SESSION['mysql_titel'] = $ausgabe[titel];
		$_SESSION['mysql_institut'] = $ausgabe[institut];
		$_SESSION['mysql_adresse'] = $ausgabe[adresse];
		$_SESSION['mysql_email'] = $ausgabe[email];
		$_SESSION['mysql_region_art'] = $ausgabe[region_art];
		$_SESSION['mysql_region'] = $ausgabe[region];
		$_SESSION['mysql_zeitplan_art'] = 0;//$ausgabe[zeitplan_art];
		$_SESSION['mysql_zeitplan'] = $ausgabe[zeitplan];
		$_SESSION['mysql_fach_art'] = 0;//$ausgabe[fach_art];
		$_SESSION['mysql_fach'] = $ausgabe[fach];
		//
		//Last login eintragen:
		$sql = sprintf("UPDATE experte SET last_login = '%s' WHERE (id = '%s')",
			mysql_real_escape_string(time()),
			mysql_real_escape_string($_SESSION['mysql_id']));
		$res = mysql_db_query( "hsgym-ep", $sql );
		//
		$rubrik = 1;
		//
		$_SESSION['login_path'] = 4;
		//
		//session_start();
		//session_regenerate_id();   
		$_SESSION['last_visit'] = time();
		//Cookie setzen falls gewünscht:
		if ( isset($_POST['login_speichern_experte'])) {
			setcookie('email_experte', $_POST['email_experte'], time() + (3600 * 24 * 365 * 5));
			setcookie('passwort_experte', $_POST['passwort_experte'], time() + (3600 * 24 * 365 * 5));
			//ACHTUNG: Ebenfalls das Cookie des anderen login-bereichs löschen, damit nicht 2 logins gleichzeitig gespeichert:
			setcookie('email_schule',"",time() - 3600);
			setcookie('passwort_schule',"",time() - 3600);
		}
		//Cookie löschen falls gewünscht:
		if (!isset($_POST['login_speichern_experte'])) {
			setcookie('email_experte',"",time() - 3600);
			setcookie('passwort_experte',"",time() - 3600);
		}
		} else {
			$_SESSION['login_path'] = 0;
			$login_error = 21;
			$_POST['email_experte'] = "";
			$_POST['passwort_experte'] = "";
		}
		//
	} else {
		$_SESSION['login_path'] = 0;
		$login_error = 3;
		$_POST['email_experte'] = "";
		$_POST['passwort_experte'] = "";
	}
?>
