<?php

include("./functions/get_einstellungen.php");
if($_SESSION['mysql_anzahl_zusagen'] == 0) {
	$_SESSION['mysql_anzahl_zusagen'] = 100000;
}
	date_default_timezone_set("Europe/Zurich");
	
	$tabellen_spalten_namen = array("Name der Schule", "Prüfungsfach", "Typ","Termine", "Aktion");
	$tabellen_spalten_breite = array(140, 90, 90, 360, 220);
	$tabellen_spalten_anzahl = count($tabellen_spalten_namen);
	include ("mysql_connect.php");
	//
	//Anzahl Zusagen die eine Schule schon hat:
	$sql_anzahl_zusagen_schule = "SELECT anfrage.schule_id FROM anfrage,zusage WHERE ( anfrage.id = zusage.anfrage_id)";
	$res_anzahl_zusagen_schule = mysql_db_query( "hsgym-ep", $sql_anzahl_zusagen_schule );
	$anzahl_zusagen_schule_ID = array();
	while ($row_anzahl_zusagen_schule = mysql_fetch_array($res_anzahl_zusagen_schule, MYSQL_ASSOC)) {
		$anzahl_zusagen_schule_ID[$row_anzahl_zusagen_schule[schule_id]] += 1;
		//echo $row_anzahl_zusagen_schule[schule_id].",  ";
	}
	//echo "k:".$anzahl_zusagen_schule_ID[23];
	//
	
	//
	//Alle Anfragen einholen die sichtbarkeit 0 haben oder sichtbarkeit = experte_ID
	$sql = sprintf("SELECT schule.id AS schule_id, schule.name, schule.email, schule.region, anfrage.fach_id, anfrage.art, anfrage.termin, anfrage.korrektur, anfrage.id, anfrage.klassen_kuerzel FROM anfrage,schule WHERE ( anfrage.schule_id = schule.id AND (anfrage.sichtbarkeit = 0 OR anfrage.sichtbarkeit = '%s'))",
		mysql_real_escape_string($_SESSION['mysql_id']));
	$res = mysql_db_query( "hsgym-ep", $sql );
	
	//ABSAGE-Daten:
	$sql_absage = sprintf("SELECT * FROM absage WHERE experte_id = '%s'", 
		mysql_real_escape_string($_SESSION['mysql_id']));
	$res_absage = mysql_db_query( "hsgym-ep", $sql_absage );
	//im Array $absage_ID wird für jeden index eine 1 gesetzt falls die zahl des index bereits als absage-id vorkommt.
	// z.B. $absage_ID[8] = 1 heisst, dass für diesen User bereits eine absage der anfrage(8) abgegeben wurde.
	$absage_ID = array();
	while ($row_absage = mysql_fetch_array($res_absage, MYSQL_ASSOC)) {
		$absage_ID[$row_absage[anfrage_id]] = 1;
		//echo $row_absage[anfrage_id]."--->".$absage_ID[$row_absage[anfrage_id]].",  ";
	}
	//Erweiterte Absage falls jemand anders abgeholt:
	$sql_absage = sprintf("SELECT * FROM zusage WHERE experte_id != '%s'", 
		mysql_real_escape_string($_SESSION['mysql_id']));
	$res_absage = mysql_db_query( "hsgym-ep", $sql_absage );
	while ($row_absage = mysql_fetch_array($res_absage, MYSQL_ASSOC)) {
		$absage_ID[$row_absage[anfrage_id]] = 1;
		//echo $row_absage[anfrage_id]."--->".$absage_ID[$row_absage[anfrage_id]].",  ";
	}
	
	//ZUSAGE-Daten:
	$sql_zusage = sprintf("SELECT * FROM zusage WHERE experte_id = '%s'", 
		mysql_real_escape_string($_SESSION['mysql_id']));
	$res_zusage = mysql_db_query( "hsgym-ep", $sql_zusage );
	$zusage_ID = array();
	$zusage_ID_DETAIL = array();
	while ($row_zusage = mysql_fetch_array($res_zusage, MYSQL_ASSOC)) {
		$zusage_ID[$row_zusage[anfrage_id]] = 1;
		$zusage_ID_DETAIL[$row_zusage[anfrage_id]] = $row_zusage[detail];
		//echo $row_zusage[anfrage_id]."   ".$row_zusage[detail];
		//echo $row_zusage[anfrage_id]."--->".$zusage_ID[$row_zusage[anfrage_id]].",  ";
	}
	
	//$tabellen_zeilen_anzahl = mysql_num_rows($res); 
	$tabellen_zeilen_DATA = array();
	//
			$monat_andersrum["Jan"] = 1;
		$monat_andersrum["Feb"] = 2;
		$monat_andersrum["Mar"] = 3;
		$monat_andersrum["Apr"] = 4;
		$monat_andersrum["Mai"] = 5;
		$monat_andersrum["Jun"] = 6;
		$monat_andersrum["Jul"] = 7;
		$monat_andersrum["Aug"] = 8;
		$monat_andersrum["Sep"] = 9;
		$monat_andersrum["Okt"] = 10;
		$monat_andersrum["Nov"] = 11;
		$monat_andersrum["Dez"] = 12;
		//
	$art_ID = array("schriftlich und mündlich","schriftlich", "mündlich");
	while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
		//
		
		//echo $row[id].", ";

		
		$temp_zeit = explode(";", $row[termin]);
		if ($row[art] != 1) {
		
		//Achtung hier für neue Version als allgemeinegültig gesetzt:
		$zeitlich_passend = 1;
		//Hier der zeit-test abgestellt für die neue version:
		/*
		$temp_zeit_von = mktime($temp_zeit[3], $temp_zeit[4], 0, $monat_andersrum[$temp_zeit[1]], $temp_zeit[0], $temp_zeit[2]);
		$temp_zeit_bis = mktime($temp_zeit[8], $temp_zeit[9], 0, $monat_andersrum[$temp_zeit[6]], $temp_zeit[5], $temp_zeit[7]);
		//
		//echo date("w", $temp_zeit_von)." ".($temp_zeit[3]*100+$temp_zeit[4]).", ";
		//echo date("w", $temp_zeit_bis)." ".($temp_zeit[8] * 100 + $temp_zeit[9]).". ";
		//
		$basic_von = ((date("w", $temp_zeit_von) * 2) - 2);
		$basic_von_uhrzeit = ($temp_zeit[3]*100+$temp_zeit[4]);
		if ($basic_von_uhrzeit <= 1200) {
			//echo "vormittag";
		}
		if ($basic_von_uhrzeit > 1200) {
			$basic_von +=1;
		}
		//
		$basic_bis = ((date("w", $temp_zeit_bis) * 2) - 2);
		$basic_bis_uhrzeit = ($temp_zeit[8]*100+$temp_zeit[9]);
		if ($basic_bis_uhrzeit <= 1200) {
			//echo "vormittag";
		}
		if ($basic_bis_uhrzeit > 1200) {
			$basic_bis +=1;
		}
		//echo "XX   ".$basic_von.", ".$basic_bis.". ";
		$zeitlich_passend = 1;
		
		if ($_SESSION['mysql_zeitplan_art'] == 1) {
			for ($i = 0; $i <12; $i++) {
				//$_SESSION['mysql_zeitplan'] = $bereits_zugesagte_zeitplan;
				if ($bereits_zugesagte_zeitplan[$i] == 1) {
					$_SESSION['mysql_zeitplan'][$i] = 1;
				}
			}
			for ($i = $basic_von; $i <= $basic_bis; $i++) {
				//echo $_SESSION['mysql_zeitplan'][$i].",";
				if ($_SESSION['mysql_zeitplan'][$i] == 0) {
					$zeitlich_passend = 0;
				}
				//
				//if($bereits_zugesagte_zeitplan[$i] == 0
			}
		}*/
		}
		//echo $zeitlich_passend;
		//0 = sonntag, 6 = samstag usw...
		
		//$utc_von = mktime($_POST['termin_von_stunde_wahl'], $_POST['termin_von_minute_wahl'], 0, $monat_andersrum[$_POST['termin_von_monat_wahl']], $_POST['termin_von_tag_wahl'], $_POST['termin_von_jahr_wahl']);
		
		//$mydate = mktime($stunde, $minute, $sekunde, $monat, $tag, $jahr);
		//$weekday = date("w", $mydate);
	//Vorbereitung Zeitbereiche für Sortierung:
	//Hier der zeit-test abgestellt für die neue version:
	/*
		$temp_zeit = explode(";", $row[termin]);
		$temp_zeit2 = explode(";", $row[korrektur]);
		$temp_zeit_termin = 0;
		$temp_zeit_korrektur = 0;
		if($temp_zeit[0]){
			$temp_zeit_termin = mktime($temp_zeit[3], $temp_zeit[4], 0, $monat_andersrum[$temp_zeit[1]], $temp_zeit[0], $temp_zeit[2]);
		}
		if($temp_zeit2[0]){
			$temp_zeit_korrektur = mktime(0, 0, 0, $monat_andersrum[$temp_zeit2[1]], $temp_zeit2[0], $temp_zeit2[2]);
		}
		*/
		//
		$fach_ist_drin = 0;
		$temp_fach = explode(";", $_SESSION['mysql_fach']);
		for ($i = 1; $i < count($temp_fach) - 1; $i++) {
			if($row[fach_id] == $temp_fach[$i]){
				$fach_ist_drin = 1;
			}
		}
		//kantons-check:
		if ($fach_ist_drin == 1) {
			//falls nicht alle regionen ok:
			if ($_SESSION['mysql_region_art'] == 1) {
				//echo $_SESSION['mysql_region'];
				//echo $row[region]."   ------   ";
				$fach_ist_drin = 0;
				$temp_region = explode(";", $_SESSION['mysql_region']);
				for ($i = 1; $i < count($temp_region) - 1; $i++) {
					if($row[region] == $temp_region[$i]){
						$fach_ist_drin = 1;
					}
				}
				//zwangs-regionen:
				for ($i = 0; $i < count($bereits_zugesagte_region); $i++) {
					if($row[region] == $bereits_zugesagte_region[$i]){
						$fach_ist_drin = 1;
					}
				}
			}
		
		}
		//finale tests durchführen:
		$schule_noch_frei = 1;
		//hat schule bereits 8 zusagen, dann ausblenden:
		//echo $anzahl_zusagen_schule_ID[$row[schule_id]]." ".$row[schule_id]." ".$row[name]." (".$zusage_ID[$row[id]].") ,";
		if($anzahl_zusagen_schule_ID[$row[schule_id]]>=$_SESSION['mysql_anzahl_zusagen'] && !isset($zusage_ID[$row[id]])){
			$schule_noch_frei = 0;
		}
		
		
		/////////////////////////////
		//
		if ($fach_ist_drin == 1 && $zeitlich_passend == 1 && $schule_noch_frei == 1){// && $termin_cross == 1) {
			// Jetzt noch testen ob bereits absagen gegeben:
			if ($absage_ID[$row[id]] != 1) {
				//
				//sowieso alles nur wenn Zugang entsperrt:
				if ($_SESSION['mysql_zugang_sperren'] != 1) {
					//nur wenn prüfungsart entsprechend:
					//falls null, soll alles angezeigt werden:
					if ($_SESSION['mysql_fach_art'] == 0) {					
						array_push($tabellen_zeilen_DATA, array($row[name], $row[email], $fach_DATA_ID[$row[fach_id]], $art_ID[$row[art]], $row[termin], $row[korrektur], $row[id], $zusage_ID[$row[id]], $temp_zeit_termin, $temp_zeit_korrektur, $row[art], $zusage_ID_DETAIL[$row[id]], $row[klassen_kuerzel]));  
					}
					//falls nicht null, soll nur mündlich oder schriftlich angezeigt werden:
					if ($_SESSION['mysql_fach_art'] > 0) {
						if ($row[art] == $_SESSION['mysql_fach_art']) {
							array_push($tabellen_zeilen_DATA, array($row[name], $row[email], $fach_DATA_ID[$row[fach_id]], $art_ID[$row[art]], $row[termin], $row[korrektur], $row[id], $zusage_ID[$row[id]], $temp_zeit_termin, $temp_zeit_korrektur, $row[art], $zusage_ID_DETAIL[$row[id]], $row[klassen_kuerzel]));  
						}
					}
				}
				//
				//FALLS Zugang gesperrt nur wenn zusage-ID vorhanden :
				if ($_SESSION['mysql_zugang_sperren'] == 1) {
					if($zusage_ID[$row[id]]){
						//nur wenn prüfungsart entsprechend:
						//falls null, soll alles angezeigt werden:
						if ($_SESSION['mysql_fach_art'] == 0) {					
							array_push($tabellen_zeilen_DATA, array($row[name], $row[email], $fach_DATA_ID[$row[fach_id]], $art_ID[$row[art]], $row[termin], $row[korrektur], $row[id], $zusage_ID[$row[id]], $temp_zeit_termin, $temp_zeit_korrektur, $row[art], $zusage_ID_DETAIL[$row[id]], $row[klassen_kuerzel]));  
						}
						//falls nicht null, soll nur mündlich oder schriftlich angezeigt werden:
						if ($_SESSION['mysql_fach_art'] > 0) {
							if ($row[art] == $_SESSION['mysql_fach_art']) {
								array_push($tabellen_zeilen_DATA, array($row[name], $row[email], $fach_DATA_ID[$row[fach_id]], $art_ID[$row[art]], $row[termin], $row[korrektur], $row[id], $zusage_ID[$row[id]], $temp_zeit_termin, $temp_zeit_korrektur, $row[art], $zusage_ID_DETAIL[$row[id]], $row[klassen_kuerzel]));  
							}
						}
					}
				}
			}
		}
		
	}
	//Identifizieren von allen zugesagten mündlichen Zeiträumen:
	//HINWEIS: hier geht es wieder im wesentlichen um das bewerkstelligen der inaktivitäts-anzeige:
	$durchgehen_anzahl = count($tabellen_zeilen_DATA);
	$besetzte_zeiten = array();
	//Hier der zeit-test abgestellt für die neue version:
				/*
	for ($i = 0; $i < $durchgehen_anzahl; $i++) {
		if($tabellen_zeilen_DATA[$i][7]){
			echo $tabellen_zeilen_DATA[$i][4]."   ".$tabellen_zeilen_DATA[$i][7]."<br/> ";
			$temp_zeit = explode(";", $tabellen_zeilen_DATA[$i][4]);
			if ($temp_zeit[0]) {
				$tempo_von = mktime($temp_zeit[3], $temp_zeit[4], 0, $monat_andersrum[$temp_zeit[1]], $temp_zeit[0], $temp_zeit[2]);
				$tempo_bis = mktime($temp_zeit[8], $temp_zeit[9], 0, $monat_andersrum[$temp_zeit[6]], $temp_zeit[5], $temp_zeit[7]);

				//echo $tempo_von."<br/> ";
				//echo $tempo_bis."<br/> ";
				array_push($besetzte_zeiten,array($tempo_von,$tempo_bis));
			}
		}
	}
	//Jetzt alle nicht zugesagten Termine die mündlich sind, durchgehen und mit "Besetzte_Zeiten"-Array vergleichen:
	for ($i = 0; $i < $durchgehen_anzahl; $i++) {
		if (!$tabellen_zeilen_DATA[$i][7]) {
		//nur diese welche "mündlich" oder "schriftlich und mündlich" sind, dem test unterziehen:
			if($tabellen_zeilen_DATA[$i][10] != 1){
				//echo $tabellen_zeilen_DATA[$i][4]."   (".$tabellen_zeilen_DATA[$i][7].")   ".$tabellen_zeilen_DATA[$i][10]."<br/> ";
				//
				$temp_zeit = explode(";", $tabellen_zeilen_DATA[$i][4]);
				$tempo_von = mktime($temp_zeit[3], $temp_zeit[4], 0, $monat_andersrum[$temp_zeit[1]], $temp_zeit[0], $temp_zeit[2]);
				$tempo_bis = mktime($temp_zeit[8], $temp_zeit[9], 0, $monat_andersrum[$temp_zeit[6]], $temp_zeit[5], $temp_zeit[7]);
				//echo $tempo_von." ".$tempo_bis."<br/> ";
				//
				
				for ($i2 = 0; $i2 < count($besetzte_zeiten); $i2++) {
					$sollte_ok_sein = 0;
					//echo "            ----->".$besetzte_zeiten[$i2][0]." ".$besetzte_zeiten[$i2][1]."<br/>";
					if ($sollte_ok_sein == 0){
						if ($tempo_von < $besetzte_zeiten[$i2][0] && $tempo_bis < $besetzte_zeiten[$i2][0] ) {
							//echo "alles zuvor"."<br/>";
							$sollte_ok_sein = 1;
						}
					}
					if ($sollte_ok_sein == 0){
						if ($tempo_von > $besetzte_zeiten[$i2][1] && $tempo_bis > $besetzte_zeiten[$i2][1] ) {
							//echo "alles danach"."<br/>";
							$sollte_ok_sein = 1;
						}
					}
					if ($sollte_ok_sein != 1) {
						//echo "nicht gut<br/>";
						unset($tabellen_zeilen_DATA[$i]);
						break;
					}
				}
				
			}
			//echo "<br/>";
		}
	}*/
	
	//unset($tabellen_zeilen_DATA[0]);
	//
	$tabellen_zeilen_anzahl = count($tabellen_zeilen_DATA);
	//Sortieren:
	if($sort == 0){
		function aufwaerts1($wert_a, $wert_b) 
		{
		$a = $wert_a[0];
		$b = $wert_b[0];
  		if ($a == $b) {
			return 0;
		}
 		return ($a < $b) ? -1 : +1;
		}
		usort($tabellen_zeilen_DATA, 'aufwaerts1');
	}
	if($sort == 1){
		function abwaerts1($wert_a, $wert_b) 
		{
		$a = $wert_a[0];
		$b = $wert_b[0];
  		if ($a == $b) {
			return 0;
		}
 		return ($a > $b) ? -1 : +1;
		}
		usort($tabellen_zeilen_DATA, 'abwaerts1');
	}
	if($sort == 2){
		function aufwaerts2($wert_a, $wert_b) 
		{
		$a = $wert_a[2];
		$b = $wert_b[2];
  		if ($a == $b) {
			return 0;
		}
 		return ($a < $b) ? -1 : +1;
		}
		usort($tabellen_zeilen_DATA, 'aufwaerts2');
	}
	if($sort == 3){
		function abwaerts2($wert_a, $wert_b) 
		{
		$a = $wert_a[2];
		$b = $wert_b[2];
  		if ($a == $b) {
			return 0;
		}
 		return ($a > $b) ? -1 : +1;
		}
		usort($tabellen_zeilen_DATA, 'abwaerts2');
	}
	//Fach sortieren:
	if($sort == 4){
		function aufwaerts3($wert_a, $wert_b) 
		{
		$a = $wert_a[3];
		$b = $wert_b[3];
  		if ($a == $b) {
			return 0;
		}
 		return ($a < $b) ? -1 : +1;
		}
		usort($tabellen_zeilen_DATA, 'aufwaerts3');
	}
	if($sort == 5){
		function abwaerts3($wert_a, $wert_b) 
		{
		$a = $wert_a[3];
		$b = $wert_b[3];
  		if ($a == $b) {
			return 0;
		}
 		return ($a > $b) ? -1 : +1;
		}
		usort($tabellen_zeilen_DATA, 'abwaerts3');
	}
	/*if($sort == 6){
		function aufwaerts4($wert_a, $wert_b) 
		{
		$a = $wert_a[8];
		$b = $wert_b[8];
  		if ($a == $b) {
			return 0;
		}
 		return ($a < $b) ? -1 : +1;
		}
		usort($tabellen_zeilen_DATA, 'aufwaerts4');
	}
	if($sort == 7){
		function abwaerts4($wert_a, $wert_b) 
		{
		$a = $wert_a[8];
		$b = $wert_b[8];
  		if ($a == $b) {
			return 0;
		}
 		return ($a > $b) ? -1 : +1;
		}
		usort($tabellen_zeilen_DATA, 'abwaerts4');
	}*/
	if($sort == 8){
		function aufwaerts5($wert_a, $wert_b) 
		{
		$a = $wert_a[7];
		$b = $wert_b[7];
  		if ($a == $b) {
			return 0;
		}
 		return ($a < $b) ? -1 : +1;
		}
		usort($tabellen_zeilen_DATA, 'aufwaerts5');
	}
	if($sort == 9){
		function abwaerts5($wert_a, $wert_b) 
		{
		$a = $wert_a[8];
		$b = $wert_b[8];
  		if ($a == $b) {
			return 0;
		}
 		return ($a > $b) ? -1 : +1;
		}
		usort($tabellen_zeilen_DATA, 'abwaerts5');
	}
	if($sort == 10){
		function aufwaerts6($wert_a, $wert_b) 
		{
		$a = $wert_a[7];
		$b = $wert_b[7];
  		if ($a == $b) {
			return 0;
		}
 		return ($a < $b) ? -1 : +1;
		}
		usort($tabellen_zeilen_DATA, 'aufwaerts6');
	}
	if($sort == 11){
		function abwaerts6($wert_a, $wert_b) 
		{
		$a = $wert_a[7];
		$b = $wert_b[7];
  		if ($a == $b) {
			return 0;
		}
 		return ($a > $b) ? -1 : +1;
		}
		usort($tabellen_zeilen_DATA, 'abwaerts6');
	}
	//
	/*for($i=0;$i<$tabellen_zeilen_anzahl;$i++){
		echo $tabellen_zeilen_DATA[$i][0];
	}*/
