<?php
	include ("mysql_connect.php");
	//
	//Alle bereits zugesagten Objekte herholen:
	$bereits_zugesagtes_fach_schon_da = array();
	//
	$sql_zusage = "SELECT fach_id FROM anfrage";
	$res_zusage = mysql_db_query( "hsgym-ep", $sql_zusage );
	while ($row_zusage = mysql_fetch_array($res_zusage, MYSQL_ASSOC)) {
		//echo $row_zusage[fach_id];
		if($bereits_zugesagtes_fach_schon_da[$row_zusage[fach_id]] != 1){
			$bereits_zugesagtes_fach_schon_da[$row_zusage[fach_id]] = 1;
		}
	}
	$sql_zusage = "SELECT fach FROM experte";
	$res_zusage = mysql_db_query( "hsgym-ep", $sql_zusage );
	while ($row_zusage = mysql_fetch_array($res_zusage, MYSQL_ASSOC)) {
		$temp_fach = explode(";", $row_zusage[fach]);
		for ($i = 1; $i < count($temp_fach) - 1; $i++) {
			if($bereits_zugesagtes_fach_schon_da[$temp_fach[$i]] != 1){
				$bereits_zugesagtes_fach_schon_da[$temp_fach[$i]] = 1;
			}
		}
	}
	//
	//
	
	$tabellen_spalten_namen = array("Name des Fachs", "");
	$tabellen_spalten_breite = array(380, 20);
	$tabellen_spalten_anzahl = count($tabellen_spalten_namen);
	
	include ("mysql_connect.php");
	//
	if($sort == 0){
		$sql = sprintf("SELECT * FROM fach ORDER BY UPPER(name)");
	}
	if($sort == 1){
		$sql = sprintf("SELECT * FROM fach ORDER BY UPPER(name) DESC");
	}

	$res = mysql_db_query( "hsgym-ep", $sql );
	
	$tabellen_zeilen_anzahl = mysql_num_rows($res); 
	$tabellen_zeilen_DATA = array();
	//
	
	while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
		array_push($tabellen_zeilen_DATA, array($row[id], $row[name]));  
	}
?>

<div style="padding-top: 10px;	padding-left: 20px; 	padding-bottom: 60px;">
	
<form method="post" action="./admin_index.php?rubrik=0#anchor_fach">
<p><b>Verfügbare Fächer einstellen:</b></p>

<br/>
	<table style="font-size: 1em; position:relative; top:0px; z-index:99; border-spacing:0pt;">
	<!--Tabellen-KOPF-->
	<tr>
		<?php for($i2=0;$i2<count($tabellen_spalten_breite);$i2++){ ?>
		<td style="padding:10px; background: #DDD; border-top: 1px solid #000000; border-left:1px solid #000000; <?php if ($i2==1 ){ echo "border-right: 1px solid #000000;";} ?>border-spacing:0pt;width: <?php echo $tabellen_spalten_breite[$i2];?>px" valign="top">
			<div style="float:left;"><b><?php echo $tabellen_spalten_namen[$i2];?></b></div>
		</td>
		<?php }?>
	</tr>
	<!--Tabellen-SorterZeile:-->
	<tr>
		<?php for($i2=0;$i2<count($tabellen_spalten_breite);$i2++){ ?>
		<td align="center" style="padding-top:4px; padding-bottom:0px; background: #EEE; border-top: 1px solid #000000; border-left:1px solid #000000; <?php if ($i2==(count($tabellen_spalten_breite)-1) ){ echo "border-right: 1px solid #000000;";} ?>border-spacing:0pt;width: <?php echo $tabellen_spalten_breite[$i2];?>px" valign="top">
			<div >
				<?php if($i2 == 0 ){ ?>
				<a style="text-decoration: none;" href="./admin_index.php?rubrik=0&sort=<?php echo $i2*2; ?>" target="_self"><img style="border: 0 none;" src="<?php if($sort ==($i2*2)){echo "assets/sorter_oben_ddd.png"; } else {echo "assets/sorter_oben_aaa.png"; }?>"/></a> 
				<a style="text-decoration: none;" href="./admin_index.php?rubrik=0&sort=<?php echo $i2*2+1; ?>" target="_self"><img style="border: 0 none;" src="<?php if($sort ==($i2*2+1)){echo "assets/sorter_unten_ddd.png"; } else {echo "assets/sorter_unten_aaa.png"; }?>"/></a> 
				<?php } ?>
			</div>
		</td>
		<?php }?>
	</tr>
	<!--Tabellen-BODY-->
	<?php for($i=0;$i<count($tabellen_zeilen_DATA);$i++){ ?>
	<tr>
		<?php for($i2=0;$i2<count($tabellen_spalten_breite);$i2++){ ?>
		<td style="font-size: 1.0em; padding:10px; padding-top: 2px; padding-bottom: 0px; border-top:1px solid #000000; border-left:1px solid #000000; <?php if ($i==($tabellen_zeilen_anzahl-1)){ echo "border-bottom: 1px solid #000000;";} ?> <?php if ($i2==1){ echo "border-right: 1px solid #000000;";} ?> border-spacing:0pt;width: <?php echo $tabellen_spalten_breite[$i2];?>px" valign="top">
			<p>
				<!--schulname und adresse-->
				<?php if($i2 == 0){ 
						echo "<div style='font-size: 1.0em; text-align:left'>";
						echo $tabellen_zeilen_DATA[$i][1];
						echo "</div>";
					}
				?>
				<?php if($i2 == 1 && $bereits_zugesagtes_fach_schon_da[$tabellen_zeilen_DATA[$i][0]] != 1 ){ ?>
						<img style="cursor:pointer; border: 0 none;" src="assets/papierkorb_klein.png" onclick="document.forms[3].form_aktiv.value= 5; document.forms[3].papierkorb_geklickt.value='<?php echo $tabellen_zeilen_DATA[$i][0]; ?>'; document.forms[3].submit()" /> 
				<?php }	?>
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
		<td style="padding:10px; padding-top: 10px; border:1px solid #000000; border-spacing:0pt; width:400px;"><i>Noch keine Prüfungsfächer vorhanden.</i></td>
	</tr>
	<?php }	?>
	</table>
<div id="anchor_fach"></div>
<p><b>Neues Prüfungsfach hinzufügen:</b><br/><p><input type="input" name="neues_fach" style="width: 420px" value=""></p></p>


<?php 	/*$error_string=""; 
if($formular_cat4_error[0] == 1){	$error_string .="Bitte ein Prüfungsfach eingeben! "; }
if($formular_cat4_error[1] == 1){	$error_string .="Prüfungsfach wird bereits verwendet! "; }
if(strlen($error_string)>0){ 	?>		<p><font color="#FF0000"><?php echo $error_string; ?></font></p> 	<?php	} */?>

<?php if(strlen($_SESSION['formular_cat4_error_zeile'])) {
	?>		<p><font color="#FF0000"><?php echo $_SESSION['formular_cat4_error_zeile'] ; ?></font></p> 	<?php
}
$_SESSION['formular_cat4_error_zeile'] = "";
?>

<input type="hidden" name="form_aktiv" value="4"/>
<input type="hidden" name="papierkorb_geklickt" value="0"/>
<p><div align="right" style="padding-right: 0px"><input type="image" name="submit" src="assets/button_fach_add.png"></div></p>

Prüfungsfächer die bereits von Schulen oder Experten verwendet werden, können nicht mehr gelöscht werden.
<br/>

</form>
</div>