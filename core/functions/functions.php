<?php
error_reporting(0);
ob_start();
function add_batch(){
	$date = create_date();
	mysql_query("INSERT INTO batch (Init_date, Running1_date, Running2_date, Finished_date, Status) VALUES ('$date', NULL, NULL, NULL, (SELECT ID FROM batch_status WHERE Name = 'Init'))");
	header('Location: '.$_SERVER['PHP_SELF']);
	exit();
}
function add_comment($reviewee, $comment){
	$reviewee = (int) $reviewee;
	$comment = sanitize($comment);
	$reviewer = (int) $_SESSION['user_id'];
	$batch = get_running2_batch_id();
	$date = create_date();
	$poll_status = mysql_result(mysql_query("SELECT ID FROM poll_status WHERE Name = 'Commentaar'"),0);
	mysql_query("INSERT INTO Poll (Reviewer, Reviewee, Comment, Status, Time_Created, Last_Update, Batch) VALUES ($reviewer, $reviewee, '$comment', $poll_status, '$date', '$date', $batch) ON DUPLICATE KEY UPDATE Comment = '$comment', Last_Update = '$date'");
	echo mysql_error();
}
function add_department($name, $manager){
	$name = sanitize($name);
	$manager = (int) $manager;
	mysql_query("INSERT INTO department (Name, Manager) VALUES ('$name', $manager) ON DUPLICATE KEY UPDATE Name = '$name', Manager = $manager");
	header('Location: '.$_SERVER['PHP_SELF'].'?AddDepartment');
	exit();
}
function add_poll_comment($poll, $comment){
	$poll = (int) $poll;
	$comment = sanitize($comment);
	mysql_query("UPDATE poll SET Comment = '$comment' WHERE ID = $poll");
}
function add_question($question, $category){
	$question = sanitize($question);
	$category = sanitize($category);
	mysql_query("INSERT INTO question (Category, Question) VALUES ((SELECT ID FROM category WHERE Name = '$category'), '$question')");
	echo mysql_error();
	header('Location: '.$_SERVER['PHP_SELF']);
	exit();
}
function add_user($firstname, $lastname, $department, $email, $job_title){
	$firstname = sanitize($firstname);
	$lastname = sanitize($lastname);
	$department = sanitize($department);
	$username = $lastname.'.'.$firstname;
	$password = password_hash(randomPassword(),PASSWORD_DEFAULT);
	$email = sanitize($email);
	$job_title = sanitize($job_title);
	mysql_query("INSERT INTO user (Firstname, Lastname, Username, Password, Email, Job_Title) VALUES ('$firstname', '$lastname', '$username', '$password', '$email', '$job_title') ON DUPLICATE KEY UPDATE Firstname = '$firstname', Lastname = '$lastname', Username = '$username', Password = '$password', Email = '$email', Job_Title = '$job_title'");
	$id = mysql_insert_id();
	mysql_query("INSERT INTO user_department (User, Department) VALUES ((SELECT ID FROM user WHERE Username = '$username'), (SELECT ID FROM Department WHERE Name = '$department')) ON DUPLICATE KEY UPDATE User = (SELECT ID FROM user WHERE Username = '$username'), Department = (SELECT ID FROM Department WHERE Name = '$department')");
	mysql_error();
	header('Location: '.$_SERVER['PHP_SELF'].'?AddUser');
	exit();
}
function create_date(){
	$time = time();
	$date = date("Y-m-d H:i:s", $time);
	return $date;
}
function delete_comment($id){
	$id = (int) $id;
	$reviewer = (int)$_SESSION['user_id'];
	mysql_query("DELETE FROM poll WHERE ID = $id and Reviewer = $reviewer");
	header('Location: index.php?Start');
	exit();
}
function delete_department($id){
	$id = (int) $id;
	mysql_query("DELETE FROM department WHERE ID = $id");
	header('Location: '.$_SERVER['PHP_SELF']);
	exit();
}
function delete_preferred_reviewer($user){
	$user = sanitize($user);
	$id = get_id_by_username($user);
	$batch = get_running1_batch_id();
	mysql_query("DELETE FROM preferred_poll WHERE User = $id AND Reviewee = $id AND Batch = $batch");
}
function delete_preferred_reviewee($user){
	$user = sanitize($user);
	$id = get_id_by_username($user);
	$batch = get_running1_batch_id();
	mysql_query("DELETE FROM preferred_poll WHERE User = $id AND Reviewer = $id AND Batch = $batch");
}
function delete_question($id){
	$id = (int) $id;
	mysql_query("DELETE FROM answer WHERE Question = $id");
	mysql_query("DELETE FROM question WHERE ID = $id");
	echo mysql_error();
	header('Location: '.$_SERVER['PHP_SELF']);
	exit();
}
function delete_user($id){
	$id = (int) $id;
	mysql_query("DELETE FROM user_department WHERE User = $id");
	mysql_query("DELETE FROM user WHERE ID = $id");
	header('Location: '.$_SERVER['PHP_SELF']);
	exit();
}
function edit_parameter($parameter, $value){
	$parameter = (int) $parameter;
	$value = (int) $value;
	mysql_query("UPDATE parameter SET Value = $value WHERE ID = $parameter");
}
function get_all_poll_statuses(){
	$query = mysql_query("SELECT * FROM poll_status ORDER BY ID");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$statuses[] = array(
				'ID' => $row['ID'],
				stripslashes('Name') => $row['Name']
				);
		}
		return $statuses;
	}
}
function get_answer($poll, $question){
	$poll = (int) $poll;
	$question = (int) $question;
	$query = mysql_query("SELECT Answer FROM answer WHERE Poll = $poll AND Question = $question");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_answer_name($value){
	$value = (int) $value;
	$query = mysql_query("SELECT Name FROM answer_enum WHERE ID = $value");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_answer_value_by_name($name){
	$name = sanitize($name);
	$query = mysql_query("SELECT ID FROM answer_enum WHERE Name = '$name'");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_answers($poll){
	$poll = (int) $poll;
	$query = mysql_query("SELECT * FROM answer WHERE poll = $poll ORDER BY Question ASC");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$answers[] = array(
				'ID' => $row['ID'],
				'Poll' => $row['Poll'],
				'Question' => $row['Question'],
				stripslashes('Answer') => $row['Answer'],
				'Last_Update' => $row['Last_Update']
				);
		}
		return $answers;
	}
}
function get_average_score_poll($poll, $question){
	$poll = (int) $poll;
	$question = (int) $question;
	$batch = get_running2_batch_id();
	$query = mysql_query("SELECT Average_Score FROM average_score_view WHERE Batch = $batch AND Poll = $poll AND Question = $question");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_batch($status){
	$status = sanitize($status);
	$query = mysql_query("SELECT ID FROM batch WHERE Name = '$status'");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_batch_status_name($status_id){
	$status_id = (int) $status_id;
	$query = mysql_query("SELECT Name FROM batch_status WHERE Id = $status_id");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_batches(){
	$query = mysql_query("SELECT * FROM batch");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$categories[] = array(
				'ID' => $row['ID'],
				'Init_date' => $row['Init_date'],
				'Running1_date' => $row['Running1_date'],
				'Running2_date' => $row['Running2_date'],
				'Finished_date' => $row['Finished_date'],
				'Status' => $row['Status'],
				'Comment' => $row['Comment']
				);
		}
		return $categories;
	}
}
function get_calculating_batch_id(){
	$query = mysql_query("SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Calculate')");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_categories(){
	$query = mysql_query("SELECT * FROM category");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$categories[] = array(
				'ID' => $row['ID'],
				stripslashes('Name') => $row['Name']
				);
		}
		return $categories;
	}
}
function get_comment($poll){
	$poll = (int) $poll;
	$query = mysql_query("SELECT Comment FROM poll WHERE ID = $poll");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_department_by_id($id){
	$id = (int) $id;
	$query = mysql_query("SELECT * FROM department WHERE ID = $id");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		return mysql_fetch_assoc($query);
	}
}
function get_department_name($id){
	$id = (int) $id;
	$query = mysql_query("SELECT Name FROM department WHERE ID = $id");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query, 0);
	}
}
function get_departments(){
	$query = mysql_query("SELECT * FROM department");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$categories[] = array(
				'ID' => $row['ID'],
				stripslashes('Name') => $row['Name'],
				'Manager' => $row['Manager']
				);
		}
		return $categories;
	}
}
function get_id_by_username($username){
	$username = sanitize($username);
	$query = mysql_query("SELECT ID FROM user WHERE Username = '$username'");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_init_batch_id(){
	$query = mysql_query("SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init')");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_managers(){
	$categories = array();
	$query = mysql_query("SELECT ID FROM user_department WHERE Department = (SELECT ID FROM department WHERE Name = 'Management')");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$categories[] = $row['ID'];
		}
		return $categories;
	}
}
function get_managers_info(){
	$query = mysql_query("SELECT ID, Firstname, Lastname, Username FROM user WHERE ID IN (SELECT User FROM user_department WHERE Department = (SELECT ID FROM department WHERE Name = 'Management'))");
	echo mysql_error();
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$managers[] = array(
				'ID' => $row['ID'],
				stripslashes('Firstname') => $row['Firstname'],
				stripslashes('Lastname') => $row['Lastname'],
				stripslashes('Username') => $row['Username'],
				);
		}
		return $managers;
	}
}
function get_not_reviewed_users($reviewer){
	$reviewer = (int) $reviewer;
	$query = mysql_query("SELECT ID, Firstname, Lastname FROM user WHERE ID NOT IN (SELECT Reviewee FROM poll WHERE Reviewer = $reviewer)");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$users[] = array(
				'ID' => $row['ID'],
				stripslashes('Firstname') => $row['Firstname'],
				stripslashes('Lastname') => $row['Lastname']
				);
		}
		return $users;
	}
}
function get_number_of_users(){
	$query = mysql_query("SELECT count(ID) FROM user");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_only_comment_polls($reviewer, $batch){
	$reviewer = (int) $reviewer;
	$batch = (int) $batch;
	$query = mysql_query("SELECT ID, Reviewee, Comment, Status FROM poll WHERE Status = (SELECT ID FROM poll_status WHERE Name = 'Commentaar') AND Reviewer = $reviewer AND Batch = $batch");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$polls[] = array(
				'ID' => $row['ID'],
				'Reviewee' => $row['Reviewee'],
				stripslashes('Comment') => $row['Comment'],
				'Status' => $row['Status']
				);
		}
		return $polls;
	}
}
function get_parameters(){
	$query = mysql_query("SELECT * FROM parameter;");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$parameters[] = array(
				'ID' => $row['ID'],
				stripslashes('Short_Name') => $row['Short_name'],
				stripslashes('Name') => $row['Name'],
				'Value' => $row['Value'],
				stripslashes('Comment') => $row['Comment']
				);
		}
		return $parameters;
	}
}
function get_poll_by_reviewer_reviewee_batch($reviewer, $reviewee, $batch){
	$reviewer = (int) $reviewer;
	$reviewee = (int) $reviewee;
	$batch = (int) $batch;
	$query = mysql_query("SELECT ID FROM poll WHERE Reviewer = $reviewer AND Reviewee = $reviewee AND Batch = $batch");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_poll_reviewee($poll){
	$poll = (int) $poll;
	$query = mysql_query("SELECT Reviewee FROM poll WHERE ID = $poll");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_poll_reviewer($poll){
	$poll = (int) $poll;
	$query = mysql_query("SELECT Reviewer FROM poll WHERE ID = $poll");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_candidate_poll_reviewee($poll){
	$poll = (int) $poll;
	$query = mysql_query("SELECT Reviewee FROM candidate_poll WHERE ID = $poll");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_candidate_poll_reviewer($poll){
	$poll = (int) $poll;
	$query = mysql_query("SELECT Reviewer FROM candidate_poll WHERE ID = $poll");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_poll_status($poll){
	$poll = (int) $poll;
	$query = mysql_query("SELECT Status FROM poll WHERE ID = $poll");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_poll_status_id($poll_status){
	$poll_status = sanitize($poll_status);
	$query = mysql_query("SELECT ID FROM poll_status WHERE Name = '$poll_status'");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_polls(){
	$query = mysql_query("SELECT * FROM poll");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$polls[] = array(
				'ID'			=> $row['ID'],
				'Reviewer' 		=> $row['Reviewer'],
				'Reviewee'		=> $row['Reviewee'],
				'Comment'		=> $row['Comment'],
				'Status'		=> $row['Status'],
				'Time_Created'	=> $row['Time_Created'],
				'Last_Update'	=> $row['Last_Update']
				);
		}
		return $polls;
	}
}
function get_polls_by_reviewer($reviewer, $batch){
	$reviewer = (int) $reviewer;
	$batch = (int) $batch;
	$query = mysql_query("SELECT * FROM poll WHERE Reviewer = $reviewer AND Reviewee != $reviewer AND Status != (SELECT ID FROM poll_status WHERE Name = 'Commentaar') AND Batch = $batch");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$polls[] = array(
				'ID' => $row['ID'],
				'Reviewer' => $row['Reviewer'],
				'Reviewee' => $row['Reviewee'],
				'Comment' => $row['Comment'],
				'Status' => $row['Status'],
				'Time_Created' => $row['Time_Created'],
				'Last_Update' => $row['Last_Update'],
				'Batch' => $row['Batch']
				);
		}
		return $polls;
	}
}
function get_preferred_polls($batch){
	$batch = (int) $batch;
	$query = mysql_query("SELECT * FROM preferred_poll WHERE Batch = $batch");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$polls[] = array(
				'ID'			=> $row['ID'],
				'Reviewer' 		=> $row['Reviewer'],
				'Reviewee'		=> $row['Reviewee'],
				'User'		=> $row['User'],
				'Batch'		=> $row['Batch']
				);
		}
		return $polls;
	}
}
function get_published_batch_id(){
	$query = mysql_query("SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Published')");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_questions(){
	$query = mysql_query("SELECT * FROM question ORDER BY Category, ID");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$questions[] = array(
				'ID' => $row['ID'],
				html_entity_decode(stripslashes('Question')) => $row['Question'],
				'Category' => $row['Category']
				);
		}
		return $questions;
	}
}
function get_running1_batch_id(){
	$query = mysql_query("SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Running1')");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_running2_batch_id(){
	$query = mysql_query("SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Running2')");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_stopped_batch_id(){
	$query = mysql_query("SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Finished')");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_text($name){
	$name = sanitize($name);
	$query = mysql_query("SELECT Text FROM text_nl WHERE Name = '$name'");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_text_info($name){
	$name = sanitize($name);
	$query = mysql_query("SELECT * FROM text_nl WHERE Name = '$name'");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$questions[] = array(
				'ID' => $row['ID'],
				stripslashes('Name') => $row['Name'],
				stripslashes('Text') => $row['Text'],
				stripslashes('Comment') => $row['Comment']
				);
		}
		return $questions;
	}
}
function get_user_by_id($id){
	$id = (int) $id;
	$query = mysql_query("SELECT Firstname, Lastname FROM user WHERE ID = $id");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_fetch_row($query,0);
	}
}
function get_admin_by_id($id){
	$id = (int) $id;
	$query = mysql_query("SELECT Username FROM admin WHERE ID = $id");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_fetch_row($query,0);
	}
}
function get_user_department($id){
	$id = (int) $id;
	$query = mysql_query("SELECT Department FROM user_department WHERE User = $id");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_user_email($user){
	$user = sanitize($user);
	$id = get_user_id($user);
	$query = mysql_query("SELECT Email FROM user WHERE ID = $id");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_user_email_by_id($id){
	$id = (int) $id;
	$query = mysql_query("SELECT Email FROM user WHERE ID = $id");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_admin_email($admin){
	$admin = sanitize($admin);
	$id = get_admin_id($admin);
	$query = mysql_query("SELECT Email FROM admin WHERE ID = $id");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_user_id($user){
	$user = sanitize($user);
	$query = mysql_query("SELECT ID FROM user WHERE UPPER(Username) = UPPER('$user')");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_admin_id($admin){
	$admin = sanitize($admin);
	$query = mysql_query("SELECT ID FROM admin WHERE UPPER(Username) = UPPER('$admin')");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_user_type_id($type){
	$type = sanitize($type);
	$query = mysql_query("SELECT ID FROM user_type WHERE Name = '$type'");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function get_username_by_id($id){
	$id = (int) $id;
	$query = mysql_query("SELECT Username FROM user WHERE ID = $id");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}	
function get_users(){
	$query = mysql_query("SELECT * FROM user ORDER BY Lastname ASC");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$users[] = array(
				'ID' => $row['ID'],
				stripslashes('Firstname') => $row['Firstname'],
				stripslashes('Lastname') => $row['Lastname'],
				stripslashes('Username') => $row['Username'],
				stripslashes('Job_Title') => $row['Job_Title']
				);
		}
		return $users;
	}
}	
function get_users_order_by_id(){
	$query = mysql_query("SELECT * FROM user");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$users[] = array(
				'ID' => $row['ID'],
				stripslashes('Firstname') => $row['Firstname'],
				stripslashes('Lastname') => $row['Lastname'],
				stripslashes('Username') => $row['Username'],
				stripslashes('Job_Title') => $row['Job_Title']
				);
		}
		return $users;
	}
}
function get_users_not_answered_own_questions(){
	$batch = get_running1_batch_id();
	$query = mysql_query("	SELECT *
							FROM user
							WHERE
							ID = ANY(
								SELECT Reviewer
								FROM poll
								WHERE
								Reviewer = Reviewee
								AND
								Batch = $batch
								AND
								Status = (
									SELECT ID
									FROM poll_status
									WHERE Name = 'Niet Ingevuld'
								)
							)
							ORDER BY Lastname
						");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$users[] = array(
				'ID' => $row['ID'],
				stripslashes('Firstname') => $row['Firstname'],
				stripslashes('Lastname') => $row['Lastname'],
				stripslashes('Username') => $row['Username'],
				stripslashes('Email') => $row['Email'],
				stripslashes('Job_Title') => $row['Job_Title']
				);
		}
		return $users;
	}
}
function get_users_not_answered_other_questions(){
	$batch = get_running2_batch_id();
	$query = mysql_query("	SELECT *
							FROM user
							WHERE
							ID = ANY(
								SELECT Reviewer
								FROM poll
								WHERE
								Reviewer != Reviewee
								AND
								Batch = $batch
								AND
								Status = (
									SELECT ID
									FROM poll_status
									WHERE Name = 'Niet Ingevuld'
								)
							)
							ORDER BY Lastname
						");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$users[] = array(
				'ID' => $row['ID'],
				stripslashes('Firstname') => $row['Firstname'],
				stripslashes('Lastname') => $row['Lastname'],
				stripslashes('Username') => $row['Username'],
				stripslashes('Email') => $row['Email'],
				stripslashes('Job_Title') => $row['Job_Title']
				);
		}
		return $users;
	}
}
function is_manager($user){
	$user = (int) $user;
	$query = mysql_query("SELECT count(*) FROM department WHERE Manager = $user");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function randomPassword() {
	$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
	$pass = array(); //remember to declare $pass as an array
	$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	for ($i = 0; $i < 8; $i++) {
		$n = rand(0, $alphaLength);
		$pass[] = $alphabet[$n];
	}
	return implode($pass); //turn the array into a string
}
function resend_password($user){
	$user = sanitize($user);
	$password = randomPassword();
	echo $password;
	$email = get_user_email($user);
	$id = get_user_id($user);
	$user = get_user_by_id($id);
	$to = $email;
	$subject = get_text('New_password');
	$message = 
		get_text('Dear').' '.$user[0].",
		<p>
			" . get_text('New_user_credentials') . ":
			<br />
			" . get_text('Username') . ": ".$user[0].".".$user[1]."
			<br />
			" . get_text('Password') . ": ".$password."
		</p>". get_text('Mail_footer');
	mail($to, $subject, $message);
	$hashed_password = password_hash($password,PASSWORD_DEFAULT);
	mysql_query("UPDATE user SET Password = '$hashed_password' WHERE ID = $id");
	return get_text('New_password_send');
}
function resend_admin_password($admin){
	$admin = sanitize($admin);
	$password = randomPassword();
	echo $password;
	$email = get_admin_email($admin);
	$id = get_admin_id($admin);
	$admin = get_admin_by_id($id);
	$to = $email;
	$subject = get_text('New_password');
	$message = 
		get_text('Dear').' '.$admin[0].",
		<p>
			" . get_text('New_user_credentials') . ":
			<br />
			" . get_text('Username') . ": ".$admin[0]."
			<br />
			" . get_text('Password') . ": ".$password."
		</p>".get_text('Mail_footer');
	mail($to, $subject, $message);
	$hashed_password = password_hash($password,PASSWORD_DEFAULT);
	mysql_query("UPDATE admin SET Password = '$hashed_password' WHERE ID = $id");
	return get_text('New_password_send');
}
function save_department($id, $name, $manager){
	$id = (int) $id;
	$name = sanitize($name);
	$manager = (int) $manager;
	mysql_query("UPDATE department SET Name = '$name', Manager = $manager WHERE ID = $id");
	header('Location: '.$_SERVER['PHP_SELF']);
	exit();
}
function save_question($id, $question){
	$id = (int) $id;
	$question = sanitize($question);
	mysql_query("UPDATE question SET Question = '$question' WHERE ID = $id");
	header('Location: '.$_SERVER['PHP_SELF']);
}
function save_user($id, $firstname, $lastname, $email, $department){
	$id = (int) $id;
	$firstname = sanitize($firstname);
	$lastname = sanitize($lastname);
	$email = sanitize($email);
	$department = sanitize($department);
	mysql_query("UPDATE user SET Firstname = '$firstname', Lastname = '$lastname', Email = '$email' WHERE ID = $id");
	mysql_query("UPDATE user_department SET Department = (SELECT ID FROM department WHERE Name = '$department') WHERE User = $id");
	echo mysql_error();
	header('Location: '.$_SERVER['PHP_SELF']);
	exit();
}

function create_poll($reviewer, $reviewee, $status){
	$reviewer = sanitize($reviewer);
	$reviewee = sanitize($reviewee);
	$status = (int) $status;
	$date = create_date();
	$batch = get_running2_batch_id();
	$query = mysql_query("SELECT * FROM poll WHERE Reviewer = (SELECT ID FROM user WHERE UPPER(Username) = UPPER('$reviewer')) AND Reviewee = (SELECT ID FROM user WHERE UPPER(Username) = UPPER('$reviewee')) AND Batch = $batch");
	if(!$query || mysql_num_rows($query)>0 || mysql_num_rows($query) < 0){
		if(mysql_num_rows($query) > 0) {
			return get_text('Poll_already_exists');
		}else{
			return mysql_error();
		}
	}else{
		$query = mysql_query("INSERT INTO poll (Reviewer, Reviewee, Status, Time_Created, Last_Update, Batch) VALUES ((SELECT ID FROM user WHERE UPPER(Username) = UPPER('$reviewer')),(SELECT ID FROM user WHERE UPPER(Username) = UPPER('$reviewee')), (SELECT ID FROM poll_status WHERE Name = '$status'), '$date', '$date', $batch)");
		if(!$query) {
			return mysql_error();
		}else{
			$text = get_text('Poll').' '.strtolower(get_text('Added'));
			return $text;
		}
	}
}
function answer($poll, $question, $answer){
	$poll = (int) $poll;
	$question = (int) $question;
	$answer = sanitize($answer);
	$date = create_date();
	$query = mysql_query("INSERT INTO answer (Poll, Question, Answer, Time_Created, Last_Update) VALUES ($poll, $question, $answer, '$date', '$date') ON DUPLICATE KEY UPDATE Answer = $answer, Last_Update = '$date'");
	if(!$query) {
		echo mysql_error();
	}else{
		/*echo get_text('Question').' '.strtolower(get_text('Answered'));*/
	}
	$query = mysql_query("UPDATE poll SET Last_Update = '$date' WHERE ID = $poll");
	if(!$query) {
		echo mysql_error();
	}else{
		/*echo get_text('Question').' '.strtolower(get_text('Answered'));*/
	}
}
function init_batch($batch){
}
function start_batch($batch){
	$users = get_users();
	$date = create_date();
	$batch = (int) $batch;
	foreach ($users as $user) {
		$password = password_hash(randomPassword(),PASSWORD_DEFAULT);
		$id = (int) $user['ID'];
		mysql_query("UPDATE user SET Password = '$password' WHERE ID = $id");
		$reviewer = (int) $user['ID'];
		$reviewee = (int) $user['ID'];
		mysql_query("INSERT INTO poll (Reviewer, Reviewee, Status, Time_Created, Last_Update, Batch) VALUES ($reviewer, $reviewee , (SELECT ID FROM poll_status WHERE Name = 'Niet Ingevuld'), '$date', '$date', $batch)");
	}
	mysql_query("UPDATE batch SET Status = (SELECT ID FROM batch_status WHERE Name = 'Running1'), Running1_date = '$date' WHERE ID = $batch");
	foreach ($users as $user) {
		$to = $user['Email'];
		$subject = get_text('Start_phase_1');
		$message = 
			get_text('Dear').' '.$user['Firstname'].",".
			get_text('Mail_phase_1').get_text('Mail_footer');
		mail($to, $subject, $message);
	}
}
function calculate_couples($id){
	$polls = get_polls();
	foreach ($polls as $poll) {
		mysql_query("UPDATE poll SET Status = (SELECT ID FROM poll_status WHERE Name = 'Ingestuurd') WHERE Status = (SELECT ID FROM poll_status WHERE Name = 'Opgeslagen')");
	}
	//init($users);
	$id = (int) $id;
	$success = 0;
	$iteration = 0;
	$users = get_users_order_by_id();
	while ($success == 0) {		
		//echo "Nieuwe berekening starten<br />";
		calculate_possible_polls($users);
		$success = 1;
		foreach ($users as $user) {
			if(get_number_of_candidate_reviews_given($user['ID']) < mysql_result(mysql_query("SELECT Value FROM parameter WHERE Short_name = 'Reviews_to_give'"),0)){
				$success = 0;
				//echo "Oorzaak: if te weinig reviews geven, user: ".$user['ID'].'<br />';
				break;
			}
			if(get_number_of_candidate_reviews_received($user['ID']) < mysql_result(mysql_query("SELECT Value FROM parameter WHERE Short_name = 'Reviews_to_receive'"),0)){
				$success = 0;
				//echo "Oorzaak: if te weinig reviews krijgen, user: ".$user['ID'].'<br />';
				break;
			}
			/*if(get_number_of_candidate_poll_managers($user['ID']) > mysql_result(mysql_query("SELECT Value FROM parameter WHERE Short_name = 'Reviews_by_not_teammanager'"),0)){
				$success = 0;
				//echo "Oorzaak: if Maximum aantal reviews door (niet eigen) manager, user: ".$user['ID'].'<br />';
				break;
			}*/
			if(get_number_of_candidate_poll_team_members($user['ID']) > mysql_result(mysql_query("SELECT Value FROM parameter WHERE Short_name = 'Reviews_own_department'"),0)){
				$success = 0;
				//echo "Oorzaak: if Maximum aantal reviews uit eigen departement, user: ".$user['ID'].'<br />';
				break;
			}
		}
	}
	mysql_query("UPDATE batch SET Status = (SELECT ID FROM batch_status WHERE Name = 'Calculate') WHERE ID = $id");
	/*mysql_query("INSERT INTO poll (Reviewer, Reviewee, Status, Time_created, Last_update, Batch) VALUES ((SELECT Reviewer FROM preferred_poll),(SELECT Reviewee FROM preferred_poll),(SELECT ID FROM poll_status WHERE Name = 'Niet Ingevuld'),'$date','$date', $batch)");
	$date = create_date();*/
}
function accept_calculated_polls($id){
	$date = create_date();
	$batch = get_calculating_batch_id();
	$polls = get_ok_overall_candidate_polls();
	if($polls){
		foreach ($polls as $poll) {
			$reviewer = (int) $poll['Reviewer'];
			$reviewee = (int) $poll['Reviewee'];
			mysql_query("INSERT INTO poll (Reviewer, Reviewee, Status, Time_created, Last_update, Batch) VALUES($reviewer, $reviewee, (SELECT ID FROM poll_status WHERE Name = 'Niet Ingevuld'), '$date','$date',$batch)");
			echo mysql_error();
		}
	}
	mysql_query("UPDATE batch SET Status = (SELECT ID FROM batch_status WHERE Name = 'Accepted') WHERE ID = $id");
	header('Location: admin.php');
}
function run_batch($id){
	$id = (int) $id;
	$users = get_users();
	$date = create_date();
	mysql_query("UPDATE batch SET Status = (SELECT ID FROM batch_status WHERE Name = 'Running2'), Running2_date = '$date' WHERE ID = $id");
	foreach ($users as $user) {
		$to = $user['Email'];
		$subject = get_text('Start_phase_2');
		$message = 
			get_text('Dear').' '.$user['Firstname'].","
			.get_text('Mail_phase_2').get_text('Mail_footer');
		mail($to, $subject, $message);
	}
}
function publish_batch($id){
	$id = (int) $id;
	$users = get_users();
	$date = create_date();
	mysql_query("UPDATE batch SET Status = (SELECT ID FROM batch_status WHERE Name = 'Published'), Finished_date = '$date' WHERE ID = $id");
	foreach ($users as $user) {
		$to = $user['Email'];
		$subject = get_text('Results_available');
		$message = 
			get_text('Dear').' '.$user['Firstname'].","
			.get_text('Mail_results_available').get_text('Mail_footer');
		mail($to, $subject, $message);
	}

}
function stop_batch($id){
	$id = (int) $id;
	$date = create_date();
	mysql_query("UPDATE batch SET Status = (SELECT ID FROM batch_status WHERE Name = 'Finished'), Finished_date = '$date' WHERE ID = $id");
}
function add_preferred($reviewer, $reviewee, $user){
	$reviewer = sanitize($reviewer);
	$reviewee = sanitize($reviewee);
	$user = sanitize($user);
	$batch = get_running1_batch_id();
	if($reviewer == $reviewee){
		echo get_text('Prohibited_to_prefer_yourself');
	}else{
		$query = mysql_query("	SELECT *
			FROM preferred_poll
			WHERE 
				Reviewer = (SELECT ID FROM user WHERE UPPER(Username) = UPPER('$reviewer'))
				AND
				Reviewee = (SELECT ID FROM user WHERE UPPER(Username) = UPPER('$reviewee'))
				AND
				User = (SELECT ID FROM user WHERE UPPER(Username) = UPPER('$user'))
				AND
				Batch = $batch
				
		");
		if(!$query || mysql_num_rows($query) < 0){
			echo mysql_error();
		}else if(mysql_num_rows($query) == 0){
			$query = mysql_query("	INSERT INTO preferred_poll (Reviewer, Reviewee, User, Batch) VALUES (
										(SELECT ID FROM user WHERE UPPER(Username) = UPPER('$reviewer')),
										(SELECT ID FROM user WHERE UPPER(Username) = UPPER('$reviewee')),
										(SELECT ID FROM user WHERE UPPER(Username) = UPPER('$user')),
										$batch
									)
									ON DUPLICATE KEY UPDATE
									Reviewer = 	(SELECT ID FROM user WHERE UPPER(Username) = UPPER('$reviewer')),
									Reviewee = 	(SELECT ID FROM user WHERE UPPER(Username) = UPPER('$reviewee')),
									User = 		(SELECT ID FROM user WHERE UPPER(Username) = UPPER('$user')),
									Batch =		$batch
								");
			if(!$query){
				echo mysql_error();
			}else{
						//echo get_Text('Preference').' '.strtolower('Added');
			}
		}else if(mysql_num_rows($query) > 0){
				//echo "Deze voorkeur werd al ingegeven";
		}
	}
}
function change_poll_status($poll, $status){
	$poll = (int) $poll;
	$status = sanitize($status);
	$date = create_date();
	$query = mysql_query("UPDATE poll SET Status = (SELECT ID FROM poll_status WHERE Name = '$status'), Last_Update = '$date' WHERE ID = $poll");
}
function send_reminder_phase1($user, $email){
	$user = sanitize($user);
	$email = sanitize($email);
	$to = $email;
	$subject = get_text('Reminder');
	$message = get_text('Dear').' '.$user.","
	.get_text('Reminder_own_poll').get_text('Mail_footer');
	mail($to, $subject, $message);
}
function send_reminder_phase2($user, $email){
	$user = sanitize($user);
	$email = sanitize($email);
	$to = $email;
	$subject = get_text('Reminder');
	$message = get_text('Dear').' '.$user.",".
		get_text('Reminder_other_polls').get_text('Mail_footer');
	mail($to, $subject, $message);
}


function login($username, $password, $rememberme){
	$username = sanitize($username);
	$password = sanitize($password);
	$rememberme = sanitize($rememberme);
	if(get_running1_batch_id() || get_running2_batch_id() || get_published_batch_id()){
		$query = mysql_query("SELECT ID, Password FROM user WHERE UPPER(Username) = UPPER('$username')");
		if(!$query || mysql_num_rows($query) <= 0){
				//echo mysql_error();
			return get_text('Error_occured').get_text('Do_you_have_account');
		}else{
			$user = mysql_fetch_row($query);
			if(password_verify($password, $user['1'])){
				if($rememberme == "on"){
					setcookie("username",$username, time()+7200);
				}else if($rememberme == ""){
					$_SESSION['user_id'] = $user['0'];
				}
				header('Location: index.php');
				exit();
			}else{
				return get_text('Wrong_password');
			}
		}
	}else{
		return get_text('Login_not_allowed');
	}
}
function admin_login($username, $password){
	$username = sanitize($username);
	$password = sanitize($password);
	$query = mysql_query("SELECT ID, Password FROM admin WHERE UPPER(Username) = UPPER('$username')");
	if(!$query || mysql_num_rows($query) <= 0){
			//echo mysql_error();
		return get_text('Error_occured');
	}else{
		$user = mysql_fetch_row($query);
		if(password_verify($password, $user['1'])){
			$_SESSION['admin_id'] = $user['0'];
			header('Location: admin.php');
			exit();
		}else{
			return get_text('Wrong_password');
		}
	}
}
function logged_in_redirect(){
	if(logged_in() === true){
		header('Location: index.php');
		exit();
	}
}
function logged_in(){
	return (isset($_SESSION['user_id'])||isset($_COOCKIE['username'])) ? true : false;
}
function protect_page(){
	if(logged_in() === false){
		header('Location: login.php');
		exit();
	}
}
function get_user_info($id,$batch){
	$id 					= (int) $id;
	$batch 					= (int) $batch;
	$user 					= get_user_by_id($id);
	$reviews_given 			= get_number_of_reviews_given($id);
	$reviews_received 		= get_number_of_reviews_received($id);
	$teammember_reviews		= get_number_of_poll_team_members($id);
	$notteammember_reviews 	= get_number_of_poll_not_team_members($id);
	$teammanager_reviews 	= get_number_of_poll_team_manager($id);
	$notteammanager_reviews = get_number_of_poll_not_team_manager($id);
	$preferred_reviewers 	= get_number_of_preferred_reviewers($id);
	$preferred_reviewees 	= get_number_of_preferred_reviewees($id);
	$comments 				= get_comments($id);
	$questions 				= get_questions();
	echo 
		get_text('Reviews_written').": <b>$reviews_given</b><br />".
		get_text('Reviews_received').": <b>$reviews_received</b><br />".
		get_text('Reviews_from_teammember').": <b>$teammember_reviews</b><br />".
		get_text('Reviews_from_not_teammember').": <b>$notteammember_reviews</b><br />".
		get_text('Reviews_from_teammanager').": <b>$teammanager_reviews</b><br />".
		get_text('Reviews_from_not_teammanager').": <b>$notteammanager_reviews</b><br />".
		get_text('Reviews_from_preferred_reviewer').": <b>$preferred_reviewers</b><br />".
		get_text('Reviews_given_to_preferred_reviewee').": <b>$preferred_reviewees</b><br />";
	?>
	<h3><?php echo get_Text('Average_score'); ?></h3>
	<table>
		<tr>
			<th></th>
			<th><?php echo get_text('Question'); ?></th>
			<th><?php echo get_text('Average_score'); ?></th>
		</tr>
		<?php 
		foreach ($questions as $key => $question) {
			?>
			<tr>
				<td>
					<?php echo $key+1; ?>
				</td>
				<td>
					<?php echo $question['Question']; ?>
				</td>
				<td style="text-align:center;">
					<?php echo get_average_score($id, $question['ID']); ?>
				</td>
			</tr>
			<?php
		}
		?>
	</table>
	<?php	
	if($comments){
		echo "<h3>".get_text('Extra_comment').":</h3>";
		foreach ($comments as $comment) {
			?>
			<div class="comment"><?php echo $comment['Comment']; ?></div>
			<?php
		}
	}
}
function get_number_of_reviews_given($id){
	$id = (int) $id;
 	$query = mysql_query("SELECT count(*) FROM reviews_given_view WHERE Reviewer = $id");
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
function get_number_of_reviews_received($id){
	$id = (int) $id;
	$query = mysql_query("SELECT count(*) AS Aantal_Reviews FROM reviews_received_view WHERE Reviewee = $id");
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
function get_number_of_poll_team_members($id){
	$id = (int) $id;
	$query = mysql_query("SELECT count(*) AS Aantal_TeamLeden FROM teammember_view WHERE Reviewee = $id");
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
function get_number_of_poll_not_team_members($id){
	$id = (int) $id;
	$query = mysql_query("SELECT count(*) AS Aantal_NietTeamLeden FROM notteammember_view WHERE Reviewee = $id");
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
function get_number_of_poll_team_manager($id){
	$id = (int) $id;
	$query = mysql_query("SELECT count(*) AS Aantal_TeamManagers FROM teammanager_view WHERE Reviewee = $id");
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
function get_number_of_poll_not_team_manager($id){
	$id = (int) $id;
	$query = mysql_query("SELECT count(*) AS Aantal_NietTeamManagers FROM notteammanager_view WHERE Reviewee = $id");
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
function get_number_of_preferred_reviewers($id){
	$id = (int) $id;
	$query = mysql_query("SELECT count(*) AS Aantal_Preferred_Reviewers FROM preferred_reviewers_view WHERE Reviewee = $id");
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
function get_number_of_preferred_reviewees($id){
	$id = (int) $id;
	$query = mysql_query("SELECT count(*) AS Aantal_Preferred_Reviewees FROM preferred_reviewees_view WHERE Reviewer = $id");
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
function get_comments($id){
	$id = (int) $id;
	$query = mysql_query("SELECT Comment FROM poll WHERE Reviewee = $id AND Comment != 'NULL'");
	if(!$query || mysql_num_rows($query) <=0) {
		echo mysql_error();
		return false;
	}else{
		while ($row = mysql_fetch_assoc($query)) {
			$comments[] = array(
				stripslashes('Comment') => $row['Comment']
				);
		}
		return $comments;
	}
}
function get_average_score($user, $question){
	$user = (int) $user;
	$question = (int) $question;
	$query = mysql_query("SELECT Average_Score FROM average_score_view WHERE Reviewee = $user AND Question = $question");
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
function get_total_reviews_to_give($id){
	return (get_number_of_poll_team_members($id)+get_number_of_poll_not_team_members($id)+get_number_of_poll_team_manager($id)+get_number_of_poll_not_team_manager($id));
}
function get_team_manager($user){
	$user = (int) $user;
	$query = mysql_query("SELECT * FROM user u INNER JOIN Department d On u.ID = d.Manager WHERE d.ID = (SELECT Department FROM user_department WHERE User = $user);");
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
function is_preferred_reviewee($reviewer, $reviewee, $batch){
	$reviewer = (int) $reviewer;
	$reviewee = (int) $reviewee;
	$batch = (int) $batch;
	return(mysql_result(mysql_query("SELECT COUNT(*) FROM preferred_poll WHERE Reviewer = $reviewer AND Reviewee = $reviewee AND User = $reviewer AND Batch = $batch"), 0) == 1) ? true : false;
}
function is_preferred_reviewer($reviewee, $reviewer, $batch){
	$reviewer = (int) $reviewer;
	$reviewee = (int) $reviewee;
	$batch = (int) $batch;
	return(mysql_result(mysql_query("SELECT COUNT(*) FROM preferred_poll WHERE Reviewer = $reviewer AND Reviewee = $reviewee AND User = $reviewee AND Batch = $batch"), 0) == 1) ? true : false;
}
function sanitize($data) {
	return htmlentities(strip_tags(mysql_real_escape_string($data)));
}




$questions = get_questions();
$categories = get_categories();
$polls = get_polls();
$users = get_users();
$managers = get_managers();
$departments = get_departments();
$poll_statuses = get_all_poll_statuses();
$number_of_users = get_number_of_users();

function get_best_polls_reviewee($reviewee,$limit){ // Selecteer de 5 beste polls voor een reviewee
	$reviewee = (int) $reviewee;
	$query = mysql_query("SELECT ID, Reviewer, Score FROM candidate_poll WHERE Reviewee=$reviewee ORDER BY Score DESC LIMIT $limit");
	//$query = mysql_query("SELECT ID, Reviewer, Score FROM candidate_poll WHERE Reviewee=$reviewee ORDER BY Score DESC");
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
function get_best_polls_reviewer($reviewer,$limit){ // Selecteer de 5 beste polls voor een reviewer
	$reviewer = (int) $reviewer;
	$query = mysql_query("SELECT ID, Reviewee, Score FROM candidate_poll WHERE Reviewer=$reviewer ORDER BY Score DESC LIMIT $limit");
	//$query = mysql_query("SELECT ID, Reviewee, Score FROM candidate_poll WHERE Reviewer=$reviewer ORDER BY Score DESC");
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
	$id = (int) $id;
	mysql_query("UPDATE candidate_poll SET Ok_overall = 1 WHERE ID = $id");
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
	$reviewer = (int) $reviewer;
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
	$reviewee = (int) $reviewee;
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
	$reviewer = (int) $reviewer;
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
	// LIMIT 100 is gekozen zodat we genoeg reviews selecteren. We hebben een OFFSET nodig, en deze kan allen gebruikt worden samen met LIMIT
	$reviewer = (int) $reviewer;
	$limit = mysql_result(mysql_query("SELECT Value FROM parameter WHERE Short_name = 'Reviews_to_give'"), 0);
	$query = mysql_query("SELECT ID, Reviewee, Score FROM candidate_poll WHERE Reviewer=$reviewer ORDER BY Score DESC LIMIT 100 OFFSET $limit");
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
	$reviewee = (int) $reviewee;
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
	$reviewer = (int) $reviewer;
	$query = mysql_query("SELECT cp.ID FROM candidate_poll cp WHERE cp.Reviewer = $reviewer AND cp.Ok_overall = 0 AND cp.Score = (SELECT MAX(Score) FROM candidate_poll WHERE Reviewer=cp.Reviewer AND Ok_overall = 0) LIMIT 1");
	if(!$query || mysql_num_rows($query) <= 0) {
		echo mysql_error();
		return false;
	}else{
		$result = mysql_result($query, 0);
		return $result;
	}
}


function get_candidate_user_info($id){
	$id 					= (int) $id;
	$user 					= get_user_by_id($id);
	$reviews_given 			= get_number_of_candidate_reviews_given($id);
	$reviews_received 		= get_number_of_candidate_reviews_received($id);
	$teammember_reviews		= get_number_of_candidate_poll_team_members($id);
	$notteammember_reviews 	= get_number_of_candidate_poll_not_team_members($id);
	$teammanager_reviews 	= get_number_of_candidate_poll_team_manager($id);
	$notteammanager_reviews = get_number_of_candidate_poll_managers($id);
	$preferred_reviewers 	= get_number_of_candidate_preferred_reviewers($id);
	$preferred_reviewees 	= get_number_of_candidate_preferred_reviewees($id);
	$questions 				= get_questions();
	echo 
		get_text('Reviews_written').": <b>$reviews_given</b><br />".
		get_text('Reviews_received').": <b>$reviews_received</b><br />".
		get_text('Reviews_from_teammember').": <b>$teammember_reviews</b><br />".
		get_text('Reviews_from_not_teammember').": <b>$notteammember_reviews</b><br />".
		get_text('Reviews_from_teammanager').": <b>$teammanager_reviews</b><br />".
		get_text('Reviews_from_not_teammanager').": <b>$notteammanager_reviews</b><br />".
		get_text('Reviews_from_preferred_reviewer').": <b>$preferred_reviewers</b><br />".
		get_text('Reviews_given_to_preferred_reviewee').": <b>$preferred_reviewees</b><br />";
}
function get_number_of_candidate_reviews_given($id){
	$id = (int) $id;
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
	$id = (int) $id;
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
	$id = (int) $id;
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
function get_number_of_candidate_poll_not_team_members($id){
	$id = (int) $id;
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
	$id = (int) $id;
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
function get_number_of_candidate_poll_managers($id){
	$id = (int) $id;
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
	$id = (int) $id;
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
	$id = (int) $id;
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
function number_of_users(){
	$query = mysql_query("SELECT count(*) FROM user");
	if(!$query || mysql_num_rows($query) <=0){
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query,0);
	}
}
function calculate_possible_polls($users){
	mysql_query("TRUNCATE TABLE candidate_poll");
	foreach ($users as $reviewee) {
		foreach ($users as $reviewer) {
			$reviewer_id = (int) $reviewer['ID'];
			$reviewee_id = (int) $reviewee['ID'];
			if($reviewer_id == $reviewee_id){
			} else if($reviewer_id == get_team_manager($reviewee_id)){
				// Enkel rijen toevegen waarbij de reviewer en reviewee verschillen of waarbij de reviewer niet te teammanager is van de reviewee.
			}else{	
				mysql_query("INSERT INTO candidate_poll (Reviewer, Reviewee, Score, Ok_reviewee, Ok_reviewer, Ok_overall) VALUES ($reviewer_id, $reviewee_id, 0, 0, 0, 0)");
			}
		}
	}
	calculate($users);
}

function calculate($users){
	$polls = get_candidate_polls();
	foreach ($polls as $poll) {
		$preferred_by_reviewee = is_preferred_poll_reviewee($poll['Reviewer'], $poll['Reviewee']);
		$preferred_by_reviewer = is_preferred_poll_reviewer($poll['Reviewer'], $poll['Reviewee']);
		$score = 0;

		if(get_department($poll['Reviewer']) == get_department($poll['Reviewee'])){
			// Reviewer en reviewee zijn teamleden
			if ($preferred_by_reviewee && $preferred_by_reviewer) {
				// Reviewer en reviewee zijn geen teamleden
				$score = rand(60,69);		
			}else if($preferred_by_reviewee){
				$score = rand(40,49);
			}else if($preferred_by_reviewer){
				$score = rand(20,29);
			}else{
				// Reviewer en reviewee zijn geen teamleden
				$score = rand(0,9);
			}
		}else{
			if ($preferred_by_reviewee && $preferred_by_reviewer) {
			// Reviewer en reviewee zijn geen teamleden
				$score = rand(70,79);
			}else if ($preferred_by_reviewee){
				$score = rand(50,59);
			}else if ($preferred_by_reviewer){
				$score = rand(30,39);
			}else{
				// Reviewer en reviewee zijn geen teamleden
				$score = rand(10,19);
			}
		}
		update_candidate_poll_score($poll['ID'], (get_candidate_poll_score($poll['ID'])+$score));
	}
	check($users);
}

function get_top_polls($user){
	$user = (int) $user;
	$query = mysql_query("SELECT * FROM candidate_poll WHERE Reviewer = $user ORDER BY Score DESC LIMIT 0,(SELECT Value FROM parameter WHERE Name = 'Reviews_to_give'");
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
function get_ok_overall_candidate_polls(){
	$query = mysql_query("SELECT * FROM candidate_poll WHERE Ok_overall = 1");
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
	$reviewer = (int) $reviewer;
	$reviewee = (int) $reviewee;
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
	$reviewer = (int) $reviewer;
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
	$reviewee = (int) $reviewee;
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
	$reviewer = (int) $reviewer;
	$reviewee = (int) $reviewee;
	$query = mysql_query("SELECT ID FROM candidate_poll WHERE Reviewer = $reviewer AND Reviewee = $reviewee AND Ok_overall = 0");
	if(!$query || mysql_num_rows($query) <= 0) {
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query, 0);
	}
}
function is_preferred_poll_reviewee($reviewer, $reviewee){
	$reviewer = (int) $reviewer;
	$reviewee = (int) $reviewee;
	$query = mysql_query("SELECT * FROM preferred_poll WHERE (Reviewer = $reviewer AND Reviewee = $reviewee) AND User = $reviewee");
	if(!$query || mysql_num_rows($query) <= 0) {
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query, 0);
	}
}
function is_preferred_poll_reviewer($reviewer, $reviewee){
	$reviewer = (int) $reviewer;
	$reviewee = (int) $reviewee;
	$query = mysql_query("SELECT * FROM preferred_poll WHERE (Reviewer = $reviewer AND Reviewee = $reviewee) AND User = $reviewer");
	if(!$query || mysql_num_rows($query) <= 0) {
		echo mysql_error();
		return false;
	}else{
		return mysql_result($query, 0);
	}
}
function get_department($user){
	$user = (int) $user;
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
	$poll = (int) $poll;
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
	$poll = (int) $poll;
	$score = (int) $score;
	$query = mysql_query("UPDATE candidate_poll SET Score = $score WHERE ID = $poll;");
}
function get_manager_reviews_received(){
	$managers = get_managers();
	$managers = join(',',$managers);
	$query = mysql_query("SELECT sum(Ok_overall) AS Aantal_reviews FROM candidate_poll WHERE Reviewer IN ($managers) AND Reviewee NOT IN ($managers) GROUP BY Reviewee");
	if(!$query || mysql_num_rows($query) <0) {
		echo mysql_error();
		return false;
	}else{
		if(mysql_num_rows($query) == 0){
			return 0;
		}else{
			return mysql_result($query,0);	
		}	
	}
}
function get_team_member_reviews_received(){
	$query = mysql_query("SELECT Reviewee, sum(Ok_overall) AS Aantal_reviews FROM candidate_poll WHERE ((SELECT Department FROM user_department WHERE User = Reviewer) = (SELECT Department FROM user_department WHERE User = Reviewee)) GROUP BY Reviewee");
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
function get_manager_reviews_received_reviewee($reviewee){
	$reviewee = (int) $reviewee;
	$managers = join(',',get_managers());
	$query = mysql_query("SELECT Reviewee, sum(Ok_overall) AS Aantal_reviews FROM candidate_poll WHERE Reviewer IN ($managers) AND Reviewee = $reviewee GROUP BY Reviewee");
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
function get_worst_manager_polls($reviewee){
	$managers = get_managers();
	$managers = join(',',$managers);
	$query = mysql_query("SELECT * FROM candidate_poll WHERE Reviewee = $reviewee AND Reviewer IN ($managers) AND Ok_overall = 1 ORDER BY Score LIMIT 100 OFFSET 1");
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
				'Ok_overall' => $row['Ok_overall']
				);
		}
		return $polls;
	}
}
foreach ($users as $user) {
	//echo get_number_of_candidate_poll_managers($user['ID'])."-";
}
if(isset($_GET['user'])){
	get_candidate_user_info($_GET['user']);
}

function check($users){
	$number_of_reviews_given = mysql_result(mysql_query("SELECT Value FROM parameter WHERE Short_name ='Reviews_to_give'"), 0);
	$number_of_reviews_received = mysql_result(mysql_query("SELECT Value FROM parameter WHERE Short_name ='Reviews_to_receive'"), 0);
	$number_of_manager_reviews_received = mysql_result(mysql_query("SELECT Value FROM parameter WHERE Short_name = 'Reviews_by_not_teammanager'"), 0);
	$number_of_team_member_reviews_received = mysql_result(mysql_query("SELECT Value FROM parameter WHERE Short_name = 'Reviews_own_department'"), 0);
	shuffle($users);
	foreach ($users as $user) {
		// X beste reviewee polls en 5 beste reviewer polls kiezen en respectievelijk Ok_reviewee en Ok_reviewer op 1 zetten
		$get_best_polls_reviewee = get_best_polls_reviewee($user['ID'],$number_of_reviews_received);
		foreach ($get_best_polls_reviewee as $poll) {
			$id = $poll['ID'];
			mysql_query("UPDATE candidate_poll SET Ok_reviewee = 1 WHERE ID = $id");
		}
		$get_best_polls_reviewer = get_best_polls_reviewer($user['ID'],$number_of_reviews_given);
		foreach ($get_best_polls_reviewer as $poll) {
			$id = $poll['ID'];
			mysql_query("UPDATE candidate_poll SET Ok_reviewer = 1 WHERE ID = $id");
		}
	}
	set_best_polls();
	shuffle($users);

	// Voor alle gebruikers die teveel reviews krijgen van managers, worden enkel de beste reviews behoouden en de andere reviews op Ok_overall = 0 gezet.
	$manager_reviews_received = get_manager_reviews_received();
	$too_many_manager_received = array();
	if($manager_reviews_received){
		foreach ($manager_reviews_received as $reviews_per_reviewer) {
			if($reviews_per_reviewer['Aantal_reviews'] > $number_of_manager_reviews_received){
				$too_many_manager_received[] = $reviews_per_reviewer;
			}
		}
	}
	if(!empty($too_many_manager_received)){
		// De slechtste review met een reviewer (=manager) verwijderen
		foreach ($too_many_manager_received as $too_many_manager) {
			$polls = get_worst_manager_polls($too_many_manager['Reviewee']);	
			if($polls){
				foreach ($polls as $poll){
					$id = $poll['ID'];
					mysql_query("UPDATE candidate_poll SET Ok_overall = 0 WHERE ID = $id");
				}
			}	
		}
	}

	$team_member_reviews_received = get_team_member_reviews_received();
	$too_many_team_member_received = array();
	if($team_member_reviews_received){
		foreach ($team_member_reviews_received as $reviews_per_reviewer) {
			if($reviews_per_reviewer['Aantal_reviews'] > $number_of_team_member_reviews_received){
				$too_many_team_member_received[] = $reviews_per_reviewer;
			}
		}
	}
	if(!empty($too_many_manager_received)){
		// De slechtste review met een reviewer (=manager) verwijderen
		foreach ($too_many_manager_received as $too_many_manager) {
			$polls = get_worst_manager_polls($too_many_manager['Reviewee']);	
			if($polls){
				foreach ($polls as $poll){
					$id = $poll['ID'];
					mysql_query("UPDATE candidate_poll SET Ok_overall = 0 WHERE ID = $id");
				}
			}	
		}
	}

	$reviews_given = get_reviews_given();
	$too_few_given = array();
	$too_many_given = array();
	$exact_given = array();
	if($reviews_given){
		foreach ($reviews_given as $reviews_per_reviewer) { 				// Alle gebruikers die reviews geven
			if($reviews_per_reviewer['Aantal_reviews'] < $number_of_reviews_given){				// Alle gebruikers die minder dan 5 reviews geven
				$too_few_given[] = $reviews_per_reviewer;
			}else if($reviews_per_reviewer['Aantal_reviews'] > $number_of_reviews_given){			// Alle gebruikers die meer dan 5 reviews geven
				$too_many_given[] = $reviews_per_reviewer;
			}else if($reviews_per_reviewer['Aantal_reviews'] == $number_of_reviews_given){			// Alle gebruikers die 5 reviews geven
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
			if($reviews_per_reviewee['Aantal_reviews'] < $number_of_reviews_received){				// Alle gebruikers die minder dan 5 reviews krijgen
				$too_few_received[] = $reviews_per_reviewee;
			}else if($reviews_per_reviewee['Aantal_reviews'] > $number_of_reviews_received){			// Alle gebruikers die meer dan 5 reviews krijgen
				$too_many_received[] = $reviews_per_reviewee;
			}else if($reviews_per_reviewee['Aantal_reviews'] == $number_of_reviews_received){			// Alle gebruikers die 5 reviews krijgen
				$exact_received[] = $reviews_per_reviewee;
			}
		}
	}
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
			foreach ($reviews_given as $reviews_per_reviewer) { 										// Alle gebruikers die reviews geven
				if($reviews_per_reviewer['Aantal_reviews'] < $number_of_reviews_given){					// Alle gebruikers die minder dan 5 reviews geven
					$too_few_given[] = $reviews_per_reviewer;
				}else if($reviews_per_reviewer['Aantal_reviews'] > $number_of_reviews_given){			// Alle gebruikers die meer dan 5 reviews geven
					$too_many_given[] = $reviews_per_reviewer;
				}else if($reviews_per_reviewer['Aantal_reviews'] == $number_of_reviews_given){			// Alle gebruikers die 5 reviews geven
					$exact_given[] = $reviews_per_reviewer;
				}
			}
		}
		$reviews_received = get_reviews_received();
		$too_few_received = array();
		$too_many_received = array();
		$exact_received = array();
		if($reviews_received){
			foreach ($reviews_received as $reviews_per_reviewee) { 											// Alle gebruikers die reviews krijgen
				if($reviews_per_reviewee['Aantal_reviews'] < $number_of_reviews_received){					// Alle gebruikers die minder dan 5 reviews krijgen
					$too_few_received[] = $reviews_per_reviewee;
				}else if($reviews_per_reviewee['Aantal_reviews'] > $number_of_reviews_received){			// Alle gebruikers die meer dan 5 reviews krijgen
					$too_many_received[] = $reviews_per_reviewee;
				}else if($reviews_per_reviewee['Aantal_reviews'] == $number_of_reviews_received){			// Alle gebruikers die 5 reviews krijgen
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
			foreach ($reviews_given as $reviews_per_reviewer) { 										// Alle gebruikers die reviews geven
				if($reviews_per_reviewer['Aantal_reviews'] < $number_of_reviews_given){					// Alle gebruikers die minder dan 5 reviews geven
					$too_few_given[] = $reviews_per_reviewer;
				}else if($reviews_per_reviewer['Aantal_reviews'] > $number_of_reviews_given){			// Alle gebruikers die meer dan 5 reviews geven
					$too_many_given[] = $reviews_per_reviewer;
				}else if($reviews_per_reviewer['Aantal_reviews'] == $number_of_reviews_given){			// Alle gebruikers die 5 reviews geven
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
				if($reviews_per_reviewee['Aantal_reviews'] < $number_of_reviews_received){				// Alle gebruikers die minder dan 5 reviews krijgen
					$too_few_received[] = $reviews_per_reviewee;
				}else if($reviews_per_reviewee['Aantal_reviews'] > $number_of_reviews_received){			// Alle gebruikers die meer dan 5 reviews krijgen
					$too_many_received[] = $reviews_per_reviewee;
				}else if($reviews_per_reviewee['Aantal_reviews'] == $number_of_reviews_received){			// Alle gebruikers die 5 reviews krijgen
					$exact_received[] = $reviews_per_reviewee;
				}
			}
		}
	}
	$number_of_polls= -1000000;
	$counter = 0;
	while((!empty($too_few_given) && !empty($too_few_received)) && $counter != 10) {
		if($number_of_polls == get_overall_ok_polls()){
			$counter++;
		}else{
			$counter = 0;
		}
		$number_of_polls = get_overall_ok_polls();
		$polls = array();
		foreach($too_few_given as $too_few_reviewer){
			foreach($too_few_received as $too_few_reviewee){
				$poll = get_candidate_poll($too_few_reviewer['Reviewer'], $too_few_reviewee['Reviewee']);
				if($poll){
					if($poll[0]['Ok_overall'] == 0){
						$polls[] = $poll[0];
					}
				}
			}
		}
		$score = 0;
		$poll = 0;

		$key = array_rand($polls, 1);
		$poll = $polls[$key];
		
		$reviewer = get_candidate_poll_reviewer($poll['ID']);
		$reviewee = get_candidate_poll_reviewee($poll['ID']);
		
		if(!is_manager($reviewee) && is_manager($reviewer) && (get_manager_reviews_received_reviewee($reviewee) < $number_of_manager_reviews_received)){
			$id = $poll['ID'];
			mysql_query("UPDATE candidate_poll SET Ok_overall = 1 WHERE ID = $id");
		}else if(!is_manager($reviewer) || is_manager($reviewee)){
			$id = $poll['ID'];
			mysql_query("UPDATE candidate_poll SET Ok_overall = 1 WHERE ID = $id");
		}
		$reviews_given = get_reviews_given();
		$too_few_given = array();
		$too_many_given = array();
		$exact_given = array();
		if($reviews_given){
			foreach ($reviews_given as $reviews_per_reviewer) { 				// Alle gebruikers die reviews geven
				if($reviews_per_reviewer['Aantal_reviews'] < $number_of_reviews_given){				// Alle gebruikers die minder dan 5 reviews geven
					$too_few_given[] = $reviews_per_reviewer;
				}else if($reviews_per_reviewer['Aantal_reviews'] > $number_of_reviews_given){			// Alle gebruikers die meer dan 5 reviews geven
					$too_many_given[] = $reviews_per_reviewer;
				}else if($reviews_per_reviewer['Aantal_reviews'] == $number_of_reviews_given){			// Alle gebruikers die 5 reviews geven
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
				if($reviews_per_reviewee['Aantal_reviews'] < $number_of_reviews_received){				// Alle gebruikers die minder dan 5 reviews krijgen
					$too_few_received[] = $reviews_per_reviewee;
				}else if($reviews_per_reviewee['Aantal_reviews'] > $number_of_reviews_received){			// Alle gebruikers die meer dan 5 reviews krijgen
					$too_many_received[] = $reviews_per_reviewee;
				}else if($reviews_per_reviewee['Aantal_reviews'] == $number_of_reviews_received){			// Alle gebruikers die 5 reviews krijgen
					$exact_received[] = $reviews_per_reviewee;
				}
			}
		}
	}
	while((!empty($too_few_given) && !empty($too_few_received))) {
		$polls = array();
		foreach($too_few_given as $too_few_reviewer){
			foreach($too_few_received as $too_few_reviewee){
				$poll = get_candidate_poll($too_few_reviewer['Reviewer'], $too_few_reviewee['Reviewee']);
				if($poll){
					if($poll[0]['Ok_overall'] == 0){
						$polls[] = $poll[0];
					}
				}
			}
		}
		if(empty($polls)){
			break;
		}
		$score = 0;
		$poll = 0;

		$key = array_rand($polls, 1);
		$poll = $polls[$key];
		
		$reviewer = get_candidate_poll_reviewer($poll['ID']);
		$reviewee = get_candidate_poll_reviewee($poll['ID']);

		$id = $poll['ID'];
		mysql_query("INSERT INTO candidate_poll (Reviewer, Reviewee, Score, Ok_reviewee, Ok_reviewer, Ok_overall) VALUES ($reviewer, $reviewee, 0, 0, 0, 1) ON DUPLICATE KEY UPDATE Ok_overall = 1");

		$reviews_given = get_reviews_given();
		$too_few_given = array();
		$too_many_given = array();
		$exact_given = array();
		if($reviews_given){
			foreach ($reviews_given as $reviews_per_reviewer) { 				// Alle gebruikers die reviews geven
				if($reviews_per_reviewer['Aantal_reviews'] < $number_of_reviews_given){				// Alle gebruikers die minder dan 5 reviews geven
					$too_few_given[] = $reviews_per_reviewer;
				}else if($reviews_per_reviewer['Aantal_reviews'] > $number_of_reviews_given){			// Alle gebruikers die meer dan 5 reviews geven
					$too_many_given[] = $reviews_per_reviewer;
				}else if($reviews_per_reviewer['Aantal_reviews'] == $number_of_reviews_given){			// Alle gebruikers die 5 reviews geven
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
				if($reviews_per_reviewee['Aantal_reviews'] < $number_of_reviews_received){				// Alle gebruikers die minder dan 5 reviews krijgen
					$too_few_received[] = $reviews_per_reviewee;
				}else if($reviews_per_reviewee['Aantal_reviews'] > $number_of_reviews_received){			// Alle gebruikers die meer dan 5 reviews krijgen
					$too_many_received[] = $reviews_per_reviewee;
				}else if($reviews_per_reviewee['Aantal_reviews'] == $number_of_reviews_received){			// Alle gebruikers die 5 reviews krijgen
					$exact_received[] = $reviews_per_reviewee;
				}
			}
		}
	}
}
?>