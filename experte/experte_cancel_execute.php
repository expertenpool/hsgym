<?php
		include ("mysql_connect.php");

		$sql = sprintf("DELETE FROM experte WHERE (email = '%s')",
		mysql_real_escape_string($_SESSION['mysql_email']));
		$res = mysql_db_query( "hsgym-ep", $sql );
		
		/*unset($_POST);	
		unset($_SESSION);

		session_start();

		session_destroy();*/
		
		$_SESSION['cancel_erfolgreich'] = "true";
		
		header('Location: ./');
		

?>