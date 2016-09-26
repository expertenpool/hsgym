<!-- Falls prüfungs art = 1 oder 2 (also mündlich inklusive), dann zeit vor auswahl anzeigen: -->
<?php if($_POST['pruefungs_art_experte'] == 0 || $_POST['pruefungs_art_experte'] == 2){ ?>
<p><b>bevorzugte Zeitplanung (für die mündliche Prüfung):</b><br/>
<input type="radio" name="zeitplan_art_experte" value="0" <?php if($_POST['zeitplan_art_experte'] == 0){ echo "checked"; }?>  onclick="document.forms[0].form_aktiv.value= 2; document.forms[0].submit()" >&nbsp;ich kann jederzeit zu einer mündlichen Prüfung erscheinen.<br/>
<input type="radio" name="zeitplan_art_experte" value="1" <?php if($_POST['zeitplan_art_experte'] == 1){ echo "checked"; }?>  onclick="document.forms[0].form_aktiv.value= 2; document.forms[0].submit()" >&nbsp;ich kann nur an bestimmten Wochen(halb)tagen zur Prüfung erscheinen.&nbsp;&nbsp;&nbsp;
</p>
<!-- Falls zeitplan art = 1, dann Wochenhalbtage zur auswahl anzeigen: -->
<?php if($_POST['zeitplan_art_experte'] == 1){ 
	$wochen_tage_abk = array("Mo","Di","Mi","Do","Fr","Sa","So");
?>
	<table style="font-size: 1em; border-spacing:0pt;">
		<tr>
			<td style="width:80px; border-right: 1px solid #000000; border-bottom: 1px solid #000000;" valign="top">
			</td>
			<?php for($i=0;$i<=5;$i++){ ?>
			<td style="width:50px; border: 1px solid #000000; background: #EEE;" valign="top">
				&nbsp;&nbsp;<?php echo $wochen_tage_abk[$i]; ?>
			</td>
			<?php } ?>
		</tr>
		<tr>
			<td style="width:80px; border: 1px solid #000000; background: #EEE;" valign="top">
				&nbsp;&nbsp;Vormittag
			</td>
			<?php for($i=0;$i<=5;$i++){ ?>
			<td style="width:50px; border: 1px solid #000000;" valign="top">
				&nbsp;&nbsp;<input type="checkbox" name="zeitplan_werte[]" value="<?php echo ($i*2); ?>" <?php if($_POST['zeitplan_wahl'.($i*2)]>0){ echo "checked";} ?>
				<?php if($bereits_zugesagte_zeitplan[$i*2] == 1){ echo " checked disabled "; } ?>
				/>
			</td>
			<?php } ?>
		</tr>
		<tr>
			<td style="width:80px; border: 1px solid #000000; background: #EEE;" valign="top">
				&nbsp;&nbsp;Nachmittag
			</td>
			<?php for($i=0;$i<=5;$i++){ ?>
			<td style="width:50px; border: 1px solid #000000;" valign="top">
				&nbsp;&nbsp;<input type="checkbox" name="zeitplan_werte[]" value="<?php echo ($i*2+1); ?>" <?php if($_POST['zeitplan_wahl'.($i*2+1)]>0){ echo "checked";} ?>
				<?php if($bereits_zugesagte_zeitplan[$i*2+1] == 1){ echo " checked disabled "; } ?>
				/>
			</td>
			<?php } ?>
		</tr>
	</table>
<?php } ?>

<?php } ?>

