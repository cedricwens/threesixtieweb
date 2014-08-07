<?php
	include_once'core/init.php';
	session_destroy();
	header('Location:login.php');
?>