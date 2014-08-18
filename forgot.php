<?php
	$selected_page = "Home";
require('includes/header.php');
logged_in_redirect();
if(isset($_SESSION['admin_id'])){
	header('Location: admin.php');
}
$error = "";
?>

<?php
	if(isset($_POST['login'])){

		$username = $_POST['username'];
		$error = resend_password($username);
	}
	?>
	<div class="topContent">
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="login">
			<input type="text" name="username" placeholder="<?php echo get_text('Username'); ?>" required />
			<br />
			<input type="submit" value="Send password" name="login" />
		</form>
		<?php echo $error; ?>
	</div>

<?php require('includes/footer.php'); ?>