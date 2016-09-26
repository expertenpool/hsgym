<?php
	include ("mysql_connect.php");
	//
	//Alle bereits zugesagten Objekte herholen:
	$bereits_zugesagte_region_schon_da = array();
	//
	$sql_zusage = "SELECT region FROM schule";
	$res_zusage = mysql_db_query( "hsgym-ep", $sql_zusage );
	while ($row_zusage = mysql_fetch_array($res_zusage, MYSQL_ASSOC)) {
		if($bereits_zugesagte_region_schon_da[$row_zusage[region]] != 1){
			$bereits_zugesagte_region_schon_da[$row_zusage[region]] = 1;
		}
	}
	$sql_zusage = "SELECT region FROM experte";
	$res_zusage = mysql_db_query( "hsgym-ep", $sql_zusage );
	while ($row_zusage = mysql_fetch_array($res_zusage, MYSQL_ASSOC)) {
		$temp_region = explode(";", $row_zusage[region]);
		for ($i = 1; $i < count($temp_region) - 1; $i++) {
			if($bereits_zugesagte_region_schon_da[$temp_region[$i]] != 1){
				$bereits_zugesagte_region_schon_da[$temp_region[$i]] = 1;
			}
		}
	}
	
	//
	//
	
	$region_string = ";";
	/*$region_counter = 0;
	for ($i2 = 0; $i2 < 100; $i2++) { 
		$region_string .= $_POST['region_werte'][$i2].";";
		$region_counter +=$_POST['region_werte'][$i2];
	}
	//echo $region_counter;
	*/
	$formular_cat3_error = array(0, 0);
	/*if ($region_counter == 0) {
		$formular_cat3_error[0] = 1;
	}*/
		//echo $_POST["general_passwort"]; 
		//$_SESSION['mysql_general_passwort']
		//echo $_POST["anzahl_zusagen"];
		//$_SESSION['mysql_anzahl_zusagen']
	//wenn vorerst ok, dann
	if ($formular_cat3_error[0] == 0) {
		$region_speichern = "00000000000000000000000000";
		for ($i2 = 0; $i2 < 100; $i2++) { 
			//echo $bereits_zugesagte_region_schon_da[$i2].",";
			//$region_string .= $bereits_zugesagte_region_schon_da[$i2+1].";" ;
			//$region_string .= $_POST['region_werte'][$i2].";";
			//echo ($_POST['region_werte'][$i2] - 1).",";
			if ($i2 >= 1 && $i2 <= 26) {
				if($bereits_zugesagte_region_schon_da[$i2] == 1){
					$region_speichern[$i2-1] = "1";
				}
			}
			if(($_POST['region_werte'][$i2]-1)>=0 && ($_POST['region_werte'][$i2]-1)<=25){
				$region_speichern[($_POST['region_werte'][$i2] - 1)] = "1";
			}
			//$region_counter +=$_POST['region_werte'][$i2];
		}
		//echo "  ".$region_speichern;
		//echo $region_string;
		for ($i2 = 0; $i2 <= 25; $i2++) { 
			$sql = sprintf("UPDATE region SET sichtbarkeit = '%s' WHERE (id = '%s')",
				mysql_real_escape_string($region_speichern[$i2]),
				mysql_real_escape_string($i2+1));
			$res = mysql_db_query( "hsgym-ep", $sql );
		}
			$_SESSION['info_zeile'] = "Verfügbare Kantone abgespeichert!";
			include("./functions/get_region_entries.php");
	}
?>
