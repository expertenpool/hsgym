<?php
	$tabellen_spalten_namen = array("Name der Schule", "Prüfungsfach", "Typ", "Termine", "Zusage von", "");
	$tabellen_spalten_anzahl = count($tabellen_spalten_namen);
?>
<br/>
<form method="post">
		<input type="hidden" name="form_anfrage_aktiv" value="1"/>
		<input type="hidden" name="papierkorb_geklickt" value="0"/>
	</form>
<table style="position:relative; top:0px; z-index:99; border-spacing:0pt;">
	<!--Tabellen-KOPF-->
	<tr>
		<?php
			$td_style[0] = "padding:10px; background: #DDD; border-top: 1px solid #000000; border-left: 1px solid #000000; border-spacing:0pt; width:140px;";
			$td_style[1] = "padding:10px; background: #DDD; border-top: 1px solid #000000; border-left: 1px solid #000000; border-spacing:0pt; width:90px;";
			$td_style[2] = "padding:10px; background: #DDD; border-top: 1px solid #000000; border-left: 1px solid #000000; border-spacing:0pt; width:90px;";
			$td_style[3] = "padding:10px; background: #DDD; border-top: 1px solid #000000; border-left: 1px solid #000000; border-spacing:0pt; width:360px;";
			$td_style[4] = "padding:10px; background: #DDD; border-top: 1px solid #000000; border-left: 1px solid #000000; border-spacing:0pt; width:180px;";
			$td_style[5] = "padding:10px; background: #DDD; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; border-spacing:0pt; width:40px;";
			
			//
			for($i2=0;$i2<6;$i2++){ 
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
			$td_style[0] = "padding-top:4px; padding-bottom:0px; background: #EEE; border-top: 1px solid #000000; border-left: 1px solid #000000; border-spacing:0pt; width:140px;";
			$td_style[1] = "padding-top:4px; padding-bottom:0px; background: #EEE; border-top: 1px solid #000000; border-left: 1px solid #000000; border-spacing:0pt; width:90px;";
			$td_style[2] = "padding-top:4px; padding-bottom:0px; background: #EEE; border-top: 1px solid #000000; border-left: 1px solid #000000; border-spacing:0pt; width:90px;";
			$td_style[3] = "padding-top:4px; padding-bottom:0px; background: #EEE; border-top: 1px solid #000000; border-left: 1px solid #000000; border-spacing:0pt; width:360px;";
			$td_style[4] = "padding-top:4px; padding-bottom:0px; background: #EEE; border-top: 1px solid #000000; border-left: 1px solid #000000; border-spacing:0pt; width:180px;";
			$td_style[5] = "padding-top:4px; padding-bottom:0px; background: #EEE; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; border-spacing:0pt; width:40px;";
			
			//
			for($i2=0;$i2<6;$i2++){
		?>
		<td align="center" style="<?php echo $td_style[$i2]; ?>" valign="top">
			<div ><?php if($i2<5 && $i2 !=3){?>
				<a style="text-decoration: none;" href="./admin_index.php?rubrik=4&sort=<?php echo $i2*2; ?>#anchor_tabelle1" target="_self"><img style="border: 0 none;" src="<?php if($sort ==($i2*2)){echo "assets/sorter_oben_ddd.png"; } else {echo "assets/sorter_oben_aaa.png"; }?>"/></a> 
				<a style="text-decoration: none;" href="./admin_index.php?rubrik=4&sort=<?php echo $i2*2+1; ?>#anchor_tabelle1" target="_self"><img style="border: 0 none;" src="<?php if($sort ==($i2*2+1)){echo "assets/sorter_unten_ddd.png"; } else {echo "assets/sorter_unten_aaa.png"; }?>"/></a> 
				<?php } ?>
			</div>
		</td>
		<?php }?>
	</tr>
	<!--Tabellen-BODY-->
	<?php if(count($tabellen_zeilen_DATA)>0) { ?>
	<?php for($i=0;$i<$tabellen_zeilen_anzahl;$i++){ ?>
	<tr>
		<?php 
			$td_style[0] = "padding:10px; padding-top: 2px; border-top:1px solid #000000; border-left:1px solid #000000; border-spacing:0pt; width:140px;";
			$td_style[1] = "padding:10px; padding-top: 2px; border-top:1px solid #000000; border-left:1px solid #000000; border-spacing:0pt; width:90px;";
			$td_style[2] = "padding:10px; padding-top: 2px; padding-bottom: 2px; border-top:1px solid #000000; border-left:1px solid #000000; border-spacing:0pt; width:90px;";
			$td_style[3] = "padding:10px; padding-top: 2px; padding-bottom: 2px; border-top:1px solid #000000; border-left:1px solid #000000; border-spacing:0pt; width:360px;";
			$td_style[4] = "padding:10px; padding-top: 2px; border-top:1px solid #000000; border-left:1px solid #000000; border-spacing:0pt; width:180px;";
			$td_style[5] = "padding:10px; padding-top: 2px; border-top:1px solid #000000; border-left:1px solid #000000; border-right: 1px solid #000000; border-spacing:0pt; width:40px;";
			//
			for ($i2 = 0; $i2 < 6; $i2++) { 
				if (isset($zusage_ID[$tabellen_zeilen_DATA[$i][4]])){ 
					$td_style[$i2] .= "background: #CFC;";
				}			
				if ($i == ($tabellen_zeilen_anzahl - 1)) { 
					$td_style[$i2] .= "border-bottom: 1px solid #000000;";
				}
		?>
		<td style="<?php echo $td_style[$i2]; ?>" valign="top">
			<?php if($i2 == 0){?> 
				<p><?php echo $schule_DATA_NAME[$tabellen_zeilen_DATA[$i][10]]; ?>
				&nbsp;<a href="mailto:<?php echo $schule_DATA_EMAIL[$tabellen_zeilen_DATA[$i][10]];?>" target="_self"><img style="border: 0 none;" src="assets/icon_brief.gif"/></a>
				</p>
			<?php }; ?> 
			<?php if($i2 == 1){?> 
				<p><?php echo $tabellen_zeilen_DATA[$i][0]; 
					if($tabellen_zeilen_DATA[$i][8]){
						echo "<br/>"."(".$tabellen_zeilen_DATA[$i][8].")";
					}
				?></p>
			<?php }; ?> 
			<?php if($i2 == 2){?> 
				<p><?php echo $tabellen_zeilen_DATA[$i][1]; ?></p>
			<?php }; ?>
			<?php if($i2 == 3){ 
					$anz_dat_test = explode("---123MARGARIS321---", $tabellen_zeilen_DATA[$i][2]);
					$tempo_test = explode(";", $anz_dat_test[0]);
					if($tempo_test[0]){?> 
				<p> 
					<div style='font-size: 1.0em; text-align:left;'>
						<u>mögliche Termine der mündlichen Prüfung:</u><br/><br/>
						<?php
					$anz_dat = explode("---123MARGARIS321---", $tabellen_zeilen_DATA[$i][2]);
					for($dieses = 0;$dieses<count($anz_dat)-1;$dieses++){
						$tempo = explode(";", $anz_dat[$dieses]);
						if($tempo[0]){
						if ($tempo[3] < 10) { $tempo[3] = "0".$tempo[3]; }
						if ($tempo[4] < 10) { $tempo[4] = "0".$tempo[4]; }
						if ($tempo[5] < 10) { $tempo[5] = "0".$tempo[5]; }
						if ($tempo[6] < 10) { $tempo[6] = "0".$tempo[6]; }
						echo "<b>".intval($dieses+1).").&nbsp;&nbsp;".$tempo[0].".".$tempo[1]." ".$tempo[2].",&nbsp;&nbsp;&nbsp;".$tempo[3].":".$tempo[4]." - ".$tempo[5].":".$tempo[6]." </b>"; 
						//echo "Bis:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$tempo[5].".".$tempo[6]." ".$tempo[7].",&nbsp;&nbsp;&nbsp;".$tempo[8].":".$tempo[9]; 
						}
					
						echo "<div style='float:right; '>";
						?>
						<input type="checkbox" name="TESTTESTBLABLA" <?php if($zusage_ID_DETAIL[$tabellen_zeilen_DATA[$i][4]][$dieses] == 1){ echo "checked"; } ?> onclick="this.checked = !this.checked" >
						<?php
						echo "</div>";
					 
						echo "<br/>";
					
					}
					
					echo "</div>";
				?></p>
					<?php } ?>
				<p><?php 
				$tempo = explode(";", $tabellen_zeilen_DATA[$i][3]);
					if($tempo[0]){
					echo "<div style='font-size: 1.0em; text-align:left'>";
					echo "<u>Begutachtung der schriftlichen Prüfung:</u><br/>";
					
						echo "Von:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$tempo[0].".".$tempo[1]." ".$tempo[2]."&nbsp;&nbsp;&nbsp;&nbsp;";
						echo "Bis:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$tempo[3].".".$tempo[4]." ".$tempo[5]; 
					
					echo "</div>";
					}
				?>
				
				</p>
			<?php }; ?>
			<?php if($i2 == 4 ){?> 
			<p>
				<?php echo $experte_DATA_NAME[$zusage_ID[$tabellen_zeilen_DATA[$i][4]]]; ?>
				<?php if(isset($zusage_ID[$tabellen_zeilen_DATA[$i][4]])){ ?>
					&nbsp;&nbsp;<a href="mailto:<?php echo $experte_DATA_EMAIL[$zusage_ID[$tabellen_zeilen_DATA[$i][4]]];?>" target="_self"><img style="border: 0 none;" src="assets/icon_brief.gif"/></a>
				<?php } ?>
			</p>
			<?php }; ?> 
			<?php if($i2 == 5){?> 
				<p>
					<?php if($zusage_ID[$tabellen_zeilen_DATA[$i][4]]) { ?>
							<img style="cursor:pointer; border: 0 none;" src="assets/papierkorb.png" onclick="document.forms[0].form_anfrage_aktiv.value= 5; document.forms[0].papierkorb_geklickt.value='<?php echo $tabellen_zeilen_DATA[$i][4]."-".$zusage_ID[$tabellen_zeilen_DATA[$i][4]]; ?>'; document.forms[0].submit()" /> 
					<?php } else { ?>
							<img style="cursor:pointer; border: 0 none;" src="assets/papierkorb.png" onclick="document.forms[0].form_anfrage_aktiv.value= 5; document.forms[0].papierkorb_geklickt.value='<?php echo $tabellen_zeilen_DATA[$i][4]."-0"; ?>'; document.forms[0].submit()" /> 
					<?php } ?>
				</p>
			<?php }; ?> 
		</td>
		<?php }?>
	</tr>
	<?php }	?>
	<?php }	?>
	
	<!-- Falls keine Anfragen gestellt Tab 1 -->
	<?php if(count($tabellen_zeilen_DATA)==0) { ?>
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