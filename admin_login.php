<?php
$selected_page = "Admin_login";
require('includes/header.php');
logged_in_redirect();
if(isset($_SESSION['admin_id'])){
	header('Location: admin.php');
}
$errors = "";
?>
<?php
	if(isset($_POST['login'])){

		$username = $_POST['username'];
		$password = $_POST['password'];
		if($username == "Admin"){
			if(password_verify($password, '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO')){
				$_SESSION['admin_id'] = get_admin_id('Admin');
				header('Location: admin.php');
			}else{
				$errors = get_text('Wrong_password');
			}
		}
		
	}
?>
<div class="topContent">
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="login">
		<input type="text" name="username" placeholder="<?php echo get_text('Username'); ?>" required />
		<br />
		<input type="password" name="password" placeholder="<?php echo get_text('Password'); ?>" required/>
		<br />
	<!-- consider adding a logo here dnsbelgium.png (please ask for the file)-->
		<input type="submit" value="<?php echo get_text('Login'); ?>" name="login" />
	</form>
	<?php
		if($errors != ""){
			echo'<b>'.$errors.'</b>';
		}
	?>
</div>
<?php require('includes/footer.php'); ?>