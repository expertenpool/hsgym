<?php
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
	//
	include ("mysql_connect.php");
	//
	//Alle bereits zugesagten Objekte herholen:
	$sql_zusage = sprintf("SELECT fach_id, art, termin, region FROM zusage,anfrage,schule WHERE (zusage.experte_id = '%s' AND zusage.anfrage_id = anfrage.id AND anfrage.schule_id = schule.id)", 
		mysql_real_escape_string($_SESSION['mysql_id']));
	$res_zusage = mysql_db_query( "hsgym-ep", $sql_zusage );
	$bereits_zugesagte = array();
	//
	$bereits_zugesagte_fach = array();
	$bereits_zugesagte_fach_schon_da = array();
	//
	$bereits_zugesagte_art = array();
	$bereits_zugesagte_art_schon_da = array();
	//
	$bereits_zugesagte_region = array();
	$bereits_zugesagte_region_schon_da = array();
	//
	$bereits_zugesagte_zeitplan = "000000000000";
	//
	while ($row_zusage = mysql_fetch_array($res_zusage, MYSQL_ASSOC)) {
		//echo $row_zusage[fach_id].", ".$row_zusage[art].", ".$row_zusage[termin].", ".$row_zusage[region]."<br/>";
		array_push($bereits_zugesagte, array($row_zusage[fach_id], $row_zusage[art], $row_zusage[termin], $row_zusage[region]));
		//
		if($bereits_zugesagte_fach_schon_da[$row_zusage[fach_id]] != 1){
			$bereits_zugesagte_fach_schon_da[$row_zusage[fach_id]] = 1;
			array_push($bereits_zugesagte_fach,$row_zusage[fach_id]);
		}
		if($bereits_zugesagte_art_schon_da[$row_zusage[art]] != 1){
			$bereits_zugesagte_art_schon_da[$row_zusage[art]] = 1;
			array_push($bereits_zugesagte_art, $row_zusage[art]);
		}
		if($bereits_zugesagte_region_schon_da[$row_zusage[region]] != 1){
			$bereits_zugesagte_region_schon_da[$row_zusage[region]] = 1;
			array_push($bereits_zugesagte_region, $row_zusage[region]);
		}
		//
		//
		// Alles folgende abgestellt, das würde hier im Zeiteinstellungs-Bereich des Expertenprofils die bereits benutzen inaktiv schalten:
		/*$temp_zeit = explode(";", $row_zusage[termin]);
		if($row_zusage[art] != 1){
			$temp_zeit_von = mktime($temp_zeit[3], $temp_zeit[4], 0, $monat_andersrum[$temp_zeit[1]], $temp_zeit[0], $temp_zeit[2]);
			$temp_zeit_bis = mktime($temp_zeit[8], $temp_zeit[9], 0, $monat_andersrum[$temp_zeit[6]], $temp_zeit[5], $temp_zeit[7]);
			//echo "...".$temp_zeit_von."...";
			//
			//echo date("w", $temp_zeit_von)."--> ".($temp_zeit[3]*100+$temp_zeit[4]).", ";
			//echo date("w", $temp_zeit_bis)."--> ".($temp_zeit[8] * 100 + $temp_zeit[9]).". ";
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
			//echo "<br/>XX   ".$basic_von.", ".$basic_bis.". <br/>";
			//
			for ($i = $basic_von; $i <= $basic_bis; $i++) {
				if($basic_von>=0 && $basic_bis<=11){
					$bereits_zugesagte_zeitplan[$i] = 1;
				}
			}
		}*/
	}
	/*for($i2=0;$i2<count($bereits_zugesagte_art);$i2++){ 
		echo $bereits_zugesagte_art[$i2].", ";
	}*/
?>