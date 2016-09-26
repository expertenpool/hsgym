<?php
include("./functions/get_einstellungen.php");
if($_SESSION['mysql_anzahl_zusagen'] == 0) {
	$_SESSION['mysql_anzahl_zusagen'] = 100000;
}

	//Nochmal ganzes Tabellen-Array reinladen:
		include ("mysql_connect.php");
	//
	//$sql = sprintf("SELECT * FROM anfrage WHERE (schule_id = '%s')",mysql_real_escape_string($_SESSION['mysql_id']));
	$sql = sprintf("SELECT schule.id AS schule_id, schule.name, schule.email, anfrage.fach_id, anfrage.art, anfrage.termin, anfrage.korrektur, anfrage.id FROM anfrage,schule WHERE anfrage.schule_id = schule.id");
	$res = mysql_db_query( "hsgym-ep", $sql );
	
	$sql_absage = sprintf("SELECT * FROM absage WHERE experte_id = '%s'", 
		mysql_real_escape_string($_SESSION['mysql_id']));
	$res_absage = mysql_db_query( "hsgym-ep", $sql_absage );
	$absage_ID = array();
	while ($row_absage = mysql_fetch_array($res_absage, MYSQL_ASSOC)) {
		$absage_ID[$row_absage[anfrage_id]] = 1;
		//echo $row_absage[anfrage_id]."--->".$abssage_ID[$row_absage[anfrage_id]].",  ";
	}
	//$tabellen_zeilen_anzahl = mysql_num_rows($res); 
	$tabellen_zeilen_DATA = array();
	//
	$art_ID = array("schriftlich und mündlich","schriftlich", "mündlich");
	while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
		$fach_ist_drin = 0;
		$temp_fach = explode(";", $_SESSION['mysql_fach']);
		for ($i = 1; $i < count($temp_fach) - 1; $i++) {
			if($row[fach_id] == $temp_fach[$i]){
				$fach_ist_drin = 1;
			}
		}
		if ($fach_ist_drin == 1) {
		// Jetzt noch testen ob bereits absagen gegeben:
			if($absage_ID[$row[id]] != 1){
				array_push($tabellen_zeilen_DATA, array($row[name], $row[email], $fach_DATA_ID[$row[fach_id]], $art_ID[$row[art]], $row[termin], $row[korrektur], $row[id], $row[schule_id]));  
			}
		}
		
	}
	//
	//$tabellen_zeilen_anzahl = count($tabellen_zeilen_DATA);
	//
	include ("mysql_connect.php");
	//
	//
	//if (isset($_POST['email_versand_schule'])) {
		//echo "HALO: ".$_POST['email_versand_schule'];
	//}
	
	$temp = explode("-", $_POST["image_geklickt"]);
	//
	//
	//echo 'skata_'.$temp[0]."--->";
	for ($i2 = 0; $i2 <count($_POST['skata_'.$temp[0]]); $i2++) { 
		//echo $_POST['skata_'.$temp[0]][$i2];
		//$zeitplan_string[$_POST['zeitplan_werte'][$i2]] = "1";
	}
	//Infozeile betreffend Zusage/Absage.
	$betrifft_schule_ID = "";
	$betrifft_schule_email = "";
	$betrifft_schule = "";
	$betrifft_fach = "";
	$betrifft_art = "";
	$betrifft_termin = "";
	$betrifft_korrektur = "";
	for ($i = 0; $i < count($tabellen_zeilen_DATA); $i++) {
		if ($tabellen_zeilen_DATA[$i][6] == $temp[0]) {
			$betrifft_schule = $tabellen_zeilen_DATA[$i][0];
			$betrifft_schule_email = $tabellen_zeilen_DATA[$i][1];
			$betrifft_fach = $tabellen_zeilen_DATA[$i][2];
			$betrifft_art = $tabellen_zeilen_DATA[$i][3];
			$betrifft_termin = $tabellen_zeilen_DATA[$i][4];
			$betrifft_korrektur = $tabellen_zeilen_DATA[$i][5];
			$betrifft_schule_ID = $tabellen_zeilen_DATA[$i][7];
		}
	}
	// 
	//
	//Anzahl Zusagen die eine Schule schon hat:
	$sql_anzahl_zusagen_schule = "SELECT anfrage.schule_id FROM anfrage,zusage WHERE ( anfrage.id = zusage.anfrage_id)";
	$res_anzahl_zusagen_schule = mysql_db_query( "hsgym-ep", $sql_anzahl_zusagen_schule );
	$anzahl_zusagen_schule_ID = array();
	while ($row_anzahl_zusagen_schule = mysql_fetch_array($res_anzahl_zusagen_schule, MYSQL_ASSOC)) {
		$anzahl_zusagen_schule_ID[$row_anzahl_zusagen_schule[schule_id]] += 1;
		//echo $row_anzahl_zusagen_schule[schule_id].",  ";
	}
	//echo "--->".$betrifft_schule_ID."  ".$anzahl_zusagen_schule_ID[$betrifft_schule_ID];
	//
	$im_system_vorhanden = 1;
	//
	// Check ob Zusage schon jemand gemacht hat, oder man selbst schon gemacht hat:
	if($temp[1] == 1){
		$sql_zusage_schon_da = sprintf("SELECT * FROM zusage WHERE ( anfrage_id = '%s')", 
		mysql_real_escape_string($temp[0]));
		$res_zusage_schon_da = mysql_db_query( "hsgym-ep", $sql_zusage_schon_da );
		$num_rows = mysql_num_rows($res_zusage_schon_da); 
		//echo "num_rows: ".$num_rows;
		if ($num_rows > 0) {
			$im_system_vorhanden = 0;
		}
	}
	if ($anzahl_zusagen_schule_ID[$betrifft_schule_ID] >= $_SESSION['mysql_anzahl_zusagen']) {
		$im_system_vorhanden = 0;
	}
	if($im_system_vorhanden == 0){
		$_SESSION['info_zeile'] = "<font color=#FF0000>Diese Anfrage ist mittlerweile im System nicht mehr vorhanden.</font>";
	}
	//
	if ($im_system_vorhanden == 1) {
	
	if($temp[1] == 2){
		$_SESSION['info_zeile'] = "Absage von ".$betrifft_fach.", ".$betrifft_art.", ".$betrifft_schule;
		//
		$sql = sprintf("INSERT INTO absage VALUES (NULL, '%s', '%s')",
		mysql_real_escape_string($temp[0]),
		mysql_real_escape_string($_SESSION['mysql_id']));
		$res = mysql_db_query( "hsgym-ep", $sql );
	}
	//echo $betrifft_art;
	/*if ($betrifft_art == "schriftlich") {
		echo "kjh";
	}*/
	if ($temp[1] == 1 && count($_POST['skata_'.$temp[0]]) == 0 && $betrifft_art != "schriftlich") {
		$_SESSION['info_zeile'] = "Zusage nur möglich wenn mindestens ein möglicher Termin für die mündliche Prüfung gewählt wurde.";
	}
	if (($temp[1] == 1 && count($_POST['skata_'.$temp[0]])>=1) || ($temp[1] == 1 && $betrifft_art == "schriftlich")) {
		/*for ($i2 = 0; $i2 <count($_POST['skata']); $i2++) { 
			echo $_POST['skata'][$i2].",";
			//$zeitplan_string[$_POST['zeitplan_werte'][$i2]] = "1";
		}*/
		//if ($tabellen_zeilen_DATA[$i][6] == $temp[0]) {
		//}
		
		$_SESSION['info_zeile'] = "Zusage von ".$betrifft_fach.", ".$betrifft_art.", ".$betrifft_schule;
		//
		$strungla = "";
		for ($i2 = 0; $i2 < 100; $i2++) { 
			$strungla .= "0";
		}
		for ($i2 = 0; $i2 < count($_POST['skata_'.$temp[0]]); $i2++) { 
			$strungla[$_POST['skata_'.$temp[0]][$i2]] = "1";
		}
		$sql = sprintf("INSERT INTO zusage VALUES (NULL, '%s', '%s', '%s')",
		mysql_real_escape_string($temp[0]),
		mysql_real_escape_string($_SESSION['mysql_id']),
		mysql_real_escape_string($strungla));
		$res = mysql_db_query( "hsgym-ep", $sql );
		//
		//Will schule email haben?
		$email_verschicken = 0;
		$sql_email = sprintf("SELECT * FROM schule WHERE id = '%s'", mysql_real_escape_string($betrifft_schule_ID));
		$res_email = mysql_db_query( "hsgym-ep", $sql_email );
		while ($row_email = mysql_fetch_array($res_email, MYSQL_ASSOC)) {
			//echo "email:".$row_email[email_zusage];
			$email_verschicken = $row_email[email_zusage];
			$schule_passwort = $row_email[passwort];
		}
		//
		if($email_verschicken == 1){
			//
			$mailTo = $betrifft_schule_email;
			$mailFrom = "From: hsgym-expertenpool.ch <info@hsgym-expertenpool.ch>";
			$mailSubject = "neue Zusage erhalten - HSGYM Expertenpool ";
			$mailBody = "Guten Tag \n\nSie haben auf der Expertenpool Plattform eine neue Zusage erhalten.\n";
			$mailBody .= "Die Zusage gilt erst dann als definitiv, wenn Sie diese per Mail bestätigen.\n";
			$mailBody .= "Die Mailadresse der Expertin/des Experten lautet: ".$_SESSION['mysql_email'];
			$mailBody .= "\n\n";
			$mailBody .= "Prüfungsfach: ".$betrifft_fach;
			$mailBody .= "\nArt der Prüfung: ".$betrifft_art;
			if ($betrifft_art == "mündlich" || $betrifft_art == "schriftlich und mündlich") {
				/*$tempo = explode(";", $betrifft_termin);
				if($tempo[0]){
					if ($tempo[3] < 10) { $tempo[3] = "0".$tempo[3]; }
					if ($tempo[4] < 10) { $tempo[4] = "0".$tempo[4]; }
					if ($tempo[8] < 10) { $tempo[8] = "0".$tempo[8]; }
					if ($tempo[9] < 10) { $tempo[9] = "0".$tempo[9]; }
					$mailBody .= "\n\nTermin mündlich:\nVon: ".$tempo[0].".".$tempo[1]." ".$tempo[2].", ".$tempo[3].":".$tempo[4]; 
					$mailBody .= "\nBis: ".$tempo[5].".".$tempo[6]." ".$tempo[7].", ".$tempo[8].":".$tempo[9]; 
				}*/
				$mailBody .= "\nAngekreuzte mündliche Termine:";
				$anz_dat = explode("---123MARGARIS321---", $betrifft_termin);
					for($dieses = 0;$dieses<count($anz_dat)-1;$dieses++){
						$tempo = explode(";", $anz_dat[$dieses]);
						if($tempo[0]){
						if ($tempo[3] < 10) { $tempo[3] = "0".$tempo[3]; }
						if ($tempo[4] < 10) { $tempo[4] = "0".$tempo[4]; }
						if ($tempo[5] < 10) { $tempo[5] = "0".$tempo[5]; }
						if ($tempo[6] < 10) { $tempo[6] = "0".$tempo[6]; }
						//$ro = "   ";
						if ($strungla[$dieses] == "1") {
							$mailBody .= "\n".intval($dieses + 1).").  ".$tempo[0].".".$tempo[1]." ".$tempo[2].",   ".$tempo[3].":".$tempo[4]." - ".$tempo[5].":".$tempo[6]; 
						}
					}
				}
			}
			if ($betrifft_art == "schriftlich" || $betrifft_art == "schriftlich und mündlich") {
				$tempo = explode(";", $betrifft_korrektur);
				if($tempo[0]){
					$mailBody .= "\n\nKontrollzeitraum:\nVon: ".$tempo[0].".".$tempo[1]." ".$tempo[2]; 
					$mailBody .= "\nBis: ".$tempo[3].".".$tempo[4]." ".$tempo[5]; 
				}
			}
			$mailBody .= "\n\nDirekt-Login (Anfragen/Zusagen): http://www.hsgym-expertenpool.ch/?v0=direct_login&v1=schule&v2=".$mailTo."&v3=".$schule_passwort."&v4=0";
			$mailBody .= "\n\nDirekt-Login (Profil): http://www.hsgym-expertenpool.ch/?v0=direct_login&v1=schule&v2=".$mailTo."&v3=".$schule_passwort."&v4=1";
			
			//echo $mailBody;
            mail($mailTo, utf8_decode($mailSubject), utf8_decode($mailBody), $mailFrom);
			//
		}
	}
	
	}
	//

	
	//
?>