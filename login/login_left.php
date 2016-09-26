<?php
?>
<div id="content_left" style="padding-right: 20px;">

	<?php if($_SESSION['mysql_zugang_sperren'] == 1){ ?>	
		<p><b>Der Expertenpool ist momentan gesperrt.</b></p>
		<br/>
		Falls Sie bereits über ein Konto verfügen, können Sie sich weiterhin einloggen und Ihre Daten einsehen.<br/>
		<br/>
		Es können jedoch keine Anfragen erstellt oder Zusagen gemacht werden, bis der Admin den Expertenpool wieder reaktiviert.<br/>
		<br/>
		Falls Sie noch über kein Konto verfügen, dann warten Sie bitte, bis Sie eine Einladung vom Admin bekommen.
	<?php } ?>
	
	<?php if($_SESSION['mysql_zugang_sperren'] != 1){ ?>	

<form method="post">
<p>Noch nicht registriert?</p>

<p>
	<table style="font-size: 1em;">
	<tr>
		<td style="width:70px" valign="top">
			Typ:<br/>
			Passwort:
		</td>
		<td style="width:230px;" valign="top">
			<input type="radio" name="profil_typ" value="schule" checked>&nbsp;Schule&nbsp;&nbsp;&nbsp;<input type="radio" name="profil_typ" value="experte">&nbsp;Expertin/Experte<br/>
			<input type="password" autocomplete="off" name="passwort_allgemein" value="" style="width: 220px">
		</td>
		<td style="width:70px" valign="top">
			<input type="hidden" name="form1_aktiv" value="1"/>
			<input type="image" name="submit" src="assets/button_profilanmeldung.png">
		</td>
	</tr>
</table>
</p>

<!--<p>Typ:</p> 
<p>
<input type="radio" name="profil_typ" value="schule" checked>Schule<br/>
<input type="radio" name="profil_typ" value="experte">Experte<br/>
</p>

<p>Passwort: <input type="password" name="passwort_allgemein" size="20"></p>
-->
<?php
	if($login_error == 1){
	?>
		<p><font color="#FF0000">Passwort falsch!</font></p>
	<?php
	}
	if($login_error == 4){
	?>
		<p><font color="#FF0000">Bitte Passwort eingeben!</font></p>
	<?php
	}
?>

<!--<p><input type="image" name="submit" src="assets/button_profilanmeldung.png"></p>
-->

</form>
<?php } ?>

<!-- LOGOS:-->

	<br/>
	<br/>
	<?php if($_SESSION['mysql_zugang_sperren'] != 1){ ?>
	<br/>
	<br/>
	<?php } ?>
<p>
<a style="text-decoration: none;" href="http://slk.tam.ch/" target="_blank"><img style="border: 0 none;" src="assets/slk.png"/></a> 
</p>
<p>
<a style="text-decoration: none;" href="http://www.uzh.ch" target="_blank"><img style="border: 0 none;" src="assets/uniz.png"/></a> 
</p>
<p>
<a style="text-decoration: none;" href="http://www.ethz.ch" target="_blank"><img style="border: 0 none;" src="assets/eth.png"/></a> 
</p>
<p>
<a style="text-decoration: none;" href="https://www.zhaw.ch" target="_blank"><img style="border: 0 none;" src="assets/zfh.png"/></a> 
</p>


</div>
