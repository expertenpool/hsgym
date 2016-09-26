<?php
?>
<div id="content_left">
				
<form method="post">
<p>Sie verfügen über ein <b>Adminprofil</b>,<br/>dann loggen Sie sich hier ein:</p>
<p>
	<table style="font-size: 1em;">
	<tr>
		<td style="width:70px" valign="top">
			Email:<br/>
			Passwort: 
		</td>
		<td style="width:230px;" valign="top">
			<input type="input" autocomplete="off" name="email_admin" style="width: 220px" 
			value="<?php
			if(isset($_COOKIE['email_admin'])){	echo $_COOKIE['email_admin'];} 
			if(isset($_POST['email_admin'])){	echo $_POST['email_admin'];} 
			?>" size="20"><br/>
			<input type="password" autocomplete="off" name="passwort_admin" style="width: 220px" 
			value="<?php 
			if(isset($_COOKIE['passwort_admin'])){	echo $_COOKIE['passwort_admin'];} 
			if(isset($_POST['passwort_admin'])){	echo $_POST['passwort_admin'];} 
			?>" size="20">
		</td>
		<td style="width:70px" valign="top">
			<input type="hidden" name="form_aktiv" value="1"/>
			<input type="image" name="submit" src="assets/button_einloggen.png">
		</td>
	</tr>
</table>
</p>

<p><input type="checkbox" name="login_speichern_admin" value="login_speichern_admin" <?php if(isset($_COOKIE['email_admin']) && isset($_COOKIE['passwort_admin'])){ echo "checked"; }?>>
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
?>
</form>	
</div>
