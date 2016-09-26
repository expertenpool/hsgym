<?php
	include ("mysql_connect.php");
	//
	$sql_anfrage = "SELECT schule_id FROM anfrage";
	$res_anfrage = mysql_db_query( "hsgym-ep", $sql_anfrage );
	$anfrage_summe_ID = array();
	while ($row_anfrage = mysql_fetch_array($res_anfrage, MYSQL_ASSOC)) {
		$anfrage_summe_ID[$row_anfrage[schule_id]] += 1;
	}
	//
	$sql_zusage = "SELECT * FROM anfrage, zusage WHERE (anfrage.id = zusage.anfrage_id)";
	$res_zusage = mysql_db_query( "hsgym-ep", $sql_zusage );
	$zusage_summe_ID = array();
	while ($row_zusage = mysql_fetch_array($res_zusage, MYSQL_ASSOC)) {
		$zusage_summe_ID[$row_zusage[schule_id]] += 1;
	}
	//
	//
	//
	$tabellen_spalten_namen = array("Name der Schule", "", "Region", "Zusagen / Anfragen %","Zuletzt eingeloggt","");
	$tabellen_spalten_breite = array(360,50, 100,200,150,40);
	$tabellen_spalten_anzahl = count($tabellen_spalten_namen);
		include ("mysql_connect.php");
	//
	if($sort == 0){
	$sql = sprintf("SELECT * FROM schule ORDER BY UPPER(name)");
	}
	if($sort == 1){
	$sql = sprintf("SELECT * FROM schule ORDER BY UPPER(name) DESC");
	}
	if($sort >= 4 && $sort <=7){
		$sql = sprintf("SELECT * FROM schule");
	}
	if($sort == 8){
		$sql = sprintf("SELECT * FROM schule ORDER BY last_login");
	}
	if($sort == 9){
		$sql = sprintf("SELECT * FROM schule ORDER BY last_login DESC");
	}
	/*if($sort == 4){
	$sql = sprintf("SELECT * FROM schule ORDER BY UPPER(email)");
	}
	if($sort == 5){
	$sql = sprintf("SELECT * FROM schule ORDER BY UPPER(email) DESC");
	}
	if($sort == 6){
	$sql = sprintf("SELECT * FROM schule ORDER BY UPPER(email)");
	}
	if($sort == 7){
	$sql = sprintf("SELECT * FROM schule ORDER BY UPPER(email) DESC");
	}*/
	$res = mysql_db_query( "hsgym-ep", $sql );
	
	$tabellen_zeilen_anzahl = mysql_num_rows($res); 
	$tabellen_zeilen_DATA = array();
	//
	while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
		$proz = -1;
		if($anfrage_summe_ID[$row[id]]>0){
			$proz = ($zusage_summe_ID[$row[id]] / $anfrage_summe_ID[$row[id]]);
		}
		array_push($tabellen_zeilen_DATA, array($row[name], $row[adresse], $region_DATA_ID[$row[region]], $row[email], $zusage_summe_ID[$row[id]], $anfrage_summe_ID[$row[id]], $row[id], $proz, $row[last_login]));  
	}
	//noch alphabetisch sortieren bei diesen beiden:
	if($sort == 4){
		function aufwaerts1($wert_a, $wert_b) 
		{
		$a = $wert_a[2];
		$b = $wert_b[2];
  		if ($a == $b) {
			return 0;
		}
 		return ($a < $b) ? -1 : +1;
		}
		usort($tabellen_zeilen_DATA, 'aufwaerts1');
	}
	if($sort == 5){
		function abwaerts1($wert_a, $wert_b) 
		{
		$a = $wert_a[2];
		$b = $wert_b[2];
  		if ($a == $b) {
			return 0;
		}
 		return ($a > $b) ? -1 : +1;
		}
		usort($tabellen_zeilen_DATA, 'abwaerts1');
	}
	if($sort == 6){
		function aufwaerts2($wert_a, $wert_b) 
		{
		$a = $wert_a[7];
		$b = $wert_b[7];
  		if ($a == $b) {
			return 0;
		}
 		return ($a < $b) ? -1 : +1;
		}
		usort($tabellen_zeilen_DATA, 'aufwaerts2');
	}
	if($sort == 7){
		function abwaerts2($wert_a, $wert_b) 
		{
		$a = $wert_a[7];
		$b = $wert_b[7];
  		if ($a == $b) {
			return 0;
		}
 		return ($a > $b) ? -1 : +1;
		}
		usort($tabellen_zeilen_DATA, 'abwaerts2');
	}
