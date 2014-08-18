<?php

/**
 * De verschillende poll scores: (hoge score is beter)
 * Teammanager:
 *		JA=  [0;	-10]
 *		NEE= [0;	10]
 * Usermember:
 * 		JA=	 [-10;	-20]
 * 		NEE= [10; 	20]
 **/
set_time_limit(60);
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
	mysql_query("TRUNCATE TABLE candidate_poll");
	foreach ($users as $reviewer) {
		foreach ($users as $reviewee) {
			$reviewer_id = $reviewer['ID'];
			$reviewee_id = $reviewee['ID'];
			if($reviewer_id != $reviewee_id && $reviewer_id != get_team_manager($reviewee_id)){
				// Enkel rijen toevegen waarbij de reviewer en reviewee verschillen of waarbij de reviewer niet te teammanager is van de reviewee.
				//echo "INSERT INTO candidate_poll (Reviewer, Reviewee) VALUES ($reviewer_id, $reviewee_id));<br />";
				mysql_query("INSERT INTO candidate_poll (Reviewer, Reviewee, Score) VALUES ($reviewer_id, $reviewee_id, 0)");
			}
		}
	}
	calculate($users);
}

function calculate($users){
	$polls = get_candidate_polls();
	foreach ($polls as $poll) {
		if(get_department($poll['Reviewer']) == get_department($poll['Reviewee'])){
			// Reviewer en reviewee zijn teamleden
			$score = rand(-10,-20);
			update_candidate_poll_score($poll['ID'], (get_candidate_poll_score($poll['ID'])+$score));
		}else{
			// Reviewer en reviewee zijn geen teamleden
			$score = rand(10,20);
			update_candidate_poll_score($poll['ID'], (get_candidate_poll_score($poll['ID'])+$score));
		}
		if($poll['Reviewee'] == get_managers()){
			// Reviewee is een manager (kan niet eigen manager zijn, want deze koppels zitten niet in de database)
			$score = rand(0,10);
			update_candidate_poll_score($poll['ID'], (get_candidate_poll_score($poll['ID'])+$score));
		}else{
			// Reviewer is geen manager
			$score = rand(0,-10);
			update_candidate_poll_score($poll['ID'], (get_candidate_poll_score($poll['ID'])+$score));
		}
	}
	check($users);
}

function get_top_polls($user){
	$query = mysql_query("SELECT * FROM candidate_poll WHERE Reviewer = $user ORDER BY Score DESC LIMIT 0,5");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$top_polls[] = array(
				'ID' => $row['ID'],
				'Reviewer' => $row['Reviewer'],
				'Reviewee' => $row['Reviewee'],
				'Score' => $row['Score']
			);
		}
		return $top_polls;
	}
}
function get_manager_not_top_manager(){
	// Selecteer alle managers, behalve de hoogtste manager (Philip Du Bois)
	$query = mysql_query("SELECT DISTINCT(d.ID) AS Department, d.Manager AS Manager FROM user_department ud INNER JOIN Department d ON ud.Department = d.ID WHERE d.Manager != (SELECT ID FROM user WHERE Username='DuBois.Philip');");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$managers[] = array(
				stripslashes('Department') => $row['Department'],
				stripslashes('Manager') => $row['Manager']
			);
		}
		return $managers;
	}
}
function get_candidate_polls(){
	$query = mysql_query("SELECT * FROM candidate_poll");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$polls[] = array(
				'ID' => $row['ID'],
				'Reviewer' => $row['Reviewer'],
				'Reviewee' => $row['Reviewee'],
				'Score' => $row['Score']
			);
		}
		return $polls;
	}
}

function get_department($user){
	$query = mysql_query("SELECT Department FROM user_department WHERE ID = $user;");
	if(!$query || mysql_num_rows($query) < 0) {
		echo mysql_error();
		return false;
	}else{
		if(mysql_num_rows($query) == 0){
			return 0;
		}
		return mysql_result($query, 0);
	}
}

