<?php

?>
<table style="position:relative; top:0px; z-index:99;">
<tr>
	<form method="post">
<td style="border-right: 1px solid #000000; width:450px" valign="top">

<div id="content_left">
				
<p><b>Profilanpassung Schule</b></p>

<p>Name der Schule:<br/><input type="input" name="name_schule" style="width: 420px" value="<?php if(isset($_SESSION['mysql_name'])){ echo $_SESSION['mysql_name']; }?>"></p>

<p>Adresse:<br/><input type="input" name="adresse_schule" style="width: 420px" value="<?php if(isset($_SESSION['mysql_adresse'])){ echo $_SESSION['mysql_adresse']; }?>"></p>

<p>Region:<br/>
<select name="region_wahl" size="1">
<option value="0">---</option>
<?php for($i = 0;$i < count($region_DATA); $i++){ 
		if($region_DATA[$i][2] == 1){
		?><option value="<?php echo $region_DATA[$i][0]; ?>" <?php if($_POST['region_wahl'] == $region_DATA[$i][0]){ echo "selected"; }?> >
			<?php echo $region_DATA[$i][1]; ?>
		</option>
		<?php
		} 
	}
?>
</select>
</p>

<p>E-Mail-Adresse Schulleiter/in:<br/><input type="input" name="email_schule" style="width: 420px" disabled value="<?php if(isset($_SESSION['mysql_email'])){ echo $_SESSION['mysql_email']; }?>"></p>

<p>
<a style="text-decoration: none;" href="./schule.php?rubrik=1&password=1" target="_self">Passwort ändern? >></a>
</p>
<p>
<a style="text-decoration: none;" href="./schule.php?rubrik=1&cancel=1" target="_self">Ich möchte mein Konto beim HSGYM Expertenpool löschen >></a>
</p>

<?php 	$error_string=""; 
if($formular_error[0] == 1){	$error_string .="Bitte Namen eingeben! "; }
if($formular_error[1] == 1){	$error_string .="Bitte Adresse eingeben! "; }
if($formular_error[2] == 1) {	$error_string .= "Bitte E-Mail-Adresse eingeben! "; }
if($formular_error[3] == 1) {	$error_string .= "Bitte gültige E-Mail-Adresse eingeben! "; }
if($formular_error[4] == 1) {	$error_string .= "E-Mail-Adresse wird bereits verwendet! "; }
if($formular_error[5] == 1){	$error_string .= "Bitte Region angeben! "; }
if(strlen($error_string)>0){ 	?>		<p><div style="padding-right: 20px"><font color="#FF0000"><?php echo $error_string; ?></font></div></p>	<?php	} ?>

<input type="hidden" name="form_aktiv" value="1"/>
<p><div align="right" style="padding-right: 20px"><input type="image" name="submit" src="assets/button_profil_anpassen.png"></div></p>

</div>


</td>

<td style="width:450px" valign="top">
<div id="content_right">

<p>
<input type="checkbox" name="email_versand_schule" <?php if($_POST['email_versand_schule'] == 1){ echo "checked"; } ?> />
Ich möchte per E-Mail informiert werden sobald eine Zusage eintrift.
</p>

</div>
</td>

</form>
</tr>
</table>
