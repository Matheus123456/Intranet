<?php
session_start();

if(!$_SESSION['cpf']){
	header("Location: index.php");
	exit();
}


?>
