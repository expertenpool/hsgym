<?php

?>
<table style="position:relative; top:0px; z-index:99;">
<tr>
<td style="border-right: 1px solid #000000; width:450px" valign="top">

<div id="content_left">
				
<form method="post">
<p><b>Passwort-Änderung Experte/Expertin</b></p>

<p>Altes Passwort eingeben:<br/><input type="password" name="passwort_alt_experte" style="width: 420px" value="<?php if(isset($_POST['passwort_alt_experte'])){ echo $_POST['passwort_alt_experte']; }?>"></p>

<p>Neues Passwort zweimal eingeben:<br/>
<input type="password" name="passwort_neu1_experte" style="width: 420px" value="<?php if(isset($_POST['passwort_neu1_experte'])){ echo $_POST['passwort_neu1_experte']; }?>">
<input type="password" name="passwort_neu2_experte" style="width: 420px" value="<?php if(isset($_POST['passwort_neu2_experte'])){ echo $_POST['passwort_neu2_experte']; }?>"></p>


<?php 	$error_string=""; 
if($formular_error[0] == 1){	$error_string .="Bitte altes Passwort eingeben! "; }

if($formular_error[5] == 1) {	$error_string .= "Bitte Passwort zwei Mal eingeben."; }
if($formular_error[6] == 1) {	$error_string .= "Passwort muss mindestens 6 Zeichen haben."; }
if($formular_error[7] == 1) {	$error_string .= "Altes Passwort ist ungültig."; }
if($formular_error[8] == 1){	$error_string .= "Altes und neues Passwort identisch."; }
if(strlen($error_string)>0){ 	?>		<p><div style="padding-right: 20px"><font color="#FF0000"><?php echo $error_string; ?></font></div></p>	<?php	} ?>

<input type="hidden" name="form_password" value="1"/>
<p><div align="right" style="padding-right: 20px"><input type="image" name="submit" src="assets/button_passwort.png"></div></p>
</form>
</div>


</td>

<td style="width:450px" valign="top">
<div id="content_right">

<p>
<a style="text-decoration: none;" href="./experte.php?rubrik=1" target="_self">zurück >></a>
</p>

</div>
</td>
</tr>
</table>
