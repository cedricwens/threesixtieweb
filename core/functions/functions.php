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
				$managers[] = array(
					stripslashes('Department') => $row['Department'],
					stripslashes('Name') => $row['Name']
				);
			}
			return $managers;
		}
	}
	function get_users(){
			$query = mysql_query("SELECT * FROM user");
			if(!$query || mysql_num_rows($query) <=0) {
				echo mysql_error();
				return false;
			}else{
				while ($row = mysql_fetch_assoc($query)) {
					$users[] = array(
						'ID' => $row['ID'],
						stripslashes('Name') => $row['Name'],
						stripslashes('Department') => $row['Department']
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
	function add_preferred($reviewer, $reviewee, $user){
		if($reviewer == $reviewee){
			echo "Het is niet toegestaan om als voorkeur 2 keer uw eigen naam te selecteren.";
		}else{
			$query = mysql_query("SELECT * FROM preferred_poll WHERE (Reviewer = (SELECT ID FROM user WHERE Name = '$reviewer') AND Reviewee = (SELECT ID FROM user WHERE Name = '$reviewee') AND User = (SELECT ID FROM user WHERE Name = '$user'))");
			if(!$query || mysql_num_rows($query) < 0){
				echo mysql_error();
			}else if(mysql_num_rows($query) == 0){
				$query = mysql_query("INSERT INTO preferred_poll (Reviewer, Reviewee, User) VALUES ((SELECT ID FROM user WHERE Name = '$reviewer'), (SELECT ID FROM user WHERE Name = '$reviewee'), (SELECT ID FROM user WHERE Name = '$user')) ON DUPLICATE KEY UPDATE Reviewer = (SELECT ID FROM user WHERE Name = '$reviewer'), Reviewee = (SELECT ID FROM user WHERE Name = '$reviewee'), User = (SELECT ID FROM user WHERE Name ='$user')");
				if(!$query){
						echo mysql_error();
				}else{
						echo 'Voorkeur toegevoegd';
				}
			}else if(mysql_num_rows($query) > 0){
				echo "Deze voorkeur werd al ingegeven";
			}
		}
	}
	function get_user_id($user){
		$query = mysql_query("SELECT ID FROM user WHERE Name = '$user'");
		if(!$query || mysql_num_rows($query) <= 0){
			echo mysql_error();
		}else{
			return mysql_result($query,0);
		}
	}



	function get_user_info($id){
		$user 					= get_user_by_id($id);
		$reviews_given 			= get_reviews_given($id);
		$reviews_received 		= get_reviews_received($id);
		$teammember_reviews		= get_poll_team_members($id);
		$notteammember_reviews 	= get_poll_not_team_members($id);
		$teammanager_reviews 	= get_poll_team_manager($id);
		$notteammanager_reviews = get_poll_not_team_manager($id);
		$preferred_reviewers 	= get_preferred_reviewers($id);
		$preferred_reviewees 	= get_preferred_reviewees($id);
		$questions 				= get_questions();
		echo "
			Reviews geschreven: <b>$reviews_given</b>
			<br />
			Reviews gekregen: <b>$reviews_received</b>
			<br />
			Krijgt review(s) van <b>$teammember_reviews</b> teamleden.
			<br />
			Krijgt review(s) van <b>$notteammember_reviews</b> niet-teamleden.
			<br />
			Krijgt <b>$teammanager_reviews</b> review(s) van zijn teammanager.
			<br />
			Krijgt <b>$notteammanager_reviews</b> review(s) van andere teammanagers.
			<br />
			<b>$preferred_reviewers</b> van de gebruikers die $user aangaf, mogen ook effectief de vragenlijst over $user invullen.
			<br />
			$user mag van <b>$preferred_reviewees</b> gebruiker die zijn had gekozen, ook effectief de vragenlijst invullen.";
		echo "<h3>Gemiddelde score op de verschillende vragen:</h3>";
			?>
			<table>
				<tr>
					<th></th>
					<th>Vraag</th>
					<th>Gemiddelde score</th>
				</tr>
				<?php 
					foreach ($questions as $question) {
						?>
						<tr>
							<td>
								<?php echo $question['ID'] ?>
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
			
	}
	function get_reviews_given($id){
		$query = mysql_query("SELECT Aantal_Reviews FROM reviews_given_view WHERE Reviewer = $id");
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
	function get_reviews_received($id){
		$query = mysql_query("SELECT Aantal_Reviews FROM reviews_received_view WHERE Reviewee = $id");
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
	function get_poll_team_members($id){
		$query = mysql_query("SELECT Aantal_TeamLeden FROM teammember_view WHERE Reviewee = $id");
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
	function get_poll_not_team_members($id){
		$query = mysql_query("SELECT Aantal_NietTeamLeden FROM notteammember_view WHERE Reviewee = $id");
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
	function get_poll_team_manager($id){
		$query = mysql_query("SELECT Aantal_TeamManagers FROM teammanager_view WHERE Reviewee = $id");
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
	function get_poll_not_team_manager($id){
		$query = mysql_query("SELECT Aantal_NietTeamManagers FROM notteammanager_view WHERE Reviewee = $id");
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
	function get_preferred_reviewers($id){
		$query = mysql_query("SELECT Aantal_Preferred_Reviewers FROM preferred_reviewers_view WHERE Reviewee = $id");
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
	function get_preferred_reviewees($id){
		$query = mysql_query("SELECT Aantal_Preferred_Reviewees FROM preferred_reviewees_view WHERE Reviewer = $id");
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
	function get_average_score($user, $question){
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
?>