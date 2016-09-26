<?php 

if(strlen($_SESSION['info_zeile'])) {
	?><div id="info_zeile"><p><?php
		echo $_SESSION['info_zeile'];
		if (strlen($_SESSION['info_zeile_email'])) {
			?>
			<a href="mailto:<?php echo $_SESSION['info_zeile_email'];?>" target="_self"><img style="border: 0 none;" src="assets/icon_brief.gif"/></a>
			<?php
			$_SESSION['info_zeile_email'] = "";
		}
	?></p></div><?php
}

//Infozeile-Variable immer gleich löschen:
$_SESSION['info_zeile'] = "";

?>