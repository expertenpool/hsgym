<?php
	include("./functions/get_einstellungen.php");
	//echo $_POST['passwort_allgemein']." ".;
	if ($_POST['passwort_allgemein'] == $_SESSION['mysql_general_passwort']) {
		//
		if($_POST['profil_typ'] == "schule"){
			$_SESSION['login_path'] = 1;
		}
		if($_POST['profil_typ'] == "experte"){
			$_SESSION['login_path'] = 2;
		}
		//
		//session_start();
		//session_regenerate_id();   
		$_SESSION['last_visit'] = time();
	} else {
		$_SESSION['login_path'] = 0;
		$login_error = 1;
	}
?>
