<?php
	

?>
<table style="position:relative; top:0px; z-index:99;">
<tr>
<td style="border-right: 1px solid #000000; border-bottom: 1px solid #000000; width:450px" valign="top">
<div style="padding-top: 20px;	padding-right: 10px; 	padding-bottom: 0px;">
<form method="post" action="./admin_index.php?rubrik=0">
				
<p><b>Allgemeine Einstellungen</b></p>

<p>
<input type="checkbox" name="zugang_sperren" <?php if($_SESSION['mysql_zugang_sperren'] == 1){ echo "checked"; } ?> />
Zugang zum Expertenpool sperren.
</p>
<p>
Falls der Zugang gesperrt wird, passiert folgendes:
<li>Es können sich keine neuen Schulen/Experten registrieren.</li>
<li>Bereits registrierte Schulen und Experten können weiterhin ihre Anfragen/Zusagen einsehen, jedoch lassen sich keine Änderungen vornehmen.</li>
</p>

<p>Generalpasswort:<br/><input type="input" name="general_passwort" style="width: 420px" value="<?php if(isset($_SESSION['mysql_general_passwort'] )){ echo $_SESSION['mysql_general_passwort'] ; }?>"></p>

<p>Maximale Anzahl Zusagen pro Schule (0 = unbegrenzt):<br/><input type="input;" name="anzahl_zusagen" style="width: 420px" value="<?php if(isset($_SESSION['mysql_anzahl_zusagen'] )){ echo $_SESSION['mysql_anzahl_zusagen']; }?>"></p>

<?php 	$error_string=""; 
if($formular_cat1_error[0] == 1){	$error_string .="Bitte Generalpasswort eingeben! "; }
if($formular_cat1_error[1] == 1){	$error_string .="Bitte eine Zahl >=0 eingeben! "; }
if(strlen($error_string)>0){ 	?>		<p><font color="#FF0000"><?php echo $error_string; ?></font></p> 	<?php	} ?>

	<input type="hidden" name="form_aktiv" value="1"/>
	<p><div align="right" style="padding-right: 25px"><input type="image" name="submit" src="assets/button_einstellungen_speichern.png"></div></p>

</div>
</form>

</td>

<td style="border-bottom: 1px solid #000000; width:450px" valign="top">
<div style="padding-top: 20px;	padding-left: 20px; 	padding-bottom: 0px;">
<form method="post" action="./admin_index.php?rubrik=0">
<p><b>Expertenpool zurücksetzen:</b></p>
<p>Beim Ausführen dieser Aktion passiert folgendes:
<li>alle erstellten Anfragen aller Schulen werden gelöscht</li>
<li>alle gemachten Zusagen aller Experten/Expertinnen werden gelöscht</li>
<li>alle gemachten Absagen aller Experten/Expertinnen werden gelöscht</li>
</p>
<p><b>ACHTUNG: Alle Schulen- und Experten-Kontos bleiben bestehen.</b><br/>
</p>


<?php 	$error_string=""; 
if($formular_cat2_error[0] == 1){	$error_string .="Bitte Namen eingeben! "; }
if($formular_cat2_error[1] == 1){	$error_string .="Bitte Adresse eingeben! "; }
if(strlen($error_string)>0){ 	?>		<p><font color="#FF0000"><?php echo $error_string; ?></font></p> 	<?php	} ?>

<input type="hidden" name="form_aktiv" value="2"/>
<p><div align="right" style="padding-right: 20px"><input type="image" name="submit" src="assets/button_expertenpool_zu.png"></div></p>

</form>
</div>
</td>


</tr>
</table>



<table style="position:relative; top:-4px; z-index:99;">
<tr>
<td style="border-right: 1px solid #000000; width:460px" valign="top">
	<?php include("admin/admin_rubrik0_kantone.php");?>
</td>

<td style="width:440px" valign="top">
	<?php include("admin/admin_rubrik0_fach.php");?>
</td>


</tr>
</table>