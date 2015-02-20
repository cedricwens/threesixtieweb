<?php
$selected_page = "Home";
require('includes/header.php');
logged_in_redirect();
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
}
$error = "";
?>
<?php
if (isset($_POST['reset_password'])) {

    $username = $_POST['username'];
    $error = resend_admin_password($username);
    ?>
    <div class="centerContent">
        <?php echo $error; ?>
        Klik <a href="admin_login.php">hier</a> om je aan te melden.
    </div>
<?php
} else {
    ?>
    <div class="centerContent">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="login">
            <input type="text" name="username" placeholder="<?php echo get_text('Username'); ?>" required/>
            <br/>
            <input type="submit" value="<?php echo get_text('Reset_password'); ?>" name="reset_password"/>
        </form>
        <?php echo $error; ?>
    </div>
<?php
}
?>

<?php require('includes/footer.php'); ?>