<?php
unset($_POST);	
unset($_SESSION);

session_start();

session_destroy();
header('Location: ./');
?>