<?php
	$selected_page = "Login";
require('includes/header.php');
logged_in_redirect();
?>

<?php
	if(isset($_SESSION['admin_id'])){
		?>
		<div class="topContent">
			<p>U dient aan te melden als reguliere gebruiker om deze pagina te zien.</p>
			<p>Klik <a href="logout.php">hier</a> om u af te melden</p>
		</div>
		<?php
	}else{
		?>
		<div class="topContent">
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<label for="username"><?php echo get_text('Username'); ?>: </label><input type="text" name="username" />
				<br />
				<label for="password"><?php echo get_text('Password'); ?>: </label><input type="password" name="password" />
			<!-- consider adding a logo here dnsbelgium.png (please ask for the file)-->
				<br />
				<input type="checkbox" name="rememberme" /><label for="rememberme">Remember me</label>
				<br />
				<input type="submit" value="Login" name="login" />
			</form>
		</div>
		<?php
	}

	if(isset($_POST['login'])){

		$username = $_POST['username'];
		$password = $_POST['password'];
		$rememberme = $_POST['rememberme'];
		login($username, $password, $rememberme);
	}
?>

<?php require('includes/footer.php'); ?>