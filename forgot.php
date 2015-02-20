<?php
$selected_page = "Home";
require('includes/header.php');
logged_in_redirect();
if (isset($_SESSION['admin_id'])) {
    header('Location: admin.php');
}
$error = "";
?>

<?php
if (isset($_POST['reset_password'])) {

    $username = $_POST['username'];
    $error = resend_password($username);
    ?>
    <div class="centerContent">
        <?php
        echo $error . '<br />';
        echo get_text('Click_here_to_log_in');
        ?>
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