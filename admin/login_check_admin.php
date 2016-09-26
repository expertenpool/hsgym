<?php
	include ("mysql_connect.php");
	//
	$sql = sprintf("SELECT * FROM admin WHERE (email = '%s' AND passwort = '%s')",
		mysql_real_escape_string($_POST['email_admin']),
		mysql_real_escape_string(md5($_POST['passwort_admin'])));
	$res = mysql_db_query( "hsgym-ep", $sql );
	
	$num_rows = mysql_num_rows($res); 
	if ($num_rows > 0) {
		//Ok, jetzt userdaten der datenbank auswerten:
		$ausgabe = mysql_fetch_array ($res);
		$_SESSION['mysql_id'] = $ausgabe[id];
		$_SESSION['mysql_name'] = $ausgabe[name];
		$_SESSION['mysql_email'] = $ausgabe[email];
		$rubrik = 1;
		//
		$_SESSION['login_path'] = 1;
		//
		//session_start();
		//session_regenerate_id();   
		$_SESSION['last_visit'] = time();
		//Cookie setzen falls gewünscht:
		if ( isset($_POST['login_speichern_admin'])) {
			setcookie('email_admin', $_POST['email_admin'], time() + (3600 * 24 * 365 * 5));
			setcookie('passwort_admin', $_POST['passwort_admin'], time() + (3600 * 24 * 365 * 5));
		}
		//Cookie löschen falls gewünscht:
		if (!isset($_POST['login_speichern_admin'])) {
			setcookie('email_admin',"",time() - 3600);
			setcookie('passwort_admin',"",time() - 3600);
		}
		//
	} else {
		$_SESSION['login_path'] = 0;
		$login_error = 2;
		$_POST['email_admin'] = "";
		$_POST['passwort_admin'] = "";
	}
?>