function get_candidate_poll_score($poll){
	$query = mysql_query("SELECT Score FROM candidate_poll WHERE ID = $poll;");
	if(!$query || mysql_num_rows($query) < 0) {
		echo mysql_error();
		return false;
	}else{
		if(mysql_num_rows($query) == 0){
			return 0;
		}
		return mysql_result($query, 0);
	}
}
function update_candidate_poll_score($poll, $score){
	$query = mysql_query("UPDATE candidate_poll SET Score = $score WHERE ID = $poll;");
}

init($users);
//calculate($users);
//check($users);
function check($users){
	foreach ($users as $user) {
		$get_best_polls_reviewee = get_best_polls_reviewee($user['ID']);
		foreach ($get_best_polls_reviewee as $poll) {
			$id = $poll['ID'];
			mysql_query("UPDATE candidate_poll SET Ok_reviewee = 1 WHERE ID = $id");
			//echo $poll['ID'].': Reviewer:'.$poll['Reviewer'].' Reviewee:'.$user['ID'].' Score:'.$poll['Score'].'<br />';
		}
		$get_best_polls_reviewer = get_best_polls_reviewer($user['ID']);
		foreach ($get_best_polls_reviewer as $poll) {
			$id = $poll['ID'];
			mysql_query("UPDATE candidate_poll SET Ok_reviewer = 1 WHERE ID = $id");
			//echo $poll['ID'].': Reviewer:'.$user['ID'].' Reviewee:'.$poll['Reviewee'].' Score:'.$poll['Score'].'<br />';
		}

		//set_best_polls();
		$best_polls_reviewee_reviewer = get_best_polls_reviewee_reviewer($user['ID']);
		/*echo "<pre>";
		print_r($best_polls_reviewee_reviewer);
		echo "</pre>";*/
		foreach ($best_polls_reviewee_reviewer as $poll) {
			$id = $poll['ID'];
			mysql_query("UPDATE candidate_poll SET Ok_overall=1 WHERE ID = $id");
			//echo "<br />UPDATE candidate_poll SET Ok_overall=1 WHERE ID = $id<br />";
		}

		$reviews_given = get_reviews_given();
		/*echo "<pre>";
		print_r($too_few_reviews_given);
		echo "</pre>";*/
		if($reviews_given){
			foreach ($reviews_given as $too_few) { // Alle gebruikers die reviews geven
				if($too_few['Aantal_reviews'] < 5){ // Alle gebruikers die minder dan 5 reviews geven
					foreach ($reviews_given as $too_much) { // Alle gebruikers die reviews geven
						if($too_much['Aantal_reviews'] > 5){ // Alle gebruikers die meer dan 5 reviews geven
							/**
							  * Van de gebruikers die teveel reviews geven, alle 'extra' reviews opvragen (de top_reviews, die niet de 5 beste zijn)
							  * Dan alle gebruikers overlopen die te weinig reviews geven
							  * Per gebruiker de beste review kiezen en deze koppelen aan de de gebruiker die te weinig reviews geeft
							  **/
							/*$reviewer_polls = get_best_polls_reviewer($too_much['ID']); // De beste polls van de gebruikers die teveel reviews geven
							foreach ($reviewer_polls as $reviewer_poll) {
								echo "test";
							}*/
						}
					}	  
				}
			}
		}
		//$top_polls = get_top_polls($user['ID']);

		//foreach ($top_polls as $key => $top_poll){
			
			//echo get_number_of_candidate_poll_team_members($user['ID']).'-';
			
			//echo get_total_candidate_reviews_to_give($user['ID']);
			//echo get_number_of_candidate_poll_team_members($user['ID']).'-';
			/*if(get_number_of_candidate_poll_team_members($user['ID']) > 2/* || get_total_candidate_reviews_to_give($user['ID']) < 2 *//* || get_number_of_preferred_reviewees($user['ID']) < 3*///){
				//echo $top_poll['Reviewer'].'-'.$top_poll['Reviewee'].'<br />';
				/*echo "Herberekenen omdat het niet klopt voor user_id ".$user['ID'];
				init($users);
			}*/
			//echo $key.': '.$top_poll['Reviewer'].'-'.$top_poll['Reviewee'].'<br />';
			
		//}
	}
}

