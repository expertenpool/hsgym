<?php
	$tabellen_spalten_namen = array("Name", "", "Fach 1", "Fach 2", "Fach 3");
	$tabellen_spalten_breite = array(250, 150, 166, 167, 167);
	//$tabellen_spalten_breite_OBEN = array(400, 100, 100, 100, 100, 100);
	//
	$tabellen_spalten_anzahl = count($tabellen_spalten_namen);
		include ("mysql_connect.php");
	//
	if($sort == 0){
		$sql = sprintf("SELECT * FROM experte ORDER BY UPPER(name)");
	}
	if($sort == 1){
		$sql = sprintf("SELECT * FROM experte ORDER BY UPPER(name) DESC");
	}
	//3 und 4 entfällt wegen tabellen zwilling
	/*if($sort == 4){
		$sql = sprintf("SELECT * FROM experte ORDER BY UPPER(region)");
	}
	if($sort == 5){
		$sql = sprintf("SELECT * FROM experte ORDER BY UPPER(region) DESC");
	}*/
	if ($sort >= 4) {
		$sql = sprintf("SELECT * FROM experte");
	}
	$res = mysql_db_query( "hsgym-ep", $sql );
	
	$tabellen_zeilen_anzahl = mysql_num_rows($res); 
	$tabellen_zeilen_DATA = array();
	//
	
	while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
		$temp_fach = explode(";", $row[fach]);
		array_push($tabellen_zeilen_DATA, array($row[name], $row[titel], $row[institut], $row[adresse], $row[region], $row[email], $fach_DATA_ID[$temp_fach[1]],$fach_DATA_ID[$temp_fach[2]],$fach_DATA_ID[$temp_fach[3]]));  
	}
	//
	if($sort == 4){
		function aufwaerts1($wert_a, $wert_b) 
		{
		$a = $wert_a[6];
		$b = $wert_b[6];
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
		$a = $wert_a[6];
		$b = $wert_b[6];
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
	if($sort == 8){
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
	if($sort == 9){
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
?>
	<br/>
	<table style="position:relative; top:0px; z-index:99; border-spacing:0pt;">
	<!--Tabellen-KOPF-->
	<tr>
		<?php for($i2=0;$i2<count($tabellen_spalten_breite);$i2++){ ?>
		<td style="padding:10px; background: #DDD; border-top: 1px solid #000000; <?php if($i2 !=1){ echo "border-left:1px solid #000000;"; } ?> <?php if ($i2==(count($tabellen_spalten_breite)-1) ){ echo "border-right: 1px solid #000000;";} ?>border-spacing:0pt;width: <?php echo $tabellen_spalten_breite[$i2];?>px" valign="top">
			<div style="float:left;"><b><?php echo $tabellen_spalten_namen[$i2];?></b></div>
		</td>
		<?php }?>
	</tr>
	
	<!--Tabellen-SorterZeile:-->
	<tr>
		<?php for($i2=0;$i2<count($tabellen_spalten_breite);$i2++){ ?>
		<td align="center" style="padding-top:4px; padding-bottom:0px; background: #EEE; border-top: 1px solid #000000; <?php if($i2 !=1){ echo "border-left:1px solid #000000;"; } ?> <?php if ($i2==(count($tabellen_spalten_breite)-1) ){ echo "border-right: 1px solid #000000;";} ?>border-spacing:0pt;width: <?php echo $tabellen_spalten_breite[$i2];?>px" valign="top">
			<div >
				<?php if($i2!=1){ ?>
				<a style="text-decoration: none;" href="./schule.php?rubrik=3&sort=<?php echo $i2*2; ?>" target="_self"><img style="border: 0 none;" src="<?php if($sort ==($i2*2)){echo "assets/sorter_oben_ddd.png"; } else {echo "assets/sorter_oben_aaa.png"; }?>"/></a> 
				<a style="text-decoration: none;" href="./schule.php?rubrik=3&sort=<?php echo $i2*2+1; ?>" target="_self"><img style="border: 0 none;" src="<?php if($sort ==($i2*2+1)){echo "assets/sorter_unten_ddd.png"; } else {echo "assets/sorter_unten_aaa.png"; }?>"/></a> 
				<?php } ?>
			</div>
		</td>
		<?php }?>
	</tr>
	<!--Tabellen-BODY-->
	<?php for($i=0;$i<$tabellen_zeilen_anzahl;$i++){ ?>
	<tr>
		<?php for($i2=0;$i2<count($tabellen_spalten_breite);$i2++){ ?>
		<td style="padding:10px; padding-top: 2px; padding-bottom: 0px; border-top:1px solid #000000; <?php if($i2 !=1){ echo "border-left:1px solid #000000;"; } ?> <?php if ($i==($tabellen_zeilen_anzahl-1)){ echo "border-bottom: 1px solid #000000;";} ?> <?php if ($i2==count($tabellen_spalten_breite)-1){ echo "border-right: 1px solid #000000;";} ?> border-spacing:0pt;width: <?php echo $tabellen_spalten_breite[$i2];?>px" valign="top">
			<p>
				<?php   if($i2 == 0){ 
							echo "<div style=\"font-size: 0.8em\">";
							echo $tabellen_zeilen_DATA[$i][1];
							echo "</div>";
							echo "<div style=\"font-size: 1.0em\">";
							echo $tabellen_zeilen_DATA[$i][0];
							echo "</div>";
							echo "<div style=\"font-size: 0.8em\">";
							echo $tabellen_zeilen_DATA[$i][2];
							echo "</div>";
						}
				?>
				<?php   if($i2 == 1){ 
							echo "<div style=\"font-size: 0.8em; text-align:right;\">";
							echo $tabellen_zeilen_DATA[$i][3];
							echo "</div>"; 
							echo "<div style=\"font-size: 0.8em; text-align:right;\">";
							?>
							<a href="mailto:<?php echo $tabellen_zeilen_DATA[$i][5];?>" target="_self"><img style="border: 0 none;" src="assets/icon_brief.gif"/></a>
							<?php
							echo "</div>"; 
						}
				?>
				<?php   if($i2 == 2){ 
							echo "<div style=\"font-size: 1.0em; text-align:left;\">";
							echo $tabellen_zeilen_DATA[$i][6];
							echo "</div>"; 
						}
				?>
				<?php   if($i2 == 3){ 
							echo "<div style=\"font-size: 1.0em; text-align:left;\">";
							echo $tabellen_zeilen_DATA[$i][7];
							echo "</div>"; 
						}
				?>
				<?php   if($i2 == 4){ 
							echo "<div style=\"font-size: 1.0em; text-align:left;\">";
							echo $tabellen_zeilen_DATA[$i][8];
							echo "</div>"; 
						}
				?>
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
		<td style="padding:10px; padding-top: 10px; border:1px solid #000000; border-spacing:0pt; width:900px;"><i>Noch keine Experten/Expertinnen vorhanden.</i></td>
	</tr>
	<?php }	?>
	</table>
	<br/>
	
