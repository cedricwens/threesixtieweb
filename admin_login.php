<?php
require('includes/header.php');
logged_in_redirect();
?>

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
		if($username == "Admin"){
			if(password_verify($password, '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO')){
				echo "test";
				$_SESSION['admin_id'] = get_admin_id('Admin');
				header('Location: admin.php');
			}else{
				echo "Foutief wachtwoord.";
			}
		}
		
	}
?>

<?php require('includes/footer.php'); ?>