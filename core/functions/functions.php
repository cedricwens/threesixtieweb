<?php
	function create_date(){
		$time = time();
		$date = date("Y-m-d H:i:s", $time);
		return $date;
	}

	function get_managers(){
		$query = mysql_query("SELECT d.Name AS Department, u.Name FROM user u INNER JOIN department d ON u.ID = d.Manager");
		if(!$query || mysql_num_rows($query) <=0) {
			echo mysql_error();
			return false;
		}else{
			while ($row = mysql_fetch_assoc($query)) {
				$users[] = array(
					stripslashes('Department') => $row['Department'],
					stripslashes('Name') => $row['Name']
				);
			}
			return $users;
		}
	}

	function create_poll($reviewer, $reviewee, $status){
		$date = create_date();
		$query = mysql_query("SELECT * FROM poll WHERE Reviewer = (SELECT ID FROM user WHERE Name = '$reviewer') AND Reviewee = (SELECT ID FROM user WHERE Name = '$reviewee')");
		if(!$query || mysql_num_rows($query)>0 || mysql_num_rows($query) < 0){
			if(mysql_num_rows($query) > 0) {
				echo "Deze poll bestaat al";
			}else{
				echo mysql_error();
			}
		}else{
			$query = mysql_query("INSERT INTO poll (Reviewer, Reviewee, Status, Time) VALUES ((SELECT ID FROM user WHERE Name = '$reviewer'),(SELECT ID FROM user WHERE Name = '$reviewee'), $status, '$date')");
			if(!$query) {
				echo mysql_error();
			}else{
				echo 'Poll aangemaakt';
			}
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
					'ID'		=> $row['ID'],
					'Reviewer' 	=> $row['Reviewer'],
					'Reviewee'	=> $row['Reviewee'],
					'Comment'	=> $row['Comment'],
					'Status'	=> $row['Status'],
					'Time'		=> $row['Time']
				);
			}
			return $polls;
		}
	}

	function get_user_by_id($id){
		$query = mysql_query("SELECT Name FROM user WHERE ID = $id");
		if(!$query || mysql_num_rows($query) <=0) {
			echo mysql_error();
			return false;
		}else{
			return mysql_result($query,0);
		}
	}

	function get_questions(){
		$query = mysql_query("SELECT * FROM question");
				if(!$query || mysql_num_rows($query) <=0) {
			echo mysql_error();
			return false;
		}else{
			while ($row = mysql_fetch_assoc($query)) {
				$questions[] = array(
					'ID' => $row['ID'],
					stripslashes('Question') => $row['Question'],
					'Category' => $row['Category']
				);
			}
			return $questions;
		}
	}

	function answer($poll, $question, $answer){
		$date = create_date();
		$query = mysql_query("SELECT * FROM answer WHERE Poll = $poll AND Question = $question");
		if(!$query || mysql_num_rows($query)>0 || mysql_num_rows($query) < 0){
			if(mysql_num_rows($query) > 0) {
				echo "Deze vraag is al beantwoord";
			}else{
				echo mysql_error();
			}
		}else{
			$query = mysql_query("INSERT INTO answer (Poll, Question, Answer, Time) VALUES ($poll, $question, $answer, '$date')");
			if(!$query) {
				echo mysql_error();
			}else{
				echo 'Vraag Beantwoord';
			}
		}
	}

	function get_answers($poll){
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
					'Time' => $row['Time']
				);
			}
			return $answers;
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
?>