<?php
require('core/init.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>ThreeSixtyWeb</title>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
	<div id="container">
	<div id="header_container">
		<header><h1><?php echo get_Text('Title'); ?></h1></header>
		<nav id="menu">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="user.php">User</a></li>
			</ul>
		</nav>
	</div>
	<div class="content_wrapper">