<?php
	$tabellen_spalten_namen = array("Name der Schule","", "Region");
	$tabellen_spalten_breite = array(550,50, 300);
	$tabellen_spalten_anzahl = count($tabellen_spalten_namen);
		include ("mysql_connect.php");
	//
	if($sort == 0){
	$sql = sprintf("SELECT * FROM schule ORDER BY UPPER(name)");
	}
	if($sort == 1){
	$sql = sprintf("SELECT * FROM schule ORDER BY UPPER(name) DESC");
	}
	if($sort >= 4){
		$sql = sprintf("SELECT * FROM schule");
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
		array_push($tabellen_zeilen_DATA, array($row[name], $row[adresse], $region_DATA_ID[$row[region]], $row[email]));  
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
?>
	<br/>
	<table style="position:relative; top:0px; z-index:99; border-spacing:0pt;">
	<!--Tabellen-KOPF-->
	<tr>
		<?php for($i2=0;$i2<3;$i2++){ ?>
		<td style="padding:10px; background: #DDD; border-top: 1px solid #000000; <?php if($i2 !=1){ echo "border-left:1px solid #000000;"; } ?>  <?php if ($i2==2 ){ echo "border-right: 1px solid #000000;";} ?>border-spacing:0pt;width: <?php echo $tabellen_spalten_breite[$i2];?>px" valign="top">
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
				<a style="text-decoration: none;" href="./experte.php?rubrik=2&sort=<?php echo $i2*2; ?>" target="_self"><img style="border: 0 none;" src="<?php if($sort ==($i2*2)){echo "assets/sorter_oben_ddd.png"; } else {echo "assets/sorter_oben_aaa.png"; }?>"/></a> 
				<a style="text-decoration: none;" href="./experte.php?rubrik=2&sort=<?php echo $i2*2+1; ?>" target="_self"><img style="border: 0 none;" src="<?php if($sort ==($i2*2+1)){echo "assets/sorter_unten_ddd.png"; } else {echo "assets/sorter_unten_aaa.png"; }?>"/></a> 
				<?php } ?>
			</div>
		</td>
		<?php }?>
	</tr>
	<!--Tabellen-BODY-->
	<?php for($i=0;$i<$tabellen_zeilen_anzahl;$i++){ ?>
	<tr>
		<?php for($i2=0;$i2<3;$i2++){ ?>
		<td style="font-size: 1.0em; padding:10px; padding-top: 2px; padding-bottom: 0px; border-top:1px solid #000000; <?php if($i2 !=1){ echo "border-left:1px solid #000000;"; } ?>  <?php if ($i==($tabellen_zeilen_anzahl-1)){ echo "border-bottom: 1px solid #000000;";} ?> <?php if ($i2==2){ echo "border-right: 1px solid #000000;";} ?> border-spacing:0pt;width: <?php echo $tabellen_spalten_breite[$i2];?>px" valign="top">
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
	
	<br/>
	
