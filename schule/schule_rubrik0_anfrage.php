<?php

if($_SESSION['mysql_zugang_sperren'] == 1) {
	echo "<br/>";
	?>
	<form method="post">
		<input type="hidden" name="form_anfrage_aktiv" value="1"/>
		<input type="hidden" name="welches_datum_loeschen" value="-1"/>
		<input type="hidden" name="papierkorb_geklickt" value="0"/>
	</form>
	<?php
}
//sowieso alles nur wenn Zugang entsperrt:
if($_SESSION['mysql_zugang_sperren'] != 1) {

if($anzahl_zusagen>=$_SESSION['mysql_anzahl_zusagen']){ ?>
	<div style="width: 900px; font-size: 0.8em;	line-height: 150%;	text-align: left;	color: #000; border-bottom: 1px solid #000000; " />
		<p><b>Neue Anfrage erstellen:</b></p>
		<p>Sie haben die maximale Anzahl Zusagen erhalten. Mehr Zusagen sind nicht möglich.</p>
		<p></p>
		<p></p>
	</div>
	<form method="post">
		<input type="hidden" name="form_anfrage_aktiv" value="1"/>
		<input type="hidden" name="welches_datum_loeschen" value="-1"/>
		<input type="hidden" name="papierkorb_geklickt" value="0"/>
	</form>
<?php
}
?>	
<?php
if($anzahl_zusagen<$_SESSION['mysql_anzahl_zusagen']){
?>	
<table style="position:relative; top:0px; z-index:99;">
	<tr>
<form method="post">
<td style="border-right: 1px solid #000000; border-bottom: 1px solid #000000; width:550px" valign="top">
<div id="content_left" style="padding-bottom: 20px;">
				
<p><b>Neue Anfrage erstellen:</b></p>

	<table style="font-size: 1em;">
	<tr>
		<td style="width:110px" valign="top">
			<p><b>Prüfungsfach:</b></p>
			<p><b>Art der Prüfung:</b></p>
		</td>
		<td style="width:310px;" valign="top">
			<p>
				<select name="fach_wahl" size="1" onchange="document.forms[0].form_anfrage_aktiv.value= 2; document.forms[0].submit()">
				<option value="0">---</option>
				<?php for($i=0;$i<count($fach_DATA);$i++){ ?>
					<option value="<?php echo $fach_DATA[$i][0]; ?>" <?php if($_POST['fach_wahl'] == $fach_DATA[$i][0]){ echo "selected"; } ?> ><?php echo $fach_DATA[$i][1]; ?></option>
				<?php } ?>
				</select>
			</p>
			<p>
				<!-- onchange="document.forms[0].form_anfrage_aktiv.value= 2; document.forms[0].submit()" -->
				<input type="radio" name="pruefungs_art_experte" value="0" <?php if($_POST['pruefungs_art_experte'] == 0){ echo "checked"; }?>  onclick="document.forms[0].form_anfrage_aktiv.value= 2; document.forms[0].submit()" >&nbsp;schriftlich und mündlich&nbsp;&nbsp;
				<input type="radio" name="pruefungs_art_experte" value="1" <?php if($_POST['pruefungs_art_experte'] == 1){ echo "checked"; }?>  onclick="document.forms[0].form_anfrage_aktiv.value= 2; document.forms[0].submit()" >&nbsp;schriftlich<br/>
				<input type="radio" name="pruefungs_art_experte" value="2" <?php if($_POST['pruefungs_art_experte'] == 2){ echo "checked"; }?>  onclick="document.forms[0].form_anfrage_aktiv.value= 2; document.forms[0].submit()" >&nbsp;mündlich&nbsp;&nbsp;
			</p>
		</td>

	</tr>
	</table>
	<?php if($_POST['pruefungs_art_experte'] == 0 || $_POST['pruefungs_art_experte'] == 2){ ?>
	<p><b>mögliche Termine der mündlichen Prüfung:</b></p>
	
	
	<table style="font-size: 1em;">
	<tr>
		<td style="width:550px;" valign="top" >
			<?php for ($anz_dat = 0; $anz_dat < $_SESSION['anzahl_daten']; $anz_dat++) {  ?>
		<p>
			<div style='text-align:left;'>
			<b><?php echo intval($anz_dat+1); ?>).</b> Datum:
			<select name="<?php echo 'termin_von_tag_wahl_'.$anz_dat; ?>" onchange="" size="1">
			<?php for($i=1;$i<=31;$i++){ ?>
			<option value="<?php echo $i;?>" <?php if($_POST['termin_von_tag_wahl_'.$anz_dat] == $i){ echo "selected"; } ?> ><?php echo $i;?></option>
			<?php } ?>
			</select>
			<select name="<?php echo 'termin_von_monat_wahl_'.$anz_dat; ?>" onchange="" size="1">
			<?php $monat = array("Jan","Feb", "Mar", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez");
			for($i=0;$i<=11;$i++){ ?>
			<option value="<?php echo $monat[$i];?>" <?php if($_POST['termin_von_monat_wahl_'.$anz_dat] == $monat[$i]){ echo "selected"; } ?> ><?php echo $monat[$i];?></option>
			<?php } ?>
			</select>
			<select name="<?php echo 'termin_von_jahr_wahl_'.$anz_dat; ?>" onchange="" size="1">
			<?php $jahr = array(2015,2016,2017,2018,2019, 2020);
			for($i=0;$i<count($jahr);$i++){ ?>
			<option value="<?php echo $jahr[$i];?>" <?php if($_POST['termin_von_jahr_wahl_'.$anz_dat] == $jahr[$i]){ echo "selected"; } ?> ><?php echo $jahr[$i];?></option>
			<?php } ?>
			</select>
			, Zeit:
			<select name="<?php echo 'termin_von_stunde_wahl_'.$anz_dat; ?>" onchange="" size="1">
			<?php for($i=0;$i<24;$i++){ ?>
			<option value="<?php echo $i;?>" <?php if($_POST['termin_von_stunde_wahl_'.$anz_dat] == $i){ echo "selected"; } ?> ><?php if($i<10){ echo "0";} echo $i;?></option>
			<?php } ?>
			</select>
			<select name="<?php echo 'termin_von_minute_wahl_'.$anz_dat; ?>" onchange="" size="1">
			<?php for($i=0;$i<60;$i=$i+5 ){ ?>
			<option value="<?php echo $i;?>" <?php if($_POST['termin_von_minute_wahl_'.$anz_dat] == $i){ echo "selected"; } ?> ><?php if($i<10){ echo "0";} echo $i;?></option>
			<?php } ?>
			</select>
			-
			<select name="<?php echo 'termin_bis_stunde_wahl_'.$anz_dat; ?>" onchange="" size="1">
			<?php for($i=0;$i<24;$i++){ ?>
			<option value="<?php echo $i;?>" <?php if($_POST['termin_bis_stunde_wahl_'.$anz_dat] == $i){ echo "selected"; } ?> ><?php if($i<10){ echo "0";} echo $i;?></option>
			<?php } ?>
			</select>
			<select name="<?php echo 'termin_bis_minute_wahl_'.$anz_dat; ?>" onchange="" size="1">
			<?php for($i=0;$i<60;$i=$i+5){ ?>
			<option value="<?php echo $i;?>" <?php if($_POST['termin_bis_minute_wahl_'.$anz_dat] == $i){ echo "selected"; } ?> ><?php if($i<10){ echo "0";} echo $i;?></option>
			<?php } ?>
			</select>
			<div style='float:right; position:relative; top:-1px; right:12px;'>
				<input type="button" name="dasdf<?php echo $anz_dat; ?>" value=" - löschen " onclick="document.forms[0].form_anfrage_aktiv.value= <?php echo intval(2000+intval($anz_dat)); ?>; document.forms[0].submit()" />
			</div>
			</div>
		</p>
		<?php } ?>
		</td>
	</tr>
	</table>
	
	
	<input type="button" name="asdf" value=" + Termin hinzufügen " onclick="document.forms[0].form_anfrage_aktiv.value= 101; document.forms[0].submit()" />
	<br/><br/>
	
	<?php } ?>
	<?php if($_POST['pruefungs_art_experte'] == 0 || $_POST['pruefungs_art_experte'] == 1){ 	?>
	<p><b>Begutachtung der schriftlichen Prüfung:</b></p>
	Bei den kommenden Maturaprüfungen findet der Begutachtungszeitraum im angegebenen Zeitraum statt.<br/> 
	Bitte nur in Ausnahmefällen Änderungen vornehmen.
	<table style="font-size: 1em;">
	<tr>
		<td style="width:60px" valign="top">
			<p>Von:</p>
			<p>Bis:</p>
		</td>
		<td style="width:390px;" valign="top" >
		<p>
			Datum:
			<select name="korrektur_von_tag_wahl" onchange="" size="1">
			<?php for($i=1;$i<=31;$i++){ ?>
			<option value="<?php echo $i;?>" <?php if($_POST['korrektur_von_tag_wahl'] == $i){ echo "selected"; } ?> ><?php echo $i;?></option>
			<?php } ?>
			</select>
			<select name="korrektur_von_monat_wahl" onchange="" size="1">
			<?php $monat = array("Jan","Feb", "Mar", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez");
			for($i=0;$i<=11;$i++){ ?>
			<option value="<?php echo $monat[$i];?>" <?php if($_POST['korrektur_von_monat_wahl'] == $monat[$i]){ echo "selected"; } ?> ><?php echo $monat[$i];?></option>
			<?php } ?>
			</select>
			<select name="korrektur_von_jahr_wahl" onchange="" size="1">
			<?php $jahr = array(2015,2016,2017,2018,2019, 2020);
			for($i=0;$i<count($jahr);$i++){ ?>
			<option value="<?php echo $jahr[$i];?>" <?php if($_POST['korrektur_von_jahr_wahl'] == $jahr[$i]){ echo "selected"; } ?> ><?php echo $jahr[$i];?></option>
			<?php } ?>
			</select>
		</p>
		<p>
			Datum:
			<select name="korrektur_bis_tag_wahl" onchange="" size="1">
			<?php for($i=1;$i<=31;$i++){ ?>
			<option value="<?php echo $i;?>" <?php if($_POST['korrektur_bis_tag_wahl'] == $i){ echo "selected"; } ?> ><?php echo $i;?></option>
			<?php } ?>
			</select>
			<select name="korrektur_bis_monat_wahl" onchange="" size="1">
			<?php $monat = array("Jan","Feb", "Mar", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez");
			for($i=0;$i<=11;$i++){ ?>
			<option value="<?php echo $monat[$i];?>" <?php if($_POST['korrektur_bis_monat_wahl'] == $monat[$i]){ echo "selected"; } ?> ><?php echo $monat[$i];?></option>
			<?php } ?>
			</select>
			<select name="korrektur_bis_jahr_wahl" onchange="" size="1">
			<?php $jahr = array(2015,2016,2017,2018,2019, 2020);
			for($i=0;$i<count($jahr);$i++){ ?>
			<option value="<?php echo $jahr[$i];?>" <?php if($_POST['korrektur_bis_jahr_wahl'] == $jahr[$i]){ echo "selected"; } ?> ><?php echo $jahr[$i];?></option>
			<?php } ?>
			</select>
		</p>
		</td>
	</tr>
	</table>
	<?php } ?>
</div>
</td>

<td style="width:350px; border-bottom: 1px solid #000000; " valign="top">
<div id="content_right"  style="padding-bottom: 20px;">
	
	<p><b> </b></p>
	<p><b> </b></p>
	<p><b> </b></p>
	<table style="font-size: 1em;">
	<tr>
		<td style="width:90px" valign="top">
			Klassenkürzel:
		</td>
		<td style="width:40px;" valign="top">
			<input type="input" maxlength="4" autocomplete="off" name="klassen_kuerzel" style="width: 40px" 
			value="<?php if($_POST['klassen_kuerzel']){ echo $_POST['klassen_kuerzel']; } ?>" size="20">
		</td>
	</tr>
	</table>	
<?php 	$error_string=""; 
if($formular_error[0] == 1) {	$error_string .= "Bitte Prüfungsfach wählen! "; }
if($formular_error[1] == 1) {	$error_string .= "Bitte einen Experten/eine Expertin auswählen! "; }
if($formular_error[2] == 1) {	$error_string .= "<br/>Ungültige Zeitangabe bei einem möglichen Termin der mündlichen Prüfung! "; }
if($formular_error[3] == 1) {	$error_string .= "<br/>Schriftliche Prüfung: Das erstgenannte Datum muss vor dem zweiten Datum liegen. "; }
if(strlen($error_string)>0){ 	?>		<p><font color="#FF0000"><?php echo $error_string; ?></font></p> 	<?php	} ?>

<input type="hidden" name="form_anfrage_aktiv" value="1"/>
<input type="hidden" name="papierkorb_geklickt" value="0"/>
<p><div align="right" style="padding-right: 20px"><input type="image" name="submit" src="assets/button_anfrage_abschicken.png"></div></p>
</div>
</td>
</form>

	</tr>
</table>
<?php
}

//zugang gesperrt klammer zu:

}
?>