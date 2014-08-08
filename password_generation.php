<?php
	echo password_hash('password',PASSWORD_DEFAULT)."<br />";
	$time = time();
	$date = date("Y-m-d H:i:s", $time);
	echo $date;
?>