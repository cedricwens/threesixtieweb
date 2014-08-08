<?php
require('core/init.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>ThreeSixtyWeb</title>
	<link rel="stylesheet" type="text/css" href="main.css">
	<!-- consider adding a logo here /somewhere on the page
				dnsbelgium.png (please ask for the file)-->
</head>
<body>
	<div id="container">
	<div id="header_container">
		<header><h1><?php echo get_Text('Title'); ?></h1></header>
		<nav id="menu">
			<ul>
				<li><a href="home.php">Home</a></li>
				<li><a href="user.php">User</a></li>
				<?php
				if(isset($_SESSION['user_id'])){
					if(has_access($_SESSION['user_id'],get_user_type_id('Admin'))){
						?>
						<li><a href="admin.php">Admin</a></li>
						<?php
					}
				}
				if(logged_in()){
					?>
					<li><a href="logout.php">Logout</a></li>
					<?php
				}
				?>
			</ul>
		</nav>
	</div>
	<div class="content_wrapper">