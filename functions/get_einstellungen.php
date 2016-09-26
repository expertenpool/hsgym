<?php
	include ("mysql_connect.php");
	// 
		$sql = "SELECT * FROM einstellungen";
		$res = mysql_db_query( "hsgym-ep", $sql );
		while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
			$_SESSION['mysql_general_passwort'] = $row[general_passwort]; 
			$_SESSION['mysql_anzahl_zusagen'] = $row[anzahl_zusagen]; 
			$_SESSION['mysql_schule_mail_betreff'] = $row[betreff_schulen]; 
			$_SESSION['mysql_schule_mail_nachricht'] = $row[nachricht_schulen]; 
			$_SESSION['mysql_experte_mail_betreff'] = $row[betreff_experten]; 
			$_SESSION['mysql_experte_mail_nachricht'] = $row[nachricht_experten]; 
			$_SESSION['mysql_zugang_sperren'] = $row[zugang_sperren]; 
			$_SESSION['mysql_begutachtung_zeitraum'] = $row[begutachtung_zeitraum]; 
		}
?>