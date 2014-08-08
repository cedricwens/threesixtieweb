<?php
require('includes/header.php'); 
if(!isset($_SESSION['admin_id'])){
	header('Location:admin_login.php');
}
?>

<h2><?php echo get_text('Information').' '.strtolower(get_text('About')).' '.strtolower(get_text('User')); ?></h2>
<?php include('includes/form/choose_user.php'); ?>


<?php
if (isset($_POST['user'])) {
	if(empty($_POST['user'])){
		echo get_text('Please_choose_a_user');
	}else{
		$user = $_POST['user'];
		$id = get_user_id($user);
		$name = get_user_name($id);
		echo "<h2>".get_text('Information')." ".strtolower(get_text('About')).": $user</h2>";
		get_user_info($id);
	}
}
?>




<?php require('includes/footer.php'); ?>