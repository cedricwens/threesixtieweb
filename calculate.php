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
				mysql_query("INSERT INTO candidate_poll (Reviewer, Reviewee, Score, Ok_reviewee, Ok_reviewer, Ok_overall) VALUES ($reviewer_id, $reviewee_id, 0, 0, 0, 0)");
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
		if(is_manager($poll['Reviewer'])){
			// Reviewee is een manager (kan niet eigen manager zijn, want deze koppels zitten niet in de database)
			$score = rand(0,10);
			//echo $score;
			update_candidate_poll_score($poll['ID'], (get_candidate_poll_score($poll['ID'])+$score));
		}else{
			// Reviewer is geen manager
			$score = rand(0,10);
			update_candidate_poll_score($poll['ID'], (get_candidate_poll_score($poll['ID'])+$score));
		}
		// Nog informatie over voorkeuren toevoegen.
		if(is_preferred_poll($poll['Reviewer'], $poll['Reviewee'])){
			// Preferred_poll
			$score = rand(0,100);
			update_candidate_poll_score($poll['ID'], (get_candidate_poll_score($poll['ID'])+$score));
		}else{
			// Geen preferred_poll
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
				'Score' => $row['Score'],
				'Ok_reviewee' => $row['Ok_reviewee'],
				'Ok_reviewer' => $row['Ok_reviewer'],
				'Ok_overall' => $row['Ok_overall']
				);
		}
		return $polls;
	}
}
function get_candidate_poll($reviewer, $reviewee){
	$query = mysql_query("SELECT * FROM candidate_poll WHERE Reviewer = $reviewer AND Reviewee = $reviewee");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$polls[] = array(
				'ID' => $row['ID'],
				'Reviewer' => $row['Reviewer'],
				'Reviewee' => $row['Reviewee'],
				'Score' => $row['Score'],
				'Ok_reviewee' => $row['Ok_reviewee'],
				'Ok_reviewer' => $row['Ok_reviewer'],
				'Ok_overall' => $row['Ok_overall']
				);
		}
		return $polls;
	}
}
function get_candidate_polls_by_reviewer($reviewer){
	$query = mysql_query("SELECT * FROM candidate_poll WHERE Reviewer = $reviewer AND Ok_overall = 1");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$polls[] = array(
				'ID' => $row['ID'],
				'Reviewer' => $row['Reviewer'],
				'Reviewee' => $row['Reviewee'],
				'Score' => $row['Score'],
				'Ok_reviewee' => $row['Ok_reviewee'],
				'Ok_reviewer' => $row['Ok_reviewer'],
				'Ok_overall' => $row['Ok_overall']
				);
		}
		return $polls;
	}
}
function get_candidate_polls_by_reviewee($reviewee){
	$query = mysql_query("SELECT * FROM candidate_poll WHERE Reviewee = $reviewee AND Ok_overall = 1");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$polls[] = array(
				'ID' => $row['ID'],
				'Reviewer' => $row['Reviewer'],
				'Reviewee' => $row['Reviewee'],
				'Score' => $row['Score'],
				'Ok_reviewee' => $row['Ok_reviewee'],
				'Ok_reviewer' => $row['Ok_reviewer'],
				'Ok_overall' => $row['Ok_overall']
				);
		}
		return $polls;
	}
}
function get_candidate_poll_id_by_reviewer_reviewee_not_overall($reviewer, $reviewee){
	$query = mysql_query("SELECT ID FROM candidate_poll WHERE Reviewer = $reviewer AND Reviewee = $reviewee AND Ok_overall = 0");
	if(!$query || mysql_num_rows($query) <= 0) {
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query, 0);
	}
}
function is_preferred_poll($reviewer, $reviewee){
	$query = mysql_query("SELECT * FROM preferred_poll WHERE (Reviewer = $reviewer AND Reviewee = $reviewee) || (Reviewer = $reviewee AND Reviewee = $reviewer)");
	if(!$query || mysql_num_rows($query) <= 0) {
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query, 0);
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

//init($users);
$success = 0;
$test = 0;
$iteration = 0;
echo "Voor elke gebruiker staat hier het aantal keer dat hij gereviewed wordt door een manager. 1 regel is 1 keer het algoritme uitvoeren<br />";
echo "In het vetgedrukt staat het aantal teamleden waarvan een gebruiker reviews krijgt<br />";
while ($success == 0) {
	$test = 0;
	init($users);
	foreach ($users as $user) {
		if(get_number_of_candidate_poll_not_team_manager($user['ID']) > 2){
			$test++;
		}
		//echo get_number_of_candidate_poll_not_team_manager($user['ID'])."-";	
		if(get_number_of_candidate_poll_team_members($user['ID']) > 2){
			$test++;
		}
		//echo "<b>".get_number_of_candidate_poll_team_members($user['ID'])."</b>-";	
		if(get_number_of_candidate_preferred_reviewers($user['ID']) < 2){
			$test++;
		}
		echo get_number_of_candidate_preferred_reviewers($user['ID'])."-";	
		if(get_number_of_candidate_preferred_reviewees($user['ID']) < 3){
			$test++;
		}
		echo "<b>".get_number_of_candidate_preferred_reviewees($user['ID'])."</b>-";	
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
	get_candidcate_user_info($_GET['user']);
}
$number_of_polls=-1000000;

function check($users){
	shuffle($users);
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
	}
	set_best_polls();
	shuffle($users);
	foreach ($users as $user){
		$best_polls_reviewee_reviewer = get_best_polls_reviewee_reviewer($user['ID']);
		if($best_polls_reviewee_reviewer){
			foreach ($best_polls_reviewee_reviewer as $poll) {
				$id = $poll['ID'];
				mysql_query("UPDATE candidate_poll SET Ok_overall=1 WHERE ID = $id");
			}
		}
	}
	$reviews_given = get_reviews_given();
	$too_few_given = array();
	$too_many_given = array();
	$exact_given = array();
	if($reviews_given){
		foreach ($reviews_given as $reviews_per_reviewer) { 				// Alle gebruikers die reviews geven
			if($reviews_per_reviewer['Aantal_reviews'] < 5){				// Alle gebruikers die minder dan 5 reviews geven
				//print_r($reviews_per_reviewer);
				$too_few_given[] = $reviews_per_reviewer;
			}else if($reviews_per_reviewer['Aantal_reviews'] > 5){			// Alle gebruikers die meer dan 5 reviews geven
				$too_many_given[] = $reviews_per_reviewer;
			}else if($reviews_per_reviewer['Aantal_reviews'] == 5){			// Alle gebruikers die 5 reviews geven
				$exact_given[] = $reviews_per_reviewer;
			}
		}
	}
	$reviews_received = get_reviews_received();
	$too_few_received = array();
	$too_many_received = array();
	$exact_received = array();
	if($reviews_received){
		foreach ($reviews_received as $reviews_per_reviewee) { 				// Alle gebruikers die reviews krijgen
			if($reviews_per_reviewee['Aantal_reviews'] < 5){				// Alle gebruikers die minder dan 5 reviews krijgen
				$too_few_received[] = $reviews_per_reviewee;
			}else if($reviews_per_reviewee['Aantal_reviews'] > 5){			// Alle gebruikers die meer dan 5 reviews krijgen
				$too_many_received[] = $reviews_per_reviewee;
			}else if($reviews_per_reviewee['Aantal_reviews'] == 5){			// Alle gebruikers die 5 reviews krijgen
				$exact_received[] = $reviews_per_reviewee;
			}
		}
	}
	/*echo"too_many_given:";
	print_r($too_many_given);
	echo "<br />";
	echo"too_many_received";
	print_r($too_many_received);*/
	while(!empty($too_many_given) && !empty($too_many_received)){
		$polls = array();
		foreach($too_many_given as $too_many_reviewer){
			foreach($too_many_received as $too_many_reviewee){
				$poll = get_candidate_poll($too_many_reviewer['Reviewer'], $too_many_reviewee['Reviewee']);
				if($poll){
					if($poll[0]['Ok_overall'] == 1){
						$polls[] = $poll[0];
					}
				}
			}
		}
		$score = 1000;
		$id_worst_poll = 0;
		foreach ($polls as $poll) {
			if($score > $poll['Score']){
				$score = $poll['Score'];
				$id_worst_poll = $poll['ID'];
			}
		}
		mysql_query("UPDATE candidate_poll SET Ok_overall = 0 WHERE ID = $id_worst_poll");
		$reviews_given = get_reviews_given();
		$too_few_given = array();
		$too_many_given = array();
		$exact_given = array();
		if($reviews_given){
			foreach ($reviews_given as $reviews_per_reviewer) { 				// Alle gebruikers die reviews geven
				if($reviews_per_reviewer['Aantal_reviews'] < 5){				// Alle gebruikers die minder dan 5 reviews geven
					$too_few_given[] = $reviews_per_reviewer;
				}else if($reviews_per_reviewer['Aantal_reviews'] > 5){			// Alle gebruikers die meer dan 5 reviews geven
					$too_many_given[] = $reviews_per_reviewer;
				}else if($reviews_per_reviewer['Aantal_reviews'] == 5){			// Alle gebruikers die 5 reviews geven
					$exact_given[] = $reviews_per_reviewer;
				}
			}
		}
		$reviews_received = get_reviews_received();
		$too_few_received = array();
		$too_many_received = array();
		$exact_received = array();
		if($reviews_received){
			foreach ($reviews_received as $reviews_per_reviewee) { 				// Alle gebruikers die reviews krijgen
				if($reviews_per_reviewee['Aantal_reviews'] < 5){				// Alle gebruikers die minder dan 5 reviews krijgen
					$too_few_received[] = $reviews_per_reviewee;
				}else if($reviews_per_reviewee['Aantal_reviews'] > 5){			// Alle gebruikers die meer dan 5 reviews krijgen
					$too_many_received[] = $reviews_per_reviewee;
				}else if($reviews_per_reviewee['Aantal_reviews'] == 5){			// Alle gebruikers die 5 reviews krijgen
					$exact_received[] = $reviews_per_reviewee;
				}
			}
		}
	}
	while(!empty($too_many_given)){
		foreach($too_many_given as $too_many_reviewer){
			$polls = get_not_top_5_best_polls($too_many_reviewer['Reviewer']);
			foreach ($polls as $poll) {
				$id = $poll['ID'];
				mysql_query("UPDATE candidate_poll SET Ok_overall = 0 WHERE ID = $id");
			}

		}
		
		
		$reviews_given = get_reviews_given();
		$too_few_given = array();
		$too_many_given = array();
		$exact_given = array();
		if($reviews_given){
			foreach ($reviews_given as $reviews_per_reviewer) { 				// Alle gebruikers die reviews geven
				if($reviews_per_reviewer['Aantal_reviews'] < 5){				// Alle gebruikers die minder dan 5 reviews geven
					$too_few_given[] = $reviews_per_reviewer;
				}else if($reviews_per_reviewer['Aantal_reviews'] > 5){			// Alle gebruikers die meer dan 5 reviews geven
					$too_many_given[] = $reviews_per_reviewer;
				}else if($reviews_per_reviewer['Aantal_reviews'] == 5){			// Alle gebruikers die 5 reviews geven
					$exact_given[] = $reviews_per_reviewer;
				}
			}
		}
		$reviews_received = get_reviews_received();
		$too_few_received = array();
		$too_many_received = array();
		$exact_received = array();
		if($reviews_received){
			foreach ($reviews_received as $reviews_per_reviewee) { 				// Alle gebruikers die reviews krijgen
				if($reviews_per_reviewee['Aantal_reviews'] < 5){				// Alle gebruikers die minder dan 5 reviews krijgen
					$too_few_received[] = $reviews_per_reviewee;
				}else if($reviews_per_reviewee['Aantal_reviews'] > 5){			// Alle gebruikers die meer dan 5 reviews krijgen
					$too_many_received[] = $reviews_per_reviewee;
				}else if($reviews_per_reviewee['Aantal_reviews'] == 5){			// Alle gebruikers die 5 reviews krijgen
					$exact_received[] = $reviews_per_reviewee;
				}
			}
		}
	}
	/*$users = get_users();
	foreach($users as $user){
		$reviewer = $user['ID'];
		echo $reviewer." {";

		$polls = get_candidate_polls_by_reviewer($reviewer);
		if($polls){
			foreach($polls as $poll){
				echo $poll['Reviewee'].",";
			}
		}
		echo "}<br />";
	}*/
	//echo "----------------------------------------<br/>";
	global $number_of_polls;

	while((!empty($too_few_given) && !empty($too_few_received)) && $number_of_polls != get_overall_ok_polls()){
		//echo "number of polls:".$number_of_polls."get_overall_ok_polls:".get_overall_ok_polls();
		$number_of_polls = get_overall_ok_polls();
		/*print_r($too_few_given);
		echo"<br/>";
		print_r($too_few_received)."<br />";
		foreach($too_few_given as $too_few_reviewer){
			$reviewer = $too_few_reviewer['Reviewer'];
			echo $reviewer." {";

			$polls = get_candidate_polls_by_reviewer($reviewer);
			if($polls){
				foreach($polls as $poll){
					echo $poll['Reviewee'].",";
				}
			}
			echo "}<br />";
		}
		echo "----------------------------------------<br/>";*/
		$polls = array();
		foreach($too_few_given as $too_few_reviewer){
			foreach($too_few_received as $too_few_reviewee){
				$poll = get_candidate_poll($too_few_reviewer['Reviewer'], $too_few_reviewee['Reviewee']);
				//print_r($poll);
				if($poll){
					if($poll[0]['Ok_overall'] == 0){
						$polls[] = $poll[0];
					}
				}
			}
		}
		$score = -1000;
		$id_best_poll = 0;
		foreach ($polls as $poll) {
			if($score < $poll['Score']){
				$score = $poll['Score'];
				$id_best_poll = $poll['ID'];
			}
		}
		mysql_query("UPDATE candidate_poll SET Ok_overall = 1 WHERE ID = $id_best_poll");

		$reviews_given = get_reviews_given();
		$too_few_given = array();
		$too_many_given = array();
		$exact_given = array();
		if($reviews_given){
			foreach ($reviews_given as $reviews_per_reviewer) { 				// Alle gebruikers die reviews geven
				if($reviews_per_reviewer['Aantal_reviews'] < 5){				// Alle gebruikers die minder dan 5 reviews geven
					$too_few_given[] = $reviews_per_reviewer;
				}else if($reviews_per_reviewer['Aantal_reviews'] > 5){			// Alle gebruikers die meer dan 5 reviews geven
					$too_many_given[] = $reviews_per_reviewer;
				}else if($reviews_per_reviewer['Aantal_reviews'] == 5){			// Alle gebruikers die 5 reviews geven
					$exact_given[] = $reviews_per_reviewer;
				}
			}
		}
		$reviews_received = get_reviews_received();
		$too_few_received = array();
		$too_many_received = array();
		$exact_received = array();
		if($reviews_received){
			foreach ($reviews_received as $reviews_per_reviewee) { 				// Alle gebruikers die reviews krijgen
				if($reviews_per_reviewee['Aantal_reviews'] < 5){				// Alle gebruikers die minder dan 5 reviews krijgen
					$too_few_received[] = $reviews_per_reviewee;
				}else if($reviews_per_reviewee['Aantal_reviews'] > 5){			// Alle gebruikers die meer dan 5 reviews krijgen
					$too_many_received[] = $reviews_per_reviewee;
				}else if($reviews_per_reviewee['Aantal_reviews'] == 5){			// Alle gebruikers die 5 reviews krijgen
					$exact_received[] = $reviews_per_reviewee;
				}
			}
		}
	}
	/*$users = get_users();
	foreach($users as $user){
		$reviewer = $user['ID'];
		echo $reviewer." {";

		$polls = get_candidate_polls_by_reviewer($reviewer);
		if($polls){
			foreach($polls as $poll){
				echo $poll['Reviewee'].",";
			}
		}
		echo "}<br />";
	}
	echo "----------------------------------------<br/>";
	*/

	// Op dit punt hebben we geprobeerd om alle gebruikers met teveel polls en alle gebruikers met teweinig polls in evenwicht te brengen door polls over te brengen.
	// Nu moeten we nog controleren ofdat iederen 5 reviews krijgt
		/*shuffle($users);
		foreach ($users as $user) {
			while(get_reviewee_reviews_received($user['ID'])[0] < 5){
				$polls = get_top_poll_not_overall_reviewee($user['ID']);
				shuffle($polls);
				foreach ($polls as $poll) {
				//echo $poll['cp.ID']."<br />";
					update_best_polls($poll['cp.ID']);
				}
			}
		}*/
	// Op dit moment krijgt elke gebruiker 5 reviews
	// Nu moeten we nog controleren ofdat iederen 5 reviews geeft

	// Hier zit nog een bug in.
		/*shuffle($users);
		foreach ($users as $user) {
			$reviews_given = get_reviewer_reviews_given($user['ID']);
			echo $reviews_given."-";
			while($reviews_given < 5){
				$poll_id = get_top_poll_id_not_overall_reviewer($user['ID']);
				update_best_polls($poll_id);
				$reviews_given = get_reviewer_reviews_given($user['ID']);
			}
			echo get_reviewer_reviews_given($user['ID'])."<br />";
		}*/

	// Tot hier: Iedereen geeft minstens 5 reviews en krijgt minstens 5 reviews

	/**
	  * Gemiddelde score van 1 poll (met Ok_overall) bepalen.
	  *	Voldoet deze aan de minimum waarde? Ok
	  * Voldoet deze niet aan de minimum waarde? Opnieuw berekenen
	  **/
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
	$query = mysql_query("SELECT ID, Reviewee, Score FROM candidate_poll WHERE Ok_reviewee=1 AND Reviewer=$reviewer ORDER BY Score DESC LIMIT 5");
	//echo "SELECT ID, Reviewee, Score FROM candidate_poll WHERE Ok_reviewee=1 AND Reviewer=$reviewer ORDER BY Score DESC LIMIT 5<br />";
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
function update_best_polls($id){
	mysql_query("UPDATE candidate_poll SET Ok_overall = 1 WHERE ID = $id");
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
	$query = mysql_query("SELECT Reviewer, sum(Ok_overall) AS Aantal_reviews FROM candidate_poll GROUP BY Reviewer;");
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
function get_reviewer_reviews_given($reviewer){
	//echo "<$reviewer>";
	$query = mysql_query("SELECT count(*) FROM candidate_poll WHERE Ok_overall = 1 AND Reviewer = $reviewer");
	if(!$query || mysql_num_rows($query) < 0) {
		echo mysql_error();
		return false;
	}else{
		if(mysql_num_rows($query) == 0){
			return 0;
		}
		$result = mysql_result($query, 0);
		return $result;
	}
}
function get_reviews_received(){
	$query = mysql_query("SELECT Reviewee, sum(Ok_overall) AS Aantal_reviews FROM candidate_poll GROUP BY Reviewee;");
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
function get_reviewee_reviews_received($reviewee){
	$query = mysql_query("SELECT count(*) FROM candidate_poll WHERE Ok_overall = 1 AND Reviewee = $reviewee");
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
function get_overall_ok_polls(){
	$query = mysql_query("SELECT count(*) FROM candidate_poll WHERE Ok_overall = 1");
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
function get_not_top_5_best_polls($reviewer){
	$query = mysql_query("SELECT ID, Reviewee, Score FROM candidate_poll WHERE Reviewer=$reviewer ORDER BY Score DESC LIMIT 10 OFFSET 5;");
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
function get_top_poll_not_overall_reviewee($reviewee){
	$query = mysql_query("SELECT cp.ID FROM candidate_poll cp WHERE cp.Reviewee = $reviewee AND cp.Ok_overall = 0 AND cp.Score = (SELECT MAX(Score) FROM candidate_poll WHERE Reviewee=cp.Reviewee AND Ok_overall = 0) LIMIT 1");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$polls[] = array(
				'cp.ID' => $row['ID']
				);
		}
		return $polls;
	}
}
function get_top_poll_id_not_overall_reviewer($reviewer){
	$query = mysql_query("SELECT cp.ID FROM candidate_poll cp WHERE cp.Reviewer = $reviewer AND cp.Ok_overall = 0 AND cp.Score = (SELECT MAX(Score) FROM candidate_poll WHERE Reviewer=cp.Reviewer AND Ok_overall = 0) LIMIT 1");
	if(!$query || mysql_num_rows($query) <= 0) {
		echo mysql_error();
		return false;
	}else{
		$result = mysql_result($query, 0);
		return $result;
	}
}
function get_number_of_reviewers($reviewee){
	$query = mysql_query("SELECT count(*) AS Aantal_reviewers FROM");
}












	function get_candidcate_user_info($id){
		$user 					= get_user_by_id($id);
		$reviews_given 			= get_number_of_candidate_reviews_given($id);
		$reviews_received 		= get_number_of_candidate_reviews_received($id);
		$teammember_reviews		= get_number_of_candidate_poll_team_members($id);
		$notteammember_reviews 	= get_number_of_candidate_poll_not_team_members($id);
		$teammanager_reviews 	= get_number_of_candidate_poll_team_manager($id);
		$notteammanager_reviews = get_number_of_candidate_poll_not_team_manager($id);
		$preferred_reviewers 	= get_number_of_candidate_preferred_reviewers($id);
		$preferred_reviewees 	= get_number_of_candidate_preferred_reviewees($id);
		$questions 				= get_questions();
		echo "
			Heeft <b>$reviews_given</b> review geschreven.
			<br />
			Heeft <b>$reviews_received</b> reviews gekregen.
			<br />
			Krijgt review(s) van <b>$teammember_reviews</b> teamleden.
			<br />
			Krijgt review(s) van <b>$notteammember_reviews</b> niet-teamleden.
			<br />
			Krijgt <b>$teammanager_reviews</b> review(s) van zijn teammanager.
			<br />
			Krijgt <b>$notteammanager_reviews</b> review(s) van andere teammanagers.
			<br />
			<b>$preferred_reviewers</b> van de gebruikers die ".$user['Firstname']." aangaf, mogen ook effectief de vragenlijst over ".$user['Firstname']." invullen.
			<br />
			".$user['Firstname']." mag van <b>$preferred_reviewees</b> gebruikers die zijn had gekozen, ook effectief de vragenlijst invullen.";
	}
	function get_number_of_candidate_reviews_given($id){
		$query = mysql_query("SELECT count(*) AS Aantal_Reviews FROM candidate_reviews_given_view WHERE Reviewer = $id");
		if(!$query || mysql_num_rows($query) <0) {
			echo mysql_error();
			return false;
		}else{
			if(mysql_num_rows($query) == 0){
				return 0;
			}
			return mysql_result($query, 0);
		}
	}
	function get_number_of_candidate_reviews_received($id){
		$query = mysql_query("SELECT count(*) AS Aantal_Reviews FROM candidate_reviews_received_view WHERE Reviewee = $id");
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
	function get_number_of_candidate_poll_team_members($id){
		$query = mysql_query("SELECT count(*) AS Aantal_TeamLeden FROM candidate_teammember_view WHERE Reviewee = $id");
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

	/*function get_number_of_candidate_poll_team_members($id){
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
	}*/
	function get_number_of_candidate_poll_not_team_members($id){
		$query = mysql_query("SELECT count(*) AS Aantal_NietTeamLeden FROM candidate_notteammember_view WHERE Reviewee = $id");
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
	function get_number_of_candidate_poll_team_manager($id){
		$query = mysql_query("SELECT count(*) AS Aantal_TeamManagers FROM candidate_teammanager_view WHERE Reviewee = $id");
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
	function get_number_of_candidate_poll_not_team_manager($id){
		$query = mysql_query("SELECT count(*) AS Aantal_NietTeamManagers FROM candidate_notteammanager_view WHERE Reviewee = $id");
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
	function get_number_of_candidate_preferred_reviewers($id){
		$query = mysql_query("SELECT count(*) AS Aantal_Preferred_Reviewers FROM candidate_preferred_reviewers_view WHERE Reviewee = $id");
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
	function get_number_of_candidate_preferred_reviewees($id){
		$query = mysql_query("SELECT count(*) AS Aantal_Preferred_Reviewees FROM candidate_preferred_reviewees_view WHERE Reviewer = $id");
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
?>