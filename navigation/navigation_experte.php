<?php

?>
	<div id="nav-menu">
		<div style="width:900px">
		<ul>
			<li <?php if($rubrik == 0){ echo "class=\"active\""; }?>><a href="./experte.php?rubrik=0">Anfragen</a></li>
			<li <?php if($rubrik == 1){ echo "class=\"active\""; }?>><a href="./experte.php?rubrik=1">Profil</a></li>
			<li <?php if($rubrik == 2){ echo "class=\"active\""; }?>><a href="./experte.php?rubrik=2">Liste aller Schulen</a></li>
			<li <?php if($rubrik == 3){ echo "class=\"active\""; }?>><a href="./experte.php?rubrik=3">Liste aller Experten</a></li>
		</ul>
		</div>
	</div> 