<?php
?>
<td style="border-right: 1px solid #000000; width:450px" valign="top">

<div id="content_left">
				
<form method="post">
<p><b>Profilanmeldung Schule</b></p>

<p>Name der Schule:<br/><input type="input" name="name_schule" style="width: 420px" value="<?php if(isset($_POST['name_schule'])){ echo $_POST['name_schule']; }?>"></p>

<p>Adresse:<br/><input type="input" name="adresse_schule" style="width: 420px" value="<?php if(isset($_POST['adresse_schule'])){ echo $_POST['adresse_schule']; }?>"></p>

<p>Region:<br/>
<select name="region_wahl" size="1">
<option value="0">---</option>
<?php for($i = 0;$i < count($region_DATA); $i++){ 
		?><option value="<?php echo $region_DATA[$i][0]; ?>" <?php if($_POST['region_wahl'] == $region_DATA[$i][0]){ echo "selected"; }?> >
			<?php echo $region_DATA[$i][1]; ?>
		</option>
		<?php
	} 
?>
</select>
</p>

<p>E-Mail-Adresse Schulleiter/in:<br/><input type="input" name="email_schule" style="width: 420px" value="<?php if(isset($_POST['email_schule'])){ echo $_POST['email_schule']; }?>"></p>

<p>
<table style="font-size: 1em;">
	<tr>
		<td style="width:140px" valign="top">
			Passwort eingeben:<br/>
			Passwort wiederholen:
		</td>
		<td style="width:275px;" valign="top">
			<input type="password" name="passwort1_schule" style="width: 100%" value=""/><br/>
			<input type="password" name="passwort2_schule" style="width: 100%" value=""/>
		</td>
	</tr>
</table>
</p>

<?php 	$error_string=""; 
if($formular_error[0] == 1){	$error_string .="Bitte Namen eingeben! "; }
if($formular_error[1] == 1){	$error_string .="Bitte Adresse eingeben! "; }
if($formular_error[2] == 1) {	$error_string .= "Bitte E-Mail-Adresse eingeben! "; }
if($formular_error[3] == 1) {	$error_string .= "Bitte gültige E-Mail-Adresse eingeben! "; }
if($formular_error[4] == 1) {	$error_string .= "E-Mail-Adresse wird bereits verwendet! "; }
if($formular_error[5] == 1) {	$error_string .= "Bitte Passwort zwei Mal eingeben! "; }
if($formular_error[6] == 1) {	$error_string .= "Passwort muss mindestens 6 Zeichen haben! "; }
if($formular_error[7] == 1){	$error_string .= "Bitte eine Region angeben! "; }
if(strlen($error_string)>0){ 	?>		<p><div style="padding-right: 20px"><font color="#FF0000"><?php echo $error_string; ?></font></div></p>	<?php	} ?>

<input type="hidden" name="form_aktiv" value="1"/>
<p><div align="right" style="padding-right: 20px"><input type="image" name="submit" src="assets/button_schule_registrieren.png"></div></p>
</form>
</div>


</td>

<td style="width:450px" valign="top">
<div id="content_right">

<p>Nach erfolgreicher Registrierung wird Ihnen eine E-Mail mit weiteren Anweisungen und einem Aktivierungslink an die von Ihnen angegebene E-Mail-Adresse zugeschickt.</p>

</div>
</td>

