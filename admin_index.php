<?php
	session_start();
	//
	include("./functions/get_fach_entries.php");
	include("./functions/get_region_entries.php");
	include("./functions/get_experte_entries.php");
	
	//
	if (isset($_SESSION['last_visit'])) {
		$laufzeit = time()-$_SESSION['last_visit'];
		if ($laufzeit > 3600) {
			//unset($_SESSION['last_visit']);
			session_destroy();
			header('Location: ./admin.php');
		}
	}
	//
	if (!isset($_SESSION['last_visit'])) {
		session_destroy();
		header('Location: ./admin.php');
	}
	if ($_SESSION['login_path'] != 1) {
		session_destroy();
		header('Location: ./admin.php');
	}
	//
	//Wenn korrekt eingeloggt:
	if ($_SESSION['login_path'] == 1) {
		include("./functions/get_einstellungen.php");
	}
	//
	//Rubrik Variable
	if(!isset($_GET['rubrik'])){
		$rubrik = 1;
	}
	if(isset($_GET['rubrik'])){
		$rubrik = $_GET['rubrik'];
	}
	//Sort Variable
	if(!isset($_GET['sort'])){
		$sort = 0;
	}
	if(isset($_GET['sort'])){
		$sort = $_GET['sort'];
	}
	//
	//Einstellungen:
	if ($_POST["form_aktiv"] == 1) {
		include("./admin/admin_rubrik0_allgemein.php");
	}
	if ($_POST["form_aktiv"] == 2) {
		include("./admin/admin_rubrik0_reset.php");
	}
	if ($_POST["form_aktiv"] == 3) {
		include("./admin/admin_rubrik0_kantone_speichern.php");
	}
	if ($_POST["form_aktiv"] == 4) {
		include("./admin/admin_rubrik0_fach_neu.php");
		//header('Location: #anchor_fach');
	}
	if ($_POST["form_aktiv"] == 5) {
		include("./admin/admin_rubrik0_fach_loeschen.php");
	}
	//
	//Mails verschicken:
	if ($_POST["form__mail_verschicken"]) {
		//
		//
		include ("mysql_connect.php");
		include("./functions/get_schule_emails.php");
		include("./functions/get_experte_emails.php");
		//
		//Schule, nur mail abspeichern
		if($_POST["form__mail_verschicken"] == 1){
			$sql = sprintf("UPDATE einstellungen SET betreff_schulen = '%s', nachricht_schulen = '%s' WHERE (id = '1')",
				mysql_real_escape_string($_POST["schule_mail_betreff"]),
				mysql_real_escape_string($_POST["schule_mail_nachricht"]));
			$res = mysql_db_query( "hsgym-ep", $sql );
			$_SESSION['info_zeile'] = "Nachricht und Betreff wurden abgespeichert!";
			include("./functions/get_einstellungen.php");
		}
		//Schule,mail abspeichern UND abschicken
		if($_POST["form__mail_verschicken"] == 2){
			$sql = sprintf("UPDATE einstellungen SET betreff_schulen = '%s', nachricht_schulen = '%s' WHERE (id = '1')",
				mysql_real_escape_string($_POST["schule_mail_betreff"]),
				mysql_real_escape_string($_POST["schule_mail_nachricht"]));
			$res = mysql_db_query( "hsgym-ep", $sql );
			//
		$arbeit = count($alle_schule_emails)-1;
		while ( $arbeit>=0){
			$mailHeader = "MIME-Version: 1.0"."\r\n";
			$mailHeader .= "Content-type: text/plain; charset=iso-8859-1"."\r\n";
			$mailHeader = "To: ";
			$to = "";

			for ($i = 0; $i < 1; $i++) {

				$mailHeader .= "<".$alle_schule_emails[$arbeit].">";
				$to .= $alle_schule_emails[$arbeit];

			}
			$mailHeader .= "\r\n";
			$mailHeader .= "From: hsgym-expertenpool.ch <info@hsgym-expertenpool.ch>\r\n";
			
			$mailSubject = $_POST["schule_mail_betreff"];
			$mailBody = $_POST["schule_mail_nachricht"];
			
			$mailBody .= "\n\nDirekt-Login (Anfragen/Zusagen): http://www.hsgym-expertenpool.ch/?v0=direct_login&v1=schule&v2=".$alle_schule_emails[$arbeit]."&v3=".$alle_schule_passworts[$arbeit]."&v4=0";
			$mailBody .= "\n\nDirekt-Login (Profil): http://www.hsgym-expertenpool.ch/?v0=direct_login&v1=schule&v2=".$alle_schule_emails[$arbeit]."&v3=".$alle_schule_passworts[$arbeit]."&v4=1";
			
			
			mail($to, utf8_decode($mailSubject), utf8_decode($mailBody), $mailHeader);
			
			$arbeit -= 1;
		}
			//
			$_SESSION['info_zeile'] = "Nachricht und Betreff wurden abgespeichert! Mail wurde an alle Schulen versandt!";
			include("./functions/get_einstellungen.php");
		}
		//Experte, nur mail abspeichern
		if($_POST["form__mail_verschicken"] == 3){
			$sql = sprintf("UPDATE einstellungen SET betreff_experten = '%s', nachricht_experten = '%s' WHERE (id = '1')",
				mysql_real_escape_string($_POST["experte_mail_betreff"]),
				mysql_real_escape_string($_POST["experte_mail_nachricht"]));
			$res = mysql_db_query( "hsgym-ep", $sql );
			$_SESSION['info_zeile'] = "Nachricht und Betreff wurden abgespeichert!";
			include("./functions/get_einstellungen.php");
		}
		//Experte,mail abspeichern UND abschicken
		if($_POST["form__mail_verschicken"] == 4){
			$sql = sprintf("UPDATE einstellungen SET betreff_experten = '%s', nachricht_experten = '%s' WHERE (id = '1')",
				mysql_real_escape_string($_POST["experte_mail_betreff"]),
				mysql_real_escape_string($_POST["experte_mail_nachricht"]));
			$res = mysql_db_query( "hsgym-ep", $sql );

		$arbeit2 = count($alle_experte_emails)-1;
		while ( $arbeit2>=0){
			$mailHeader = "MIME-Version: 1.0"."\r\n";
			$mailHeader .= "Content-type: text/plain; charset=iso-8859-1"."\r\n";
			$mailHeader .= "To: ";
			$to = "";
			for ($i = 0; $i < 1; $i++) {

				$mailHeader .= "<".$alle_experte_emails[$arbeit2].">";
				$to .= $alle_experte_emails[$arbeit2];

			}
			$mailHeader .= "\r\n";
			$mailHeader .= "From: hsgym-expertenpool.ch <info@hsgym-expertenpool.ch>\r\n";
			

			$mailSubject = $_POST["experte_mail_betreff"];
			$mailBody = $_POST["experte_mail_nachricht"];
			
			$mailBody .= "\n\nDirekt-Login (Anfragen): http://www.hsgym-expertenpool.ch/?v0=direct_login&v1=experte&v2=".$alle_experte_emails[$arbeit2]."&v3=".$alle_experte_passworts[$arbeit2]."&v4=0";
			$mailBody .= "\n\nDirekt-Login (Profil): http://www.hsgym-expertenpool.ch/?v0=direct_login&v1=experte&v2=".$alle_experte_emails[$arbeit2]."&v3=".$alle_experte_passworts[$arbeit2]."&v4=1";
			

			mail($to, utf8_decode($mailSubject), utf8_decode($mailBody), $mailHeader);
		
			$arbeit2 -= 1;
		}
			//
			$_SESSION['info_zeile'] = "Nachricht und Betreff wurden abgespeichert! Mail wurde an alle Experten versandt!";
			include("./functions/get_einstellungen.php");
		}
	}
	
	//Experte und Schule löschen:
	if ($_POST["form_anfrage_aktiv"] == 3) {
		//
		include ("mysql_connect.php");
		//
		$sql = sprintf("DELETE FROM schule WHERE( id = '%s') LIMIT 1",
		mysql_real_escape_string($_POST["papierkorb_geklickt"]));
		//
		$res = mysql_db_query( "hsgym-ep", $sql );
		//
		$_SESSION['info_zeile'] = "Die Schule wurde gelöscht!";
		//
	}
	//
	if ($_POST["form_anfrage_aktiv"] == 4) {
		//
		include ("mysql_connect.php");
		//
		$sql = sprintf("DELETE FROM experte WHERE( id = '%s') LIMIT 1",
		mysql_real_escape_string($_POST["papierkorb_geklickt"]));
		//
		$res = mysql_db_query( "hsgym-ep", $sql );
		//
		$_SESSION['info_zeile'] = "Der Experte / die Expertin wurde gelöscht!";
		//
	}
	//
	if ($_POST["form_anfrage_aktiv"] == 5) {
		//
		/*include ("mysql_connect.php");
		//
		$sql = sprintf("DELETE FROM anfrage WHERE( id = '%s') LIMIT 1",
		mysql_real_escape_string($_POST["papierkorb_geklickt"]));
		//
		$res = mysql_db_query( "hsgym-ep", $sql );
		//
		$_SESSION['info_zeile'] = "Die Anfrage wurde gelöscht!";
		//*/
		//echo $_POST["papierkorb_geklickt"].", ";
		include("./schule/schule_anfrage_loeschen.php");
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
		<script type="text/javascript" src="experte/functions.js"></script>
	</head>
	<body >

	<div align="center">
	<?php include("header/header_admin.php");?>
	
	<?php include("navigation/navigation_admin.php");?>
	
	<div id="schatten" >
	<?php 
		include("info_zeile.php"); 
	?>
	
	<div id="content_carrier">
	<?php 
		include("admin/admin_rubrik".$rubrik.".php");
	?>
	</div>
	
	</div>
	
	<?php include("footer.php"); ?>
	
	</div>
	
	</body>
</html>

