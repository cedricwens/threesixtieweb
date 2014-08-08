<?php
require('core/init.php');
logged_in_redirect();
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
				<li><a href="index.php">Home</a></li>
				<li><a href="user.php">User</a></li>
				<?php
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
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<label for="username"><?php echo get_text('Username'); ?>: </label><input type="text" name="username" />
	<br />
	<label for="password"><?php echo get_text('Password'); ?>: </label><input type="password" name="password" />
<!-- consider adding a logo here dnsbelgium.png (please ask for the file)-->
	<input type="submit" value="Login" name="login" />
</form>

<?php
	if(isset($_POST['login'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		login($username, $password);
	}
?>

<?php require('includes/footer.php'); ?>