<?php
	

?>
<table style="position:relative; top:0px; z-index:99;">
<tr>
<td style="border-right: 1px solid #000000; width:450px" valign="top">
<div style="padding-top: 20px;	padding-right: 0px; 	padding-bottom: 0px;">
<form method="post">				
<p><b>Mail an alle Schulen schicken:</b></p>

<p>Betreff:<br/><input type="input" name="schule_mail_betreff" style="width: 420px" value="<?php if(isset($_SESSION['mysql_schule_mail_betreff'] )){ echo $_SESSION['mysql_schule_mail_betreff'] ; }?>"></p>

<p>Nachricht:<br/><textarea name="schule_mail_nachricht" cols="50" rows="15" style="width: 420px" /><?php if(isset($_SESSION['mysql_schule_mail_nachricht'] )){ echo $_SESSION['mysql_schule_mail_nachricht'] ; }?>
</textarea> </p>

	<input type="hidden" name="form__mail_verschicken" value="0"/>
	<p><div align="right" style="padding-right: 25px">
		<img style="cursor:pointer; border: 0 none;" src="assets/button_mail_nur.png" onclick="document.forms[0].form__mail_verschicken.value= 1; document.forms[0].submit()" /> 
		<img style="cursor:pointer; border: 0 none;" src="assets/button_mail_und.png" onclick="document.forms[0].form__mail_verschicken.value= 2; document.forms[0].submit()" /> 
	</div></p>

</div>
</form>

</td>

<td style="width:450px" valign="top">
<div style="padding-top: 20px;	padding-left: 20px; 	padding-bottom: 0px;">
<form method="post">				
<p><b>Mail an alle Experten schicken:</b></p>

<p>Betreff:<br/><input type="input" name="experte_mail_betreff" style="width: 420px" value="<?php if(isset($_SESSION['mysql_experte_mail_betreff'] )){ echo $_SESSION['mysql_experte_mail_betreff'] ; }?>"></p>

<p>Nachricht:<br/><textarea name="experte_mail_nachricht" cols="50" rows="15" style="width: 420px"/><?php if(isset($_SESSION['mysql_experte_mail_nachricht'] )){ echo $_SESSION['mysql_experte_mail_nachricht'] ; }?>
</textarea> </p>

	<input type="hidden" name="form__mail_verschicken" value="0"/>
	<p><div align="right" style="padding-right: 10px">
		<img style="cursor:pointer; border: 0 none;" src="assets/button_mail_nur.png" onclick="document.forms[1].form__mail_verschicken.value= 3; document.forms[1].submit()" /> 
		<img style="cursor:pointer; border: 0 none;" src="assets/button_mail_und.png" onclick="document.forms[1].form__mail_verschicken.value= 4; document.forms[1].submit()" /> 
	</div></p>

</div>
</form>
</div>
</td>


</tr>
</table>
