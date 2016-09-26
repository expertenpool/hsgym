<?php
?>
<td style="width:450px" valign="top">
<div id="content_right">
	
<form method="post">
	
<p>
	<table style="width:390px; font-size: 1em;">
	<tr>
		<td style="width:75px" valign="top">
			<img style="border: 0 none;" src="assets/schule_icon.jpg"/>
		</td>
		<td style="width:290px;" valign="top">
			Sie verfügen bereits über ein <b>Schulprofil</b>,<br/>dann loggen Sie sich hier ein:
		</td>
	</tr>
	</table>
<br/>
	<table style="width:390px; font-size: 1em;">
	<tr>
		<td style="width:90px" valign="top">
			Email:<br/>
			Passwort: 
		</td>
		<td style="width:190px;" valign="top">
			<input type="input" autocomplete="off" name="email_schule" style="width: 180px" 
			value="<?php
			if(isset($_COOKIE['email_schule'])){	echo $_COOKIE['email_schule'];} 
			if(isset($_POST['email_schule'])){	echo $_POST['email_schule'];} 
			?>" size="20"><br/>
			<input type="password" autocomplete="off" name="passwort_schule" style="width: 180px" 
			value="<?php 
			if(isset($_COOKIE['passwort_schule'])){	echo $_COOKIE['passwort_schule'];} 
			if(isset($_POST['passwort_schule'])){	echo $_POST['passwort_schule'];} 
			?>" size="20">
		</td>
		<td style="width:90px" valign="top">
			<input type="hidden" name="form2_aktiv" value="1"/>
			<input type="image" name="submit" src="assets/button_einloggen.png">
		</td>
	</tr>
	</table>
</p>

<a style="text-decoration:none;" href="./pass_forget_schule.php"><font color="black">Passwort vergessen? >></font></a> 
<br/>
<p><input type="checkbox" name="login_speichern_schule" value="login_speichern_schule" <?php if(isset($_COOKIE['email_schule']) && isset($_COOKIE['passwort_schule'])){ echo "checked"; }?>>
	Login-Daten für den nächsten Besuch speichern:</p> 
<?php
	if($login_error == 2){
	?>
		<p><font color="#FF0000">Email und/oder Passwort falsch!</font></p>
	<?php
	}
	if($login_error == 5){
	?>
		<p><font color="#FF0000">Bitte E-Mail eingeben!</font></p>
	<?php
	}
	if($login_error == 6){
	?>
		<p><font color="#FF0000">Bitte Passwort eingeben!</font></p>
	<?php
	}
	if($login_error == 7){
	?>
		<p><font color="#FF0000">Bitte Email und Passwort eingeben!</font></p>
	<?php
	}
	if($login_error == 20){
	?>
		<p><font color="#FF0000">Konto wurde noch nicht aktiviert!</font></p>
	<?php
	}
?>
</form>	

<hr/>

<br/>

<form method="post">
<p>
	<table style="width:390px; font-size: 1em;">
	<tr>
		<td style="width:75px" valign="top">
			<img style="border: 0 none;" src="assets/experte_icon.jpg"/>
		</td>
		<td style="width:290px;" valign="top">
			Sie verfügen bereits über ein <b>Expertenprofil</b>,<br/>dann loggen Sie sich hier ein:
		</td>
	</tr>
	</table>
<br/>
	<table style="width:390px; font-size: 1em;">
	<tr>
		<td style="width:90px" valign="top">
			Email:<br/>
			Passwort: 
		</td>
		<td style="width:190px;" valign="top">
			<input type="input" autocomplete="off" name="email_experte" style="width: 180px" 
			value="<?php 
			if(isset($_COOKIE['email_experte'])){	echo $_COOKIE['email_experte'];} 
			if(isset($_POST['email_experte'])){	echo $_POST['email_experte'];} 
			?>" size="20"><br/>
			<input type="password" autocomplete="off" name="passwort_experte" style="width: 180px" 
			value="<?php 
			if(isset($_COOKIE['passwort_experte'])){	echo $_COOKIE['passwort_experte'];} 
			if(isset($_POST['passwort_experte'])){	echo $_POST['passwort_experte'];} 
			?>" size="20">
		</td>
		<td style="width:90px" valign="top">
			<input type="hidden" name="form3_aktiv" value="1"/>
			<input type="image" name="submit" src="assets/button_einloggen.png">
		</td>
	</tr>
</table>
</p>
<p>
</p>

<a style="text-decoration:none;" href="./pass_forget_experte.php"><font color="black">Passwort vergessen? >></font></a> 
<br/>
<p><input type="checkbox" name="login_speichern_experte" value="login_speichern_experte" <?php if(isset($_COOKIE['email_experte']) && isset($_COOKIE['passwort_experte'])){ echo "checked"; }?>>
	Login-Daten für den nächsten Besuch speichern:</p> 
<?php
	if($login_error == 3){
	?>
		<p><font color="#FF0000">Email und/oder Passwort falsch!</font></p>
	<?php
	}
	if($login_error == 8){
	?>
		<p><font color="#FF0000">Bitte E-Mail eingeben!</font></p>
	<?php
	}
	if($login_error == 9){
	?>
		<p><font color="#FF0000">Bitte Passwort eingeben!</font></p>
	<?php
	}
	if($login_error == 10){
	?>
		<p><font color="#FF0000">Bitte Email und Passwort eingeben!</font></p>
	<?php
	}
	if($login_error == 21){
	?>
		<p><font color="#FF0000">Konto wurde noch nicht aktiviert!</font></p>
	<?php
	}
?>
</form>	

</div>
</td>