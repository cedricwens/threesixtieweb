<?php
	$selected_page = "Home";
require('includes/header.php');
logged_in_redirect();
$error = "";
?>

<?php
	if(isset($_POST['login'])){

		$username = $_POST['username'];
		$password = $_POST['password'];
		if(isset($_POST['rememberme'])){
			$rememberme = $_POST['rememberme'];
		}else{
			$rememberme = NULL;
		}
		$error = login($username, $password, $rememberme);
	}
	if(isset($_SESSION['admin_id'])){
		?>
		<div class="topContent">
			<p>U dient aan te melden als reguliere gebruiker om deze pagina te zien.</p>
			<p>Klik <a href="logout.php">hier</a> om u af te melden</p>
			<?php echo $error; ?>
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
			<?php echo $error; ?>
		</div>
		<?php
	}
?>

<?php require('includes/footer.php'); ?>