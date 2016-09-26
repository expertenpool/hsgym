<?php
	//
	//echo $_POST["papierkorb_geklickt"].", ";
	$temp = explode("-", $_POST["papierkorb_geklickt"]);
	//echo $temp[1];
	//
	if ($_POST["papierkorb_geklickt"] > 0 && isset($_POST["papierkorb_geklickt"])) {
		//echo "are in last";
		include ("mysql_connect.php");
		//
		//
		$sql = sprintf("DELETE FROM anfrage WHERE( id = '%s') LIMIT 1",
		mysql_real_escape_string($_POST["papierkorb_geklickt"]));
		//
		$res = mysql_db_query( "hsgym-ep", $sql );
		//
		if($temp[1] == 0){
			$_SESSION['info_zeile'] = "Die Anfrage wurde gelöscht!";
		}
		if ($temp[1] > 0) {
			//	
			$sql = sprintf("DELETE FROM zusage WHERE( anfrage_id = '%s') LIMIT 1",
			mysql_real_escape_string($_POST["papierkorb_geklickt"]));
			$res = mysql_db_query( "hsgym-ep", $sql );
			//
			$sql = sprintf("DELETE FROM absage WHERE( anfrage_id = '%s') LIMIT 1",
			mysql_real_escape_string($_POST["papierkorb_geklickt"]));
			$res = mysql_db_query( "hsgym-ep", $sql );
			//
			//$experte_DATA_EMAIL[$temp[1]] = $row[email];
			$_SESSION['info_zeile'] = "Die Anfrage wurde gelöscht! Bitte benachrichtigen Sie die Fachperson, die bereits zugesagt hat: ".$experte_DATA_NAME[$temp[1]];
			$_SESSION['info_zeile_email'] = $experte_DATA_EMAIL[$temp[1]];
		}
		//
	}
	//
?>