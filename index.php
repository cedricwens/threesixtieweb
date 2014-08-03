<?php
	$db = mysql_connect("localhost", "root", "") or die("Unable to connect to MySQL");
	mysql_select_db("threesixtyweb", $db) or die("Could not connect to database");

	$users = mysql_fetch_array(mysql_query("SELECT * from user"));
	foreach ($users as $user) {
		echo $user["ID"].": ".$user['Name'];
	}
?>