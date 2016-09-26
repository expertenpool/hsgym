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
?>


<div style="padding-top: 10px;	padding-right: 20px; 	padding-bottom: 20px;">
<form method="post" action="./admin_index.php?rubrik=0">				
<p><b>Verfügbare Kantone einstellen:</b></p>

<p>
<table style="font-size: 1em;">
<tr>
<?php for($i2 = 0; $i2<ceil(count($region_DATA)/8);$i2++){ ?>
<?php for($i = 0+($i2*8);$i < 8+($i2*8); $i++){ 
if($i <count($region_DATA)){
?>
<td style="width:56px" valign="top">
<input type="checkbox" name="region_werte[]"<?php echo $i; ?> value="<?php echo $region_DATA[$i][0]; ?>" <?php if($_POST['region_wahl'.$i]>0){ echo "checked";} ?>
<?php $culur = "#000000"; ?>
<?php if($bereits_zugesagte_region_schon_da[$region_DATA[$i][0]] == 1){ echo " checked disabled "; } ?>
<?php if($region_DATA[$i][2] == 1){ echo "checked"; $culur = "#000000"; } ?>
/>
<?php echo "<font color='".$culur."'>".$region_DATA[$i][1]."</font>"; ?>
</td>
<?php } ?>
<?php } ?>
</tr>
<?php } ?>
</table>
</p>
Grau dargestellte Kantone werden bereits aktiv von einer Schule oder einem Experten verwendet, und können deshalb nicht abgewählt werden.
<br/>

<?php 	/*$error_string=""; 
if($formular_cat3_error[0] == 1){	$error_string .="Bitte mindestens einen Kanton verfügbar machen! "; }
if(strlen($error_string) > 0) { 	?>		<p><font color="#FF0000"><?php echo $error_string; ?></font></p> 	<?php	} */?>

	<input type="hidden" name="form_aktiv" value="3"/>
	<p><div align="right" style="padding-right: 0px"><input type="image" name="submit" src="assets/button_kantone_speichern.png"></div></p>

</div>
</form>
