<?php
	include_once'core/init.php';

	// destroy session
	session_destroy();

	//unset cookies
	setcookie("username", "", time()-7200);

	header('Location:login.php');
?>