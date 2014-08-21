<?php

/**
 * De verschillende poll scores: (hoge score is beter)
 * Teammanager:
 *		JA=  [0;	-10]
 *		NEE= [0;	10]
 * Usermember:
 * 		JA=	 [0;	-10]
 * 		NEE= [10; 	20]
 **/
set_time_limit(60);
$selected_page = "Home";
require('includes/header.php');
$users = get_users_order_by_id();



//init($users);
$success = 0;
$test = 0;
$iteration = 0;
//echo "Voor elke gebruiker staat hier het aantal keer dat hij gereviewed wordt door een manager. 1 regel is 1 keer het algoritme uitvoeren<br />";
//echo "In het vetgedrukt staat het aantal teamleden waarvan een gebruiker reviews krijgt<br />";

while ($success == 0) {
	$test = 0;
	init($users);
	foreach ($users as $user) {
		if(get_number_of_candidate_poll_not_team_manager($user['ID']) > 2){
			$test++;
		}
		echo get_number_of_candidate_poll_not_team_manager($user['ID'])."-";	
		if(get_number_of_candidate_poll_team_members($user['ID']) > 2){
			$test++;
		}
		echo "<b>".get_number_of_candidate_poll_team_members($user['ID'])."</b>-";	
		/*if(get_number_of_candidate_preferred_reviewers($user['ID']) < 2){
			$test++;
		}
		echo get_number_of_candidate_preferred_reviewers($user['ID'])."-";	
		if(get_number_of_candidate_preferred_reviewees($user['ID']) < 3){
			$test++;
		}
		echo "<b>".get_number_of_candidate_preferred_reviewees($user['ID'])."</b>-";	*/
	}
	echo "<br />";
	if($test > 0){
		$success = 0;
	}else{
		$success = 1;
	}

}
foreach ($users as $user) {
	echo get_number_of_candidate_poll_not_team_manager($user['ID'])."-";
}
if(isset($_GET['user'])){
	get_candidate_user_info($_GET['user']);
}
$number_of_polls=-1000000;


?>