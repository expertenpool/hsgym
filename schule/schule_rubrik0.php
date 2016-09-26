<?php
include("./functions/get_einstellungen.php");

if($_SESSION['mysql_anzahl_zusagen'] == 0) {
	$_SESSION['mysql_anzahl_zusagen'] = 100000;
}

	date_default_timezone_set("Europe/Zurich");
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
	include ("mysql_connect.php");
	//
	//Alle ZUSAGE-Daten herholen:
	$sql_zusage = sprintf("SELECT * FROM anfrage, zusage, experte WHERE (anfrage.id = zusage.anfrage_id AND anfrage.schule_id = '%s' AND experte.id = zusage.experte_id)", 
		mysql_real_escape_string($_SESSION['mysql_id']));
	$res_zusage = mysql_db_query( "hsgym-ep", $sql_zusage );
	$zusage_ID = array();
	$zusage_ID_DETAIL = array();
	$anzahl_zusagen = 0;
	while ($row_zusage = mysql_fetch_array($res_zusage, MYSQL_ASSOC)) {
		//Hier wird ein Array gebildet wo der index gesetzt ist, falls zusage_id vorhanden.
		//echo "id(".$row_zusage[anfrage_id]."): ".$row_zusage[experte_id]."<br/> ";
		$zusage_ID[$row_zusage[anfrage_id]] = $row_zusage[experte_id];
		$zusage_ID_DETAIL[$row_zusage[anfrage_id]] = $row_zusage[detail];
		$anzahl_zusagen+=1;
	}
	//
	//TABELLE 1 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Alle Schul-Anfragen herholen und finale Herstellung der TabellenDaten:
	$sql = sprintf("SELECT * FROM anfrage WHERE (schule_id = '%s' AND sichtbarkeit = '0')", mysql_real_escape_string($_SESSION['mysql_id']));
	$res = mysql_db_query( "hsgym-ep", $sql );
	$tabellen_zeilen_anzahl = 0;//mysql_num_rows($res); 
	$tabellen_zeilen_DATA = array();
	$art_ID = array("schriftlich und mündlich","schriftlich", "mündlich");
	while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
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
		
		//sowieso alles nur wenn Zugang entsperrt:
		if($_SESSION['mysql_zugang_sperren'] != 1) {
			if ($anzahl_zusagen < $_SESSION['mysql_anzahl_zusagen']) { 
				$tabellen_zeilen_anzahl += 1;
				array_push($tabellen_zeilen_DATA, array($fach_DATA_ID[$row[fach_id]], $art_ID[$row[art]], $row[termin], $row[korrektur], $row[id], $temp_zeit_termin, $temp_zeit_korrektur, $experte_DATA_NAME[$zusage_ID[$row[id]]], $row[klassen_kuerzel], $zusage_ID_DETAIL[$row[id]]));  
			}
			if ($anzahl_zusagen >= $_SESSION['mysql_anzahl_zusagen']) { 
				if (isset($zusage_ID[$row[id]])) {
					$tabellen_zeilen_anzahl += 1;
					array_push($tabellen_zeilen_DATA, array($fach_DATA_ID[$row[fach_id]], $art_ID[$row[art]], $row[termin], $row[korrektur], $row[id], $temp_zeit_termin, $temp_zeit_korrektur, $experte_DATA_NAME[$zusage_ID[$row[id]]], $row[klassen_kuerzel], $zusage_ID_DETAIL[$row[id]]));  
				}
			}
		}
		//FALLS zugang gesperrt: (dann sowieso nur zugesagte Anfragen anzeigen)
		if($_SESSION['mysql_zugang_sperren'] == 1) {
			if (isset($zusage_ID[$row[id]])) {
				$tabellen_zeilen_anzahl += 1;
				array_push($tabellen_zeilen_DATA, array($fach_DATA_ID[$row[fach_id]], $art_ID[$row[art]], $row[termin], $row[korrektur], $row[id], $temp_zeit_termin, $temp_zeit_korrektur, $experte_DATA_NAME[$zusage_ID[$row[id]]], $row[klassen_kuerzel], $zusage_ID_DETAIL[$row[id]]));  
			}
		}
	}
	//TABELLE 2 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//abgestellt in neuer Version
	//Alle Schul-Anfragen herholen und finale Herstellung der TabellenDaten:
	//Sortieren TABELLE 1:
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
		$a = $wert_a[1];
		$b = $wert_b[1];
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
		$a = $wert_a[1];
		$b = $wert_b[1];
  		if ($a == $b) {
			return 0;
		}
 		return ($a > $b) ? -1 : +1;
		}
		usort($tabellen_zeilen_DATA, 'abwaerts2');
	}
	if($sort == 4){
		function aufwaerts3($wert_a, $wert_b) 
		{
		$a = $wert_a[8];
		$b = $wert_b[8];
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
		$a = $wert_a[8];
		$b = $wert_b[8];
  		if ($a == $b) {
			return 0;
		}
 		return ($a > $b) ? -1 : +1;
		}
		usort($tabellen_zeilen_DATA, 'abwaerts3');
	}
	if($sort == 6){
		function aufwaerts4($wert_a, $wert_b) 
		{
		$a = $wert_a[6];
		$b = $wert_b[6];
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
		$a = $wert_a[6];
		$b = $wert_b[6];
  		if ($a == $b) {
			return 0;
		}
 		return ($a > $b) ? -1 : +1;
		}
		usort($tabellen_zeilen_DATA, 'abwaerts4');
	}
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
		$a = $wert_a[7];
		$b = $wert_b[7];
  		if ($a == $b) {
			return 0;
		}
 		return ($a > $b) ? -1 : +1;
		}
		usort($tabellen_zeilen_DATA, 'abwaerts5');
	}
	//
?>
	
<?php include("schule/schule_rubrik0_anfrage.php"); ?>

<?php include("schule/schule_rubrik0_tabelle1.php"); ?>

<?php //abgestellt in dieser Version: include("schule/schule_rubrik0_tabelle2.php"); ?>
