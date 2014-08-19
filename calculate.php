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
				//echo "INSERT INTO candidate_poll (Reviewer, Reviewee) VALUES ($reviewer_id, $reviewee_id));<br />";
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
			//echo $poll['Reviewee'];
			// Reviewee is een manager (kan niet eigen manager zijn, want deze koppels zitten niet in de database)
			$score = rand(-100,-200);
			echo $score;
			update_candidate_poll_score($poll['ID'], (get_candidate_poll_score($poll['ID'])+$score));
		}else{
			// Reviewer is geen manager
			$score = rand(0,10);
			update_candidate_poll_score($poll['ID'], (get_candidate_poll_score($poll['ID'])+$score));
		}
		// Nog informatie over voorkeuren toevoegen.
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
function get_candidate_poll_id_by_reviewer_reviewee_not_overall($reviewer, $reviewee){
	$query = mysql_query("SELECT ID FROM candidate_poll WHERE Reviewer = $reviewer AND Reviewee = $reviewee AND Ok_overall = 0");
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

init($users);
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
	shuffle($users);
	foreach ($users as $user){

		set_best_polls();
		$best_polls_reviewee_reviewer = get_best_polls_reviewee_reviewer($user['ID']);
		if($best_polls_reviewee_reviewer){
			shuffle($best_polls_reviewee_reviewer);
			foreach ($best_polls_reviewee_reviewer as $poll) {
				$id = $poll['ID'];
				mysql_query("UPDATE candidate_poll SET Ok_overall=1 WHERE ID = $id");
			}
		}

		$reviews_given = get_reviews_given();
		if($reviews_given){
			shuffle($reviews_given);
			foreach ($reviews_given as $too_few) { 				// Alle gebruikers die reviews geven
				if($too_few['Aantal_reviews'] < 5){				// Alle gebruikers die minder dan 5 reviews geven
					shuffle($reviews_given);
					foreach ($reviews_given as $too_much) { 	// Alle gebruikers die reviews geven
						if($too_much['Aantal_reviews'] > 5){ 	// Alle gebruikers die meer dan 5 reviews geven
							/**
							  * Van de gebruikers die teveel reviews geven, alle 'extra' reviews opvragen (de top_reviews, die niet de 5 beste zijn)
							  * Dan alle gebruikers overlopen die te weinig reviews geven
							  * Per gebruiker de beste review kiezen en deze koppelen aan de de gebruiker die te weinig reviews geeft
							  **/
							$best_poll_score = 0;
							$best_poll = 0;
							$not_top_5_polls = get_not_top_5_best_polls($too_much['Reviewer']);
							// Deze code moet wel nog in een lus komen te staan, while($too_few['Aantal_reviews'] < 5)
							foreach ($not_top_5_polls as $poll) {
								// Hierin moet nu de score van $poll vergeleken worden met de score van de poll bestaande uit $too_few['ID'] en $poll['Reviewee']
								$candidate_poll = get_candidate_poll_id_by_reviewer_reviewee_not_overall($too_few['Reviewer'], $poll['Reviewee']); // candidate_poll id ophalen met behulp van reviewer en reviewee
								if($candidate_poll){
									$poll_score = get_candidate_poll_score($candidate_poll[0]); // De score van de hierboven genoemde poll ophalen
									if($best_poll_score < $poll_score){
										// Hierin gaan we de poll met de beste score ophalen
										$best_poll_socre = $poll_score;
										$best_poll = $candidate_poll;
									}
								}
							}
						}
					}	  
				}
			}
		}
	}
	// Op dit punt hebben we geprobeerd om alle gebruikers met teveel polls en alle gebruikers met teweinig polls in evenwicht te brengen door polls over te brengen.
	// Nu moeten we nog controleren ofdat iederen 5 reviews krijgt
	shuffle($users);
	foreach ($users as $user) {
		while(get_reviewee_reviews_received($user['ID'])[0] < 5){
			$polls = get_top_poll_not_overall_reviewee($user['ID']);
			shuffle($polls);
			foreach ($polls as $poll) {
				//echo $poll['cp.ID']."<br />";
				update_best_polls($poll['cp.ID']);
			}
		}
	}
	// Op dit moment krijgt elke gebruiker 5 reviews
	// Nu moeten we nog controleren ofdat iederen 5 reviews geeft
	shuffle($users);
	foreach ($users as $user) {
		if(get_reviewer_reviews_given($user['ID'])[0] < 5){
			echo get_reviewer_reviews_given($user['ID'])[0]."-";
			$polls = get_top_poll_not_overall_reviewer($user['ID']);
			print_r($polls)."<br />";
			shuffle($polls);
			foreach ($polls as $poll) {
				//update_best_polls($poll['cp.ID']);
			}
			echo get_reviewer_reviews_given($user['ID'])[0]."<br />";
		}
	}

	// Tot hier: Iedereen geeft minstens 5 reviews en krijgt minstens 5 reviews

	/**
	  * Gemiddelde score van 1 poll (met Ok_overall) bepalen.
	  *	Voldoet deze aan de minimum waarde? Ok
	  * Voldoet deze niet aan de minimum waarde? Opnieuw berekenen
	  **/
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
function get_reviewer_reviews_given($reviewer){
	$query = mysql_query("SELECT count(*) FROM candidate_poll WHERE Ok_overall = 1 AND Reviewer = $reviewer");
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
function get_top_poll_not_overall_reviewer($reviewer){
	$query = mysql_query("SELECT cp.ID FROM candidate_poll cp WHERE cp.Reviewer = $reviewer AND cp.Ok_overall = 0 AND cp.Score = (SELECT MAX(Score) FROM candidate_poll WHERE Reviewer=cp.Reviewer AND Ok_overall = 0) LIMIT 1");
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









function get_number_of_reviewers($reviewee){
	$query = mysql_query("SELECT count(*) AS Aantal_reviewers FROM");
}
?>