<p><b>bevorzugte Region:</b><br/>
<input type="radio" name="region_art_experte" value="0" <?php if($_POST['region_art_experte'] == 0){ echo "checked"; }?>  onclick="document.forms[0].form_aktiv.value= 2; document.forms[0].submit()" >&nbsp;alle Kantone&nbsp;&nbsp;&nbsp;
<input type="radio" name="region_art_experte" value="1" <?php if($_POST['region_art_experte'] == 1){ echo "checked"; }?>  onclick="document.forms[0].form_aktiv.value= 2; document.forms[0].submit()" >&nbsp;ausgewählte Kantone&nbsp;&nbsp;&nbsp;

<!-- Falls region art = 1, dann alle Kantone zur auswahl anzeigen: -->
<?php if($_POST['region_art_experte'] == 1){ 
	/*$region_DATA_real = array();
	for($i = 0; $i<count($region_DATA);$i++){
		if($region_DATA[$i][2] == 1){
			array_push($region_DATA_real, array($region_DATA[$i][0], $region_DATA[$i][1], $region_DATA[$i][2])); 
		}
	}*/
?>
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
<?php if($region_DATA[$i][2] == 0){ echo " disabled "; $culur = "#AAAAAA"; } ?>
/>
<?php echo "<font color='".$culur."'>".$region_DATA[$i][1]."</font>"; ?>
</td>
<?php } ?>
<?php } ?>
</tr>
<?php } ?>
</table>
<?php } ?>
</p>