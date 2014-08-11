<?php
	$selected_page = "Home";
	require('includes/header.php');
	protect_page();
?>

<?php 
$fase = 2;
if($fase == 1){
	include_once('includes/fase1/home.php');
}else{
	include_once('includes/fase2/home.php');
}
?>

<?php require('includes/footer.php'); ?>