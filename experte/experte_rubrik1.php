<?php
	

?>
	<table style="position:relative; top:0px; z-index:99;">
	<tr>
<form method="post">
<td style="border-right: 1px solid #000000; width:450px" valign="top">
<div id="content_left">
				
<p><b>Profilanpassung Experte/Expertin</b></p>

<p>Name, Vorname:<br/><input type="input" name="name_experte" style="width: 420px" value="<?php if(isset($_SESSION['mysql_name'])){ echo $_SESSION['mysql_name']; }?>"></p>

<p>Titel:<br/><input type="input" name="titel_experte" style="width: 420px" value="<?php if(isset($_SESSION['mysql_titel'])){ echo $_SESSION['mysql_titel']; }?>"></p>

<p>Institut / Seminar / Departement:<br/><input type="input" name="institut_experte" style="width: 420px" value="<?php if(isset($_SESSION['mysql_institut'])){ echo $_SESSION['mysql_institut']; }?>"></p>

<p>Postadresse:<br/><input type="input" name="adresse_experte" style="width: 420px" value="<?php if(isset($_SESSION['mysql_adresse'])){ echo $_SESSION['mysql_adresse']; }?>"></p>

<p>E-Mail-Adresse Experte/Expertin:<br/><input type="input" name="email_experte" style="width: 420px" disabled value="<?php if(isset($_SESSION['mysql_email'])){ echo $_SESSION['mysql_email']; }?>"></p>

<p>
<a style="text-decoration: none;" href="./experte.php?rubrik=1&password=1" target="_self">Passwort ändern? >></a>
</p>
<p>
<a style="text-decoration: none;" href="./experte.php?rubrik=1&cancel=1" target="_self">Ich möchte mein Konto beim HSGYM Expertenpool löschen >></a>
</p>

</div>
</td>

<td style="width:450px" valign="top">
<div id="content_right">

<p><b>Prüfungsfächer:</b><br/>
<div id = "dropdown_menues">
	
<!-- Hier kommen die dropdown menues mit javascript-funktion hin -->
	<?php
	$e = 0;
	for($i2=0;$i2<count($bereits_zugesagte_fach);$i2++){ 
			?>
			<select name="deaktiviert_fach_wahl<?php echo $i2;?>" size="1" disabled>
			<option value="0">---</option>
			<?php for($i=0;$i<count($fach_DATA);$i++){ ?>
			<option value="<?php echo $fach_DATA[$i][0];?>" <?php if($bereits_zugesagte_fach[$i2] == $fach_DATA[$i][0]){ echo "selected"; } ?>><?php echo $fach_DATA[$i][1];?></option>
			<?php } ?>
			</select>
			<?php
	};
	?>
	
	<?php 
	$e = 0;
	$schon_da = array();
	for($i2=0;$i2<100;$i2++){ 
		if($_POST['fach_wahl'.$i2] != 0){
			if($schon_da[$_POST['fach_wahl'.$i2]] != 1 && $bereits_zugesagte_fach_schon_da[$_POST['fach_wahl'.$i2]] != 1){
			?>
		<select name="fach_wahl<?php echo $e;?>" onchange="document.forms[0].form_aktiv.value= 2; document.forms[0].submit()" size="1" >
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
</p>

<!-- Hier wurde einiges abgestellt für die neue Version -->
<!--<p><b>bevorzugte Prüfungsart:</b><br/>-->
<?php
	/*for($i2=0;$i2<count($bereits_zugesagte_art);$i2++){ 
		$art_disabler += $bereits_zugesagte_art[$i2];
	}
	if( $art_disabler >0){
		$art_disabler+=1;
	}*/
?>
<!--<input type="radio" name="pruefungs_art_experte" value="0" <?php //if($_POST['pruefungs_art_experte'] == 0){ echo "checked"; }?>  onclick="document.forms[0].form_aktiv.value= 2; document.forms[0].submit()" >&nbsp;schriftlich und mündlich&nbsp;&nbsp;&nbsp;
<input type="radio" <?php //if($art_disabler == 3){ echo "disabled"; } ?> <?php //if($art_disabler == 4){ echo "disabled"; } ?> <?php //if($art_disabler == 1){ echo "disabled"; } ?>
 name="pruefungs_art_experte" value="1" <?php //if($_POST['pruefungs_art_experte'] == 1){ echo "checked"; }?>  onclick="document.forms[0].form_aktiv.value= 2; document.forms[0].submit()" >&nbsp;nur schriftlich&nbsp;&nbsp;&nbsp;
<input type="radio" <?php //if($art_disabler == 2){ echo "disabled"; } ?> <?php //if($art_disabler == 4){ echo "disabled"; } ?> <?php //if($art_disabler == 1){ echo "disabled"; } ?>
 name="pruefungs_art_experte" value="2" <?php //if($_POST['pruefungs_art_experte'] == 2){ echo "checked"; }?>  onclick="document.forms[0].form_aktiv.value= 2; document.forms[0].submit()" >&nbsp;nur mündlich&nbsp;&nbsp;&nbsp;<br/>
</p>
-->

<?php //include("experte/experte_rubrik1_zeitplan.php"); ?>
<?php //include("experte/experte_rubrik1_region.php"); ?>
	

<?php 	$error_string=""; 
if($formular_error[0] == 1){	$error_string .="Bitte Namen eingeben! "; }
if($formular_error[1] == 1){	$error_string .="Bitte Adresse eingeben! "; }
if($formular_error[2] == 1) {	$error_string .= "Bitte E-Mail-Adresse eingeben! "; }
if($formular_error[3] == 1) {	$error_string .= "Bitte gültige E-Mail-Adresse eingeben! "; }
if($formular_error[4] == 1){	$error_string .= "E-Mail-Adresse wird bereits verwendet."; }
if(strlen($error_string)>0){ 	?>		<p><font color="#FF0000"><?php echo $error_string; ?></font></p> 	<?php	} ?>

<br/>
<div id = "form_submit">
	
<!-- Hier kommt der formsubmit von javascript hin -->
	
	<input type="hidden" name="form_aktiv" value="1"/>
	<p><div align="right" style="padding-right: 20px"><input type="image" name="submit" src="assets/button_profil_anpassen.png"></div></p>
</div>


<br/>
</div>
</td>
</form>

	</tr>
	</table>