function get_number_of_candidate_poll_team_members($id){
	$query = mysql_query("SELECT count(*) FROM candidate_poll WHERE reviewee=$id AND (SELECT Department FROM user_department WHERE user=reviewer) = (SELECT Department FROM user_department WHERE user = $id);");
	if(!$query || mysql_num_rows($query) < 0) {
		echo mysql_error();
		return false;
	}else{
		if(mysql_num_rows($query) == 0){
			return 0;
		}
		return mysql_result($query, 0);
	}
}

function get_best_polls_reviewee($reviewee){ // Selecteer de 5 beste polls voor een reviewee
	$query = mysql_query("SELECT ID, Reviewer, Score FROM candidate_poll WHERE Reviewee=$reviewee ORDER BY Score DESC LIMIT 5;");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$polls[] = array(
				'ID' => $row['ID'],
				'Reviewer' => $row['Reviewer'],
				'Score' => $row['Score']
			);
		}
		return $polls;
	}
}
function get_best_polls_reviewer($reviewer){ // Selecteer de 5 beste polls voor een reviewer
	$query = mysql_query("SELECT ID, Reviewee, Score FROM candidate_poll WHERE Reviewer=$reviewer ORDER BY Score DESC LIMIT 5;");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$polls[] = array(
				'ID' => $row['ID'],
				'Reviewee' => $row['Reviewee'],
				'Score' => $row['Score']
			);
		}
		return $polls;
	}
}
function get_best_polls_reviewee_reviewer($reviewer){ // Selecteer maximaal 5 polls voor elke reviewer, waarbij de polls komen uit de verzameling van 5 beste polls voor een reviewee
	$query = mysql_query("SELECT ID, Reviewee, Score FROM candidate_poll WHERE Ok_reviewee=1 AND Reviewer=1 ORDER BY Score DESC LIMIT 5");
	echo "SELECT ID, Reviewee, Score FROM candidate_poll WHERE Ok_reviewee=1 AND Reviewer=1 ORDER BY Score DESC LIMIT 5<br />";
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$polls[] = array(
				'ID' => $row['ID'],
				'Reviewee' => $row['Reviewee'],
				'Score' => $row['Score']
			);
		}
		return $polls;
	}
}
function set_best_polls(){
	mysql_query("UPDATE candidate_poll SET Ok_overall = 1 WHERE Ok_reviewee=1 AND Ok_reviewer=1");
}
function get_number_of_best_reviews_given($user){
	$query = mysql_query("SELECT count(*) FROM candidate_poll WHERE reviewee=$id AND (SELECT Department FROM user_department WHERE user=reviewer) = (SELECT Department FROM user_department WHERE user = $id);");
	if(!$query || mysql_num_rows($query) < 0) {
		echo mysql_error();
		return false;
	}else{
		if(mysql_num_rows($query) == 0){
			return 0;
		}
		return mysql_result($query, 0);
	}
}
function get_reviews_given(){
	$query = mysql_query("SELECT Reviewer, count(*) AS Aantal_reviews FROM candidate_poll WHERE Ok_overall = 1 GROUP BY Reviewer;");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$polls[] = array(
				'Reviewer' => $row['Reviewer'],
				'Aantal_reviews' => $row['Aantal_reviews']
			);
		}
		return $polls;
	}
}
function get_reviews_received(){
	$query = mysql_query("SELECT Reviewee, count(*) AS Aantal_reviews FROM candidate_poll WHERE Ok_overall = 1 GROUP BY Reviewee;");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$polls[] = array(
				'Reviewee' => $row['Reviewee'],
				'Aantal_reviews' => $row['Aantal_reviews']
			);
		}
		return $polls;
	}
}
function get_best_polls_reviewer_offset($reviewer){
	$query = mysql_query("SELECT ID, Reviewee, Score FROM candidate_poll WHERE Reviewer=$reviewer AND ok_overall = 1 ORDER BY Score;");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$polls[] = array(
				'ID' => $row['ID'],
				'Reviewee' => $row['Reviewee'],
				'Score' => $row['Score']
			);
		}
		return $polls;
	}
}









function get_number_of_reviewers($reviewee){
	$query = mysql_query("SELECT count(*) AS Aantal_reviewers FROM");
}
?>