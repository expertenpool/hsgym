<?php
	$tabellen_spalten_namen = array("Prüfungsfach", "Art der Prüfung", "Termin mündlich", "Kontrollzeitraum", "Gerichtet an", "Zugesagt","");
	$tabellen_spalten_anzahl = count($tabellen_spalten_namen);
?>
<div id="anchor_tabelle2"></div>
<table style="position:relative; top:0px; z-index:99;">
	<tr>
		<td style="width:900px" valign="top">
			<div id="content_left" style="padding-top: 0px; padding-bottom: 15px; float:left;">
				<p><b>Anfragen an einzelne Experten/Expertinnen:</b>&nbsp;&nbsp;&nbsp;&nbsp;<img style="position:relative; top:3px; border: 0 none;" src="assets/experte_singular.jpg"/></p>
			</div>
			<div align="right" style="padding-top: 0px; padding-bottom: 15px; color:#FFF; font-size: 1em; float:right;">
				<p><a style="" href="#anchor_tabelle1">>>Anfragen an alle Experten/Expertinnen</a></p>
			</div>
		</td>
	</tr>
</table>

<table style="position:relative; top:0px; z-index:99; border-spacing:0pt;">
	<!--Tabellen-KOPF-->
	<tr>
		<?php
			$td_style[0] = "padding:10px; background: #DDD; border-top: 1px solid #000000; border-left: 1px solid #000000; border-spacing:0pt; width:120px;";
			$td_style[1] = "padding:10px; background: #DDD; border-top: 1px solid #000000; border-left: 1px solid #000000; border-spacing:0pt; width:180px;";
			$td_style[2] = "padding:10px; background: #DDD; border-top: 1px solid #000000; border-left: 1px solid #000000; border-spacing:0pt; width:180px;";
			$td_style[3] = "padding:10px; background: #DDD; border-top: 1px solid #000000; border-left: 1px solid #000000; border-spacing:0pt; width:140px;";
			$td_style[4] = "padding:10px; background: #DDD; border-top: 1px solid #000000; border-left: 1px solid #000000; border-spacing:0pt; width:170px;";
			$td_style[5] = "padding:10px; background: #DDD; border-top: 1px solid #000000; border-left: 1px solid #000000; border-spacing:0pt; width:60px;";
			$td_style[6] = "padding:10px; background: #DDD; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; border-spacing:0pt; width:40px;";
			//
			for($i2=0;$i2<7;$i2++){ 
		?>
			<td style="<?php echo $td_style[$i2]; ?>" valign="top">
				<div style="float:left;"><b><?php echo $tabellen_spalten_namen[$i2];?></b></div>
			</td>
		<?php
			}
		?>
	</tr>
	<!--Tabellen-SorterZeile:-->
	<tr>
		<?php 
			$td_style[0] = "padding-top:4px; padding-bottom:0px; background: #EEE; border-top: 1px solid #000000; border-left: 1px solid #000000; border-spacing:0pt; width:120px;";
			$td_style[1] = "padding-top:4px; padding-bottom:0px; background: #EEE; border-top: 1px solid #000000; border-left: 1px solid #000000; border-spacing:0pt; width:180px;";
			$td_style[2] = "padding-top:4px; padding-bottom:0px; background: #EEE; border-top: 1px solid #000000; border-left: 1px solid #000000; border-spacing:0pt; width:180px;";
			$td_style[3] = "padding-top:4px; padding-bottom:0px; background: #EEE; border-top: 1px solid #000000; border-left: 1px solid #000000; border-spacing:0pt; width:140px;";
			$td_style[4] = "padding-top:4px; padding-bottom:0px; background: #EEE; border-top: 1px solid #000000; border-left: 1px solid #000000; border-spacing:0pt; width:170px;";
			$td_style[5] = "padding-top:4px; padding-bottom:0px; background: #EEE; border-top: 1px solid #000000; border-left: 1px solid #000000; border-spacing:0pt; width:60px;";
			$td_style[6] = "padding-top:4px; padding-bottom:0px; background: #EEE; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; border-spacing:0pt; width:40px;";
			//
			for($i2=0;$i2<7;$i2++){
		?>
		<td align="center" style="<?php echo $td_style[$i2]; ?>" valign="top">
			<div ><?php if($i2<6){?>
				<a style="text-decoration: none;" href="./schule.php?rubrik=0&sort=<?php echo 10+$i2*2; ?>#anchor_tabelle2" target="_self"><img style="border: 0 none;" src="<?php if($sort ==(10+$i2*2)){echo "assets/sorter_oben_ddd.png"; } else {echo "assets/sorter_oben_aaa.png"; }?>"/></a> 
				<a style="text-decoration: none;" href="./schule.php?rubrik=0&sort=<?php echo 10+$i2*2+1; ?>#anchor_tabelle2" target="_self"><img style="border: 0 none;" src="<?php if($sort ==(10+$i2*2+1)){echo "assets/sorter_unten_ddd.png"; } else {echo "assets/sorter_unten_aaa.png"; }?>"/></a> 
			<?php } ?></div>
		</td>
		<?php }?>
	</tr>
	<!--Tabellen-BODY-->
	<?php if(count($tabellen_zeilen_DATA2)>0) { ?>
	<?php for($i=0;$i<$tabellen_zeilen_anzahl2;$i++){ ?>
	<tr>
		<?php 
			$td_style[0] = "padding:10px; padding-top: 2px; border-top:1px solid #000000; border-left:1px solid #000000; border-spacing:0pt; width:120px;";
			$td_style[1] = "padding:10px; padding-top: 2px; border-top:1px solid #000000; border-left:1px solid #000000; border-spacing:0pt; width:180px;";
			$td_style[2] = "padding:10px; padding-top: 2px; padding-bottom: 2px; border-top:1px solid #000000; border-left:1px solid #000000; border-spacing:0pt; width:180px;";
			$td_style[3] = "padding:10px; padding-top: 2px; padding-bottom: 2px; border-top:1px solid #000000; border-left:1px solid #000000; border-spacing:0pt; width:140px;";
			$td_style[4] = "padding:10px; padding-top: 2px; padding-bottom: 2px; border-top:1px solid #000000; border-left:1px solid #000000; border-spacing:0pt; width:170px;";
			$td_style[5] = "padding:10px; padding-top: 2px; border-top:1px solid #000000; border-left:1px solid #000000; border-spacing:0pt; width:60px;";
			$td_style[6] = "padding:10px; padding-top: 2px; border-top:1px solid #000000; border-left:1px solid #000000; border-right: 1px solid #000000; border-spacing:0pt; width:40px;";
			//
			for ($i2 = 0; $i2 < 7; $i2++) { 
				if (isset($zusage_ID[$tabellen_zeilen_DATA2[$i][4]])){ 
					$td_style[$i2] .= "background: #CFC;";
				}			
				if ($i == ($tabellen_zeilen_anzahl2 - 1)) { 
					$td_style[$i2] .= "border-bottom: 1px solid #000000;";
				}
		?>
		<td style="<?php echo $td_style[$i2]; ?>" valign="top">
			<?php if($i2 == 0){?> 
				<p><?php echo $tabellen_zeilen_DATA2[$i][$i2]; ?></p>
			<?php }; ?> 
			<?php if($i2 == 1){?> 
				<p><?php echo $tabellen_zeilen_DATA2[$i][$i2]; ?></p>
			<?php }; ?> 
			<?php if($i2 == 2){?> 
				<p><?php 
					echo "<div style='font-size: 0.8em; text-align:left'>";
					$tempo = explode(";", $tabellen_zeilen_DATA2[$i][$i2]);
					if($tempo[0]){
					if ($tempo[3] < 10) { $tempo[3] = "0".$tempo[3]; }
					if ($tempo[4] < 10) { $tempo[4] = "0".$tempo[4]; }
					if ($tempo[8] < 10) { $tempo[8] = "0".$tempo[8]; }
					if ($tempo[9] < 10) { $tempo[9] = "0".$tempo[9]; }
					echo "Von:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$tempo[0].".".$tempo[1]." ".$tempo[2].",&nbsp;&nbsp;&nbsp;".$tempo[3].":".$tempo[4]."<br/>"; 
					echo "Bis:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$tempo[5].".".$tempo[6]." ".$tempo[7].",&nbsp;&nbsp;&nbsp;".$tempo[8].":".$tempo[9]; 
					}
					echo "</div>";
				?></p>
			<?php }; ?>
			<?php if($i2 == 3){?> 
				<p><?php 
					echo "<div style='font-size: 0.8em; text-align:left'>";
					$tempo = explode(";", $tabellen_zeilen_DATA2[$i][$i2]);
					if($tempo[0]){
					echo "Von:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$tempo[0].".".$tempo[1]." ".$tempo[2]."<br/>"; 
					echo "Bis:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$tempo[3].".".$tempo[4]." ".$tempo[5]; 
					}
					echo "</div>";
				?></p>
			<?php }; ?>
			<?php if($i2 == 4 ){?> 
			<p>
				<?php echo $experte_DATA_NAME[$tabellen_zeilen_DATA2[$i][5]]; ?>
				&nbsp;&nbsp;<a href="mailto:<?php echo $experte_DATA_EMAIL[$tabellen_zeilen_DATA2[$i][5]];?>" target="_self"><img style="border: 0 none;" src="assets/icon_brief.gif"/></a>
			</p>
			<?php }; ?> 
			<?php if($i2 == 5 ){?> 
			<p>
				<?php if($zusage_ID[$tabellen_zeilen_DATA2[$i][4]]) { echo "Ja";} ?>
			</p>
			<?php }; ?> 
			<?php if($i2 == 6){?> 
				<p>
					<?php if($zusage_ID[$tabellen_zeilen_DATA2[$i][4]]) { ?>
							<img style="cursor:pointer; border: 0 none;" src="assets/papierkorb.png" onclick="document.forms[0].form_anfrage_aktiv.value= 3; document.forms[0].papierkorb_geklickt.value='<?php echo $tabellen_zeilen_DATA2[$i][4]."-".$zusage_ID[$tabellen_zeilen_DATA2[$i][4]]; ?>'; document.forms[0].submit()" /> 
					<?php } else { ?>
							<img style="cursor:pointer; border: 0 none;" src="assets/papierkorb.png" onclick="document.forms[0].form_anfrage_aktiv.value= 3; document.forms[0].papierkorb_geklickt.value='<?php echo $tabellen_zeilen_DATA2[$i][4]."-0"; ?>'; document.forms[0].submit()" /> 
					<?php } ?>
				</p>
			<?php }; ?> 
		</td>
		<?php }?>
	</tr>
	<?php }	?>
	<?php }	?>
	
	<!-- Falls keine Anfragen gestellt Tab 1 -->
	<?php if(count($tabellen_zeilen_DATA2)==0) { ?>
	</table>
	<table style="position:relative; top:0px; z-index:99; border-spacing:0pt;">
	<tr>
		<td style="padding:10px; padding-top: 10px; border:1px solid #000000; border-spacing:0pt; width:900px;">
			<?php //Version wenn Zugang entsperrt:
				if($_SESSION['mysql_zugang_sperren'] != 1) {?>
					<i>Noch keine Anfragen erstellt.</i>
			<?php } ?>
			<?php //Version wenn Zugang GESPERRT:
				if($_SESSION['mysql_zugang_sperren'] == 1) {?>
					<i>Keine zugesagten Anfragen vorhanden.</i>
			<?php } ?>
		</td>
	</tr>
	<?php }	?>
	
	</table>
<br/>