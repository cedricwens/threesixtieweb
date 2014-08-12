<?php
	$selected_page = "Home";
	require('includes/header.php');
	protect_page();
?>

<?php 
if(get_running1_batch_id()){
	include_once('includes/fase1/index.php');
}else if(get_running2_batch_id()){
	include_once('includes/fase2/index.php');
}
?>

<?php require('includes/footer.php'); ?>