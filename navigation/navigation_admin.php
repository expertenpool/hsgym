<?php

?>
	<div id="nav-menu">
		<div style="width:900px">
		<ul>
			<li <?php if($rubrik == 0){ echo "class=\"active\""; }?>><a href="./admin_index.php?rubrik=0">Einstellungen</a></li>
			<li <?php if($rubrik == 1){ echo "class=\"active\""; }?>><a href="./admin_index.php?rubrik=1">Mail verschicken</a></li>
			<li <?php if($rubrik == 2){ echo "class=\"active\""; }?>><a href="./admin_index.php?rubrik=2">Liste aller Schulen</a></li>
			<li <?php if($rubrik == 3){ echo "class=\"active\""; }?>><a href="./admin_index.php?rubrik=3">Liste aller Experten</a></li>
			<li <?php if($rubrik == 4){ echo "class=\"active\""; }?>><a href="./admin_index.php?rubrik=4">Liste aller Anfragen</a></li>
		</ul>
		</div>
	</div> 