?>
	<br/>
	<table style="position:relative; top:0px; z-index:99; border-spacing:0pt;">
	<!--Tabellen-KOPF-->
	<tr>
		<?php for($i2=0;$i2<6;$i2++){ ?>
		<td style="padding:10px; background: #DDD; border-top: 1px solid #000000; <?php if($i2 !=1){ echo "border-left:1px solid #000000;"; } ?>  <?php if ($i2==5 ){ echo "border-right: 1px solid #000000;";} ?>border-spacing:0pt;width: <?php echo $tabellen_spalten_breite[$i2];?>px" valign="top">
			<div style="float:left;"><b><?php echo $tabellen_spalten_namen[$i2];?></b></div>
		</td>
		<?php }?>
	</tr>
	<!--Tabellen-SorterZeile:-->
	<tr>
		<?php for($i2=0;$i2<count($tabellen_spalten_breite);$i2++){ ?>
		<td align="center" style="padding-top:4px; padding-bottom:0px; background: #EEE; border-top: 1px solid #000000; <?php if($i2 !=1){ echo "border-left:1px solid #000000;"; } ?> <?php if ($i2==(count($tabellen_spalten_breite)-1) ){ echo "border-right: 1px solid #000000;";} ?>border-spacing:0pt;width: <?php echo $tabellen_spalten_breite[$i2];?>px" valign="top">
			<div >
				<?php if($i2!=1 && $i2<5){ ?>
				<a style="text-decoration: none;" href="./admin_index.php?rubrik=2&sort=<?php echo $i2*2; ?>" target="_self"><img style="border: 0 none;" src="<?php if($sort ==($i2*2)){echo "assets/sorter_oben_ddd.png"; } else {echo "assets/sorter_oben_aaa.png"; }?>"/></a> 
				<a style="text-decoration: none;" href="./admin_index.php?rubrik=2&sort=<?php echo $i2*2+1; ?>" target="_self"><img style="border: 0 none;" src="<?php if($sort ==($i2*2+1)){echo "assets/sorter_unten_ddd.png"; } else {echo "assets/sorter_unten_aaa.png"; }?>"/></a> 
				<?php } ?>
			</div>
		</td>
		<?php }?>
	</tr>
	<!--Tabellen-BODY-->
	<?php for($i=0;$i<$tabellen_zeilen_anzahl;$i++){ ?>
	<tr>
		<?php for($i2=0;$i2<6;$i2++){ 
				if($i2!=5){
		?>
		<td style="font-size: 1.0em; padding:10px; padding-top: 2px; padding-bottom: 0px; border-top:1px solid #000000; <?php if($i2 !=1){ echo "border-left:1px solid #000000;"; } ?>  <?php if ($i==($tabellen_zeilen_anzahl-1)){ echo "border-bottom: 1px solid #000000;";} ?> <?php if ($i2==5){ echo "border-right: 1px solid #000000;";} ?> border-spacing:0pt;width: <?php echo $tabellen_spalten_breite[$i2];?>px" valign="top">
		<?php   } if($i2==5){?>
		<td style="font-size: 1.0em; padding:10px; padding-top: 0px; padding-bottom: 0px; border-top:1px solid #000000; <?php if($i2 !=1){ echo "border-left:1px solid #000000;"; } ?>  <?php if ($i==($tabellen_zeilen_anzahl-1)){ echo "border-bottom: 1px solid #000000;";} ?> <?php if ($i2==5){ echo "border-right: 1px solid #000000;";} ?> border-spacing:0pt;width: <?php echo $tabellen_spalten_breite[$i2];?>px" valign="top">
		<?php   } ?>
			<p>
				<!--schulname und adresse-->
				<?php if($i2 ==0){ 
						echo "<div style='font-size: 1.0em; text-align:left'>";
						echo $tabellen_zeilen_DATA[$i][0];
						echo "</div>";
						echo "<div style='font-size: 0.8em; text-align:left'>";
						echo $tabellen_zeilen_DATA[$i][1];
						echo "</div>";
					}
				?>
				<!--email-->
				<?php if($i2 ==1){  
							echo "<div style=\"font-size: 0.8em; text-align:right;\">";
							?>
							<a href="mailto:<?php echo $tabellen_zeilen_DATA[$i][3];?>" target="_self"><img style="border: 0 none;" src="assets/icon_brief.gif"/></a>
							<?php
							echo "</div>"; 
					}
				?>
				<!--region-->
				<?php if($i2 ==2){ echo $tabellen_zeilen_DATA[$i][2];}?>
				<!--anfragen-->
				<?php if($i2 ==3){ 
						$tia1 = $tabellen_zeilen_DATA[$i][4];
						$tia2 = $tabellen_zeilen_DATA[$i][5];
						if (!$tia1) {
							$tia1 = "0";
						}
						if($tia2){
							echo "<div style='font-size: 1.0em; float:left;'>";
							echo $tia1." / ".$tia2;
							echo "</div>";
							echo "<div style='font-size: 1.0em; float:right;'>";
							echo "<b>".round(($tia1 / $tia2) * 1000) / 10;
							echo " %</b>";
							echo "</div>";
						}
					}
				?>
				<!--zuletzt eingeloggt-->
				<?php if($i2 == 4){ 
					date_default_timezone_set("Europe/Zurich");
					if($tabellen_zeilen_DATA[$i][8]){
					echo date("d M Y H:i ", $tabellen_zeilen_DATA[$i][8]);
					}
					}?>
				<!-- korb-->
				<?php if($i2 == 5){?> 
				<p>
					<img style="cursor:pointer; border: 0 none;" src="assets/papierkorb.png" onclick="document.forms[0].form_anfrage_aktiv.value= 3; document.forms[0].papierkorb_geklickt.value='<?php echo $tabellen_zeilen_DATA[$i][6]; ?>'; document.forms[0].submit()" /> 
				</p>
				<?php }; ?> 

			</p>
		</td>
		<?php }?>
	</tr>
	<?php }	?>
	
				<!-- Falls keine Anfragen gestellt Tab 1 -->
	<?php if(count($tabellen_zeilen_DATA)==0) { ?>
	</table>
	<table style="position:relative; top:0px; z-index:99; border-spacing:0pt;">
	<tr>
		<td style="padding:10px; padding-top: 10px; border:1px solid #000000; border-spacing:0pt; width:900px;"><i>Noch keine Schulen vorhanden.</i></td>
	</tr>
	<?php }	?>
	</table>
	<form method="post">
		<input type="hidden" name="form_anfrage_aktiv" value="1"/>
		<input type="hidden" name="papierkorb_geklickt" value="0"/>
	</form>
	<br/>
	
