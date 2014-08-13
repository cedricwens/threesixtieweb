<?php
$selected_page = "Home";
require('includes/header.php');
$users = get_users_order_by_id();
function number_of_users(){
	$query = mysql_query("SELECT count(*) FROM user");
		if(!$query || mysql_num_rows($query) <=0){
			echo mysql_error();
			return false;
		}else{
			return mysql_result($query,0);
		}
}
function init($users){
	foreach ($users as $reviewer) {
		foreach ($users as $reviewee) {
			$reviewer_id = $reviewer['ID'];
			$reviewee_id = $reviewee['ID'];
			echo "INSERT INTO candidate_poll (Reviewer, Reviewee) VALUES ($reviewer_id, $reviewee_id);<br />";
			mysql_query("INSERT INTO candidate_poll (Reviewer, Reviewee) VALUES ($reviewer_id, $reviewee_id");
		}
	}
}

function is_possible(){
}

function calculate($reviewee, $reviewer, $users, $user_array){

}

init($users);


?>