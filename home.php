<?php
$selected_page = "Home";
require('includes/header.php');
protect_page();
?>

<?php
$fase = 2;
if (get_running1_batch_id()) {
    include_once('includes/fase1/home.php');
} else if (get_running2_batch_id()) {
    include_once('includes/fase2/home.php');
}
?>

<?php require('includes/footer.php'); ?>