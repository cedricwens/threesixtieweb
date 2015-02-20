<?php
$selected_page = "Admin_login";
require('includes/header.php');
logged_in_redirect();
if (isset($_SESSION['admin_id'])) {
    header('Location: admin.php');
}
$errors = "";
?>
<?php
if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $errors = admin_login($username, $password);
}
?>
    <div class="centerContent">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="login">
            <input type="text" name="username" placeholder="<?php echo get_text('Username'); ?>" required/>
            <br/>
            <input type="password" name="password" placeholder="<?php echo get_text('Password'); ?>" required/>
            <br/>
            <input type="submit" value="<?php echo get_text('Login'); ?>" name="login"/>
            <br/>
            <a href="admin_forgot.php"><?php echo get_text('Forgot_password'); ?>?</a>
        </form>
        <?php
        if ($errors != "") {
            echo '<b>' . $errors . '</b>';
        }
        ?>
    </div>
<?php require('includes/footer.php'); ?>