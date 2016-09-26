<?php
	
?>

<div id="header_bg">
		<div id="header_content"  style="padding-top: 15px;">
			<div style="float:left;">
			<a style="text-decoration: none;" href="./logout.php" target="_self"><img style="border: 0 none;" src="assets/logo.png"/></a> 
			</div>
			<div align="right" style="color:#FFF; font-size: 0.5em; float:right;">
				<?php echo $_SESSION['mysql_name'];?><br/>
				<a style="" href="./logout.php" target="_self">>>ausloggen</a>
			</div>
		</div>
</div>