?>
<table style="position:relative; top:0px; z-index:99;">
	<tr>
		<td style="width:900px" valign="top">
			<div id="content_left" style="padding-top: 20px; padding-bottom: 15px;">
				<p><b>Liste aller Anfragen</b></p>
			</div>
		</td>
	</tr>
</table>

	<table style="position:relative; top:0px; z-index:99; border-spacing:0pt;">
	<!--Tabellen-KOPF-->
	<tr>
		<?php for($i2=0;$i2<$tabellen_spalten_anzahl;$i2++){ ?>
		<td style="padding:0px; background: #DDD; border-top: 1px solid #000000; border-left: 1px solid #000000; <?php if ($i2==($tabellen_spalten_anzahl-1) ){ echo "border-right: 1px solid #000000;";} ?>border-spacing:0pt;width: <?php echo round($tabellen_spalten_breite[$i2]);?>px" valign="top">
			<?php if($i2 != 5){ ?>
			<!--<div style="float:right; ">
				<a style="text-decoration: none;" href="./experte.php?rubrik=0&sort=<?php echo $i2*2; ?>" target="_self"><img style="border: 0 none;" src="<?php if($sort ==($i2*2)){echo "assets/sorter_oben_ddd.png"; } else {echo "assets/sorter_oben_aaa.png"; }?>"/></a> 
				<a style="text-decoration: none;" href="./experte.php?rubrik=0&sort=<?php echo $i2*2+1; ?>" target="_self"><img style="border: 0 none;" src="<?php if($sort ==($i2*2+1)){echo "assets/sorter_unten_ddd.png"; } else {echo "assets/sorter_unten_aaa.png"; }?>"/></a> 
			</div>-->
			<?php }; ?>
			<div style="float:left; padding:10px; "><b><?php echo $tabellen_spalten_namen[$i2];?></b></div>
		</td>
		<?php }?>
	</tr>
	<!--Tabellen-SorterZeile:-->
	<tr>
		<?php for($i2=0;$i2<$tabellen_spalten_anzahl;$i2++){ ?>
		<td align="center" style="padding-top:4px; padding-bottom:0px; background: #EEE; border-top: 1px solid #000000; border-left: 1px solid #000000; <?php if ($i2==($tabellen_spalten_anzahl-1) ){ echo "border-right: 1px solid #000000;";} ?>border-spacing:0pt;width: <?php echo round($tabellen_spalten_breite[$i2]);?>px" valign="top">
			<?php if($i2 != 3 ){ ?>
			<div >
				<a style="text-decoration: none;" href="./experte.php?rubrik=0&sort=<?php echo $i2*2; ?>" target="_self"><img style="border: 0 none;" src="<?php if($sort ==($i2*2)){echo "assets/sorter_oben_ddd.png"; } else {echo "assets/sorter_oben_aaa.png"; }?>"/></a> 
				<a style="text-decoration: none;" href="./experte.php?rubrik=0&sort=<?php echo $i2*2+1; ?>" target="_self"><img style="border: 0 none;" src="<?php if($sort ==($i2*2+1)){echo "assets/sorter_unten_ddd.png"; } else {echo "assets/sorter_unten_aaa.png"; }?>"/></a> 
			</div>
			<?php }; ?>
		</td>
		<?php }?>
	</tr>
	<!--Tabellen-BODY-->
	
	<form method="post">
	
	<?php for($i=0;$i<$tabellen_zeilen_anzahl;$i++){ ?>
	<tr>
		<?php for($i2=0;$i2<$tabellen_spalten_anzahl;$i2++){ ?>
		
		<!--andere Tabellenspalten:-->
		<?php if($i2 != 4){?> 
		<td style="padding:10px; padding-top: 2px; border-top:1px solid #000000; border-left:1px solid #000000; <?php if($tabellen_zeilen_DATA[$i][7] == 1){ echo "background: #CFC;"; }?> <?php if ($i==($tabellen_zeilen_anzahl-1)){ echo "border-bottom: 1px solid #000000;";} ?> <?php if ($i2==($tabellen_spalten_anzahl-1)){ echo "border-right: 1px solid #000000;";} ?> border-spacing:0pt;width: <?php echo round($tabellen_spalten_breite[$i2]);?>px" valign="top">
			<p>
				<?php if($i2 == 0){ 
						echo $tabellen_zeilen_DATA[$i][0];
						//echo $tabellen_zeilen_DATA[$i][1];
						?>
						&nbsp;<a href="mailto:<?php echo $tabellen_zeilen_DATA[$i][1];?>" target="_self"><img style="border: 0 none;" src="assets/icon_brief.gif"/></a>
						<?php
					}
					
				?>
				<?php if($i2 == 1){ 
						echo $tabellen_zeilen_DATA[$i][2];
						if($tabellen_zeilen_DATA[$i][12]){
							echo "<br/>"."(".$tabellen_zeilen_DATA[$i][12].")";
						}
					}
				?>
				<?php if($i2 == 2){ echo $tabellen_zeilen_DATA[$i][3];}?>
				<?php /*if($i2 == 3){
						echo "<div style='font-size: 0.8em; text-align:left'>";
						$tempo = explode(";", $tabellen_zeilen_DATA[$i][4]);
						if ($tempo[0]){
						if ($tempo[3] < 10) { $tempo[3] = "0".$tempo[3]; }
						if ($tempo[4] < 10) { $tempo[4] = "0".$tempo[4]; }
						if ($tempo[8] < 10) { $tempo[8] = "0".$tempo[8]; }
						if ($tempo[9] < 10) { $tempo[9] = "0".$tempo[9]; }
						echo "Von:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$tempo[0].".".$tempo[1]." ".$tempo[2].",&nbsp;&nbsp;&nbsp;".$tempo[3].":".$tempo[4]."<br/>"; 
						echo "Bis:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$tempo[5].".".$tempo[6]." ".$tempo[7].",&nbsp;&nbsp;&nbsp;".$tempo[8].":".$tempo[9]; 
						}
						echo "</div>";
				}; */?>
				<?php /*if($i2 == 3){
						echo "<div style='font-size: 0.8em; text-align:left'>";
						$tempo = explode(";", $tabellen_zeilen_DATA[$i][5]);
						if ($tempo[0]){
						echo "Von:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$tempo[0].".".$tempo[1]." ".$tempo[2]."<br/>"; 
						echo "Bis:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$tempo[3].".".$tempo[4]." ".$tempo[5]; 
						}
						echo "</div>";
				}; */?>
				<?php if($i2 == 3){
						$anz_dat_test = explode("---123MARGARIS321---", $tabellen_zeilen_DATA[$i][4]);
						$tempo_test = explode(";", $anz_dat_test[0]);
					if($tempo_test[0]){?> 
				
					<div style='font-size: 1.0em; text-align:left;'>
						<u>mögliche Termine der mündlichen Prüfung:</u><br/>
						(bitte alle passenden Daten anwählen)<br/><br/>
						<?php
					$anz_dat = explode("---123MARGARIS321---", $tabellen_zeilen_DATA[$i][4]);
					for($dieses = 0;$dieses<count($anz_dat)-1;$dieses++){
						$tempo = explode(";", $anz_dat[$dieses]);
						if($tempo[0]){
						if ($tempo[3] < 10) { $tempo[3] = "0".$tempo[3]; }
						if ($tempo[4] < 10) { $tempo[4] = "0".$tempo[4]; }
						if ($tempo[5] < 10) { $tempo[5] = "0".$tempo[5]; }
						if ($tempo[6] < 10) { $tempo[6] = "0".$tempo[6]; }
						echo "<b>".intval($dieses+1).").&nbsp;&nbsp;".$tempo[0].".".$tempo[1]." ".$tempo[2].",&nbsp;&nbsp;&nbsp;".$tempo[3].":".$tempo[4]." - ".$tempo[5].":".$tempo[6]." </b>"; 
						//echo "Bis:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$tempo[5].".".$tempo[6]." ".$tempo[7].",&nbsp;&nbsp;&nbsp;".$tempo[8].":".$tempo[9]; 
						}
					
						echo "<div style='float:right;  '>";
						?>
						<?php if($tabellen_zeilen_DATA[$i][7] == 1){ ?>
						<input type="checkbox" name="TESTTESTBLABLA" <?php if($tabellen_zeilen_DATA[$i][11][$dieses] == 1){ echo "checked"; } ?> onclick="this.checked = !this.checked" >
						<?php } ?>
						<?php if($tabellen_zeilen_DATA[$i][7] != 1){ ?>
						<input type="checkbox" name="skata_<?php echo $tabellen_zeilen_DATA[$i][6]; ?>[]" value="<?php echo $dieses; ?>" />
						<?php } ?>
						<?php
						echo "</div>";
					 
						echo "<br/>";
					
					}
					
					echo "</div><br/>";
					}
				?> 
				<?php 
				$tempo = explode(";", $tabellen_zeilen_DATA[$i][5]);
					if ($tempo[0]) {
					echo "<div style='font-size: 1.0em; text-align:left'>";
					echo "<u>Begutachtung der schriftlichen Prüfung:</u><br/>";
					echo "(Anwesenheit nicht erforderlich)<br/>";
					
						echo "Von:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$tempo[0].".".$tempo[1]." ".$tempo[2]."&nbsp;&nbsp;&nbsp;&nbsp;";
						echo "Bis:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$tempo[3].".".$tempo[4]." ".$tempo[5]; 
					
					echo "</div>";
					}
				?>
				
				
				<?php }; ?>
			</p>
		</td>
		<?php }; ?>

		<!--Absage und Zusage-BUTTON-->
		<?php if($i2 == 4){?> 
		<td style="padding:7px; padding-bottom: 2px; border-top:1px solid #000000; border-left:1px solid #000000; <?php if($tabellen_zeilen_DATA[$i][7] == 1){ echo "background: #CFC;"; }?> <?php if ($i==($tabellen_zeilen_anzahl-1)){ echo "border-bottom: 1px solid #000000;";} ?> <?php if ($i2==($tabellen_spalten_anzahl-1)){ echo "border-right: 1px solid #000000;";} ?> border-spacing:0pt;width: <?php echo round($tabellen_spalten_breite[$i2]);?>px" valign="top">
			<?php if($tabellen_zeilen_DATA[$i][7] != 1){?> 
			<div style="float:left;">
				<img style="cursor:pointer; border: 0 none;" src="assets/button_zusagen.png" onclick="document.forms[0].image_geklickt.value='<?php echo $tabellen_zeilen_DATA[$i][6]."-1"; ?>'; document.forms[0].submit()" /> 
			</div>
			<div style="float:right;">
				<img style="cursor:pointer; border: 0 none;" src="assets/button_absagen.png" onclick="document.forms[0].image_geklickt.value='<?php echo $tabellen_zeilen_DATA[$i][6]."-2"; ?>'; document.forms[0].submit()" /> 
			</div>
			<?php };  ?>
			<?php if($tabellen_zeilen_DATA[$i][7] == 1){?> 
				<div style="float:left; padding:7px; padding-top: 4px; padding-left: 4px; "><b>Zugesagt</b></div>
			<?php };  ?>
		</td>
		<?php };  ?>
		
		<?php }; ?>
	</tr>
	<?php }	?>
	<!-- Falls keine Anfragen passend vorhanden, also leere Tabelle: -->
	<?php if(count($tabellen_zeilen_DATA)==0) { ?>
	</table>
	<table style="position:relative; top:0px; z-index:99; border-spacing:0pt;">
	<tr>
		<td style="padding:10px; padding-top: 10px; border:1px solid #000000; border-spacing:0pt; width:900px;"><i>Keine passenden Anfragen gefunden.</i></td>
	</tr>
	<?php }	?>
	
	</table>
	
		<input type="hidden" name="image_geklickt" value="0"/>
	</form>
	<br/>
	

