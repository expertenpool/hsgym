<?php
?>
<form method="post">
<td style="border-right: 1px solid #000000; width:450px" valign="top">
<div id="content_left">
				
<p><b>Profilanmeldung Experte/Expertin</b></p>

<p>Name, Vorname:<br/><input type="input" name="name_experte" style="width: 420px" value="<?php if(isset($_POST['name_experte'])){ echo $_POST['name_experte']; }?>"></p>

<p>Titel:<br/><input type="input" name="titel_experte" style="width: 420px" value="<?php if(isset($_POST['titel_experte'])){ echo $_POST['titel_experte']; }?>"></p>

<p>Institut / Seminar / Departement:<br/><input type="input" name="institut_experte" style="width: 420px" value="<?php if(isset($_POST['institut_experte'])){ echo $_POST['institut_experte']; }?>"></p>

<p>Postadresse:<br/><input type="input" name="adresse_experte" style="width: 420px" value="<?php if(isset($_POST['adresse_experte'])){ echo $_POST['adresse_experte']; }?>"></p>

<p>E-Mail-Adresse Experte/Expertin:<br/><input type="input" name="email_experte" style="width: 420px" value="<?php if(isset($_POST['email_experte'])){ echo $_POST['email_experte']; }?>"></p>

<p>
<table style="font-size: 1em;">
	<tr>
		<td style="width:140px" valign="top">
			Passwort eingeben:<br/>
			Passwort wiederholen:
		</td>
		<td style="width:275px;" valign="top">
			<input type="password" name="passwort1_experte" style="width: 100%" value="<?php if(isset($_POST['passwort1_experte'])){ echo $_POST['passwort1_experte']; }?>"/><br/>
			<input type="password" name="passwort2_experte" style="width: 100%" value="<?php if(isset($_POST['passwort2_experte'])){ echo $_POST['passwort2_experte']; }?>"/>
		</td>
	</tr>
</table>
</p>

</div>
</td>

<td style="width:450px" valign="top">
<div id="content_right">

<p><b>Prüfungsfächer:</b><br/>
<div id = "dropdown_menues">
	
<!-- Hier kommen die dropdown menues von javascript hin -->
	<?php 
	$e = 0;
	$schon_da = array();
	
	for($i2=0;$i2<100;$i2++){ 
		if($_POST['fach_wahl'.$i2] != 0){
			if($schon_da[$_POST['fach_wahl'.$i2]] != 1){
	?>
		<select name="fach_wahl<?php echo $e;?>" onchange="document.forms[0].form_aktiv.value= 2; document.forms[0].submit()" size="1">
		<option value="0">---</option>
		<?php for($i=0;$i<count($fach_DATA);$i++){ ?>
		<option value="<?php echo $fach_DATA[$i][0];?>" <?php if($_POST['fach_wahl'.$i2] == $fach_DATA[$i][0]){ $schon_da[$_POST['fach_wahl'.$i2]] = 1; echo "selected"; } ?>><?php echo $fach_DATA[$i][1];?></option>
		<?php } ?>
		</select>
	<?php
			};
		$e++;
		};
	}; 
	//Jetzt mit dem $e noch ein letztes leeres select erstellen:
	?>
		<select name="fach_wahl<?php echo $e;?>" onchange="document.forms[0].form_aktiv.value= 2; document.forms[0].submit()" size="1">
		<option value="0">---</option>
		<?php for($i=0;$i<count($fach_DATA);$i++){ ?>
		<option value="<?php echo $fach_DATA[$i][0];?>"><?php echo $fach_DATA[$i][1];?></option>
		<?php } ?>
		</select>

</div>

<!--
<p><b>bevorzugte Prüfungsart:</b><br/>
<input type="radio" name="pruefungs_art_experte" value="0" <?php //if($_POST['pruefungs_art_experte'] == 0){ echo "checked"; }?>  onclick="document.forms[0].form_aktiv.value= 2; document.forms[0].submit()" >&nbsp;schriftlich und mündlich&nbsp;&nbsp;&nbsp;
<input type="radio" name="pruefungs_art_experte" value="1" <?php //if($_POST['pruefungs_art_experte'] == 1){ echo "checked"; }?>  onclick="document.forms[0].form_aktiv.value= 2; document.forms[0].submit()" >&nbsp;nur schriftlich&nbsp;&nbsp;&nbsp;
<input type="radio" name="pruefungs_art_experte" value="2" <?php //if($_POST['pruefungs_art_experte'] == 2){ echo "checked"; }?>  onclick="document.forms[0].form_aktiv.value= 2; document.forms[0].submit()" >&nbsp;nur mündlich&nbsp;&nbsp;&nbsp;<br/>
</p>-->

<?php //include("experte/experte_rubrik1_zeitplan.php"); ?>
<?php //include("experte/experte_rubrik1_region.php"); ?>
			
<?php 	$error_string=""; 
if($formular_error[0] == 1){	$error_string .="Bitte Namen eingeben! "; }
if($formular_error[1] == 1){	$error_string .="Bitte Adresse eingeben! "; }
if($formular_error[2] == 1) {	$error_string .= "Bitte E-Mail-Adresse eingeben! "; }
if($formular_error[3] == 1) {	$error_string .= "Bitte gültige E-Mail-Adresse eingeben! "; }
if($formular_error[4] == 1) {	$error_string .= "E-Mail-Adresse wird bereits verwendet."; }
if($formular_error[5] == 1) {	$error_string .= "Bitte Passwort zwei Mal eingeben."; }
if($formular_error[6] == 1){	$error_string .= "Passwort muss mindestens 6 Zeichen haben."; }
if(strlen($error_string)>0){ 	?>		<p><font color="#FF0000"><?php echo $error_string; ?></font></p> 	<?php	} ?>

<br/>
<input type="hidden" name="form_aktiv" value="1"/>
<p><div align="right" style="padding-right: 20px"><input type="image" name="submit" src="assets/button_experte_registrieren.png"></div></p>


<br/>
<p>Nach erfolgreicher Registrierung wird Ihnen eine E-Mail mit weiteren Anweisungen und einem Aktivierungslink an die von Ihnen angegebene E-Mail-Adresse zugeschickt.</p>

</div>
</td>
</form>
