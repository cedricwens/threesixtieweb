<?php
	$selected_page = "Home";
	require('includes/header.php');
	if(!get_running1_batch_id() && !get_running2_batch_id() && !get_published_batch_id()){
		// destroy session
		session_destroy();

		//unset cookies
		setcookie("username", "", time()-7200);
		header('Location: login.php');
	}
	protect_page();
	if(get_published_batch_id()){
		header('Location: user.php');
	}
?>

<?php 
if(get_running1_batch_id()){
	require('includes/fase1/index.php');
}else if(get_running2_batch_id()){
	require('includes/fase2/index.php');
}

?>

<?php require('includes/footer.php'); ?>