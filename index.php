<?php require('includes/header.php'); ?>
	<table>
		<tr>
			<td>
				<h2>Poll toevoegen</h2>
				<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
					<label for="reviewer">Reviewer: </label><input type="text" name="reviewer" /><br />
					<label for="reviewee">Reviewee: </label><input type="text" name="reviewee" /><br />
					<label for="status">Status: </label>
						<select name="status">
							<option value="0">Niet ingevuld</option>
							<option value="1">Opgeslagen</option>
							<option value="2">Ingestuurd</option>
						</select>
					<br />
					<input type="submit" value="Voeg toe" name="add_poll" />
				</form>
			</td>
			<td>
				<h2>Antwoorden toevoegen</h2>
				<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
					<label for="question">Vraag: </label>
						<select name="question">
							<?php
								$questions = get_questions();
								$categories = get_categories();
								foreach ($categories as $category) {
									?>
									<optgroup label="<?php echo $category['Name']; ?>">
										<?php
										foreach ($questions as $question) {
											if($question['Category'] == $category['ID']){
												?>
												<option value="<?php echo $question['ID']; ?>"><?php echo $question['ID'].'. '.$question['Question']; ?></option>
												<?php
											}
										}
										?>
									</optgroup>
									<?php
								}
							?>
						</select>
					<br />
					<label for="poll">Poll: </label>
						<select name="poll">
							<?php
								$polls = get_polls();
								foreach ($polls as $poll) {
									$reviewer = get_user_by_id($poll['Reviewer']);
									$reviewee = get_user_by_id($poll['Reviewee']);
									?>
									<option value="<?php echo $poll['ID']; ?>"><?php echo $reviewer; ?> over <?php echo $reviewee; ?></option>
									<?php
								}
							?>
						</select>
					<br />
					<label for="answer">Antwoord: </label><input type="text" name="answer" /><br />
					
					<input type="submit" value="Beantwoord" name="answer_question"/>
				</form>
			</td>
			<td>
				<h2>Voorkeuren</h2>
				<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
					<label for="me">Ik ben: </label>
						<select name="me">
							<option value="">Kies een gebruiker</option>
							<?php
								$users = get_users();
								$departments = get_departments();
								foreach ($departments as $department) {
									?>
									<optgroup label="<?php echo $department['Name']; ?>">
										<?php
										foreach ($users as $user) {
											if($user['Department'] == $department['ID']){
												?><option value="<?php echo $user['Name']; ?>"><?php echo $user['Name']; ?></option>
											<?php
											}
										}
									?>
									</optgroup>
									<?php
								}
								?>
						</select>
						<br />
					<label for="reviewer">Deze persoon mag vragen over mij beantwoorden: </label>
						<select name="reviewer">
							<option value="">Kies een gebruiker</option>
							<?php
								$users = get_users();
								$departments = get_departments();
								foreach ($departments as $department) {
									?>
									<optgroup label="<?php echo $department['Name']; ?>">
										<?php
										foreach ($users as $user) {
											if($user['Department'] == $department['ID']){
												?><option value="<?php echo $user['Name']; ?>"><?php echo $user['Name']; ?></option>
											<?php
											}
										}
									?>
									</optgroup>
									<?php
								}
							?>
						</select>
						<br />
					<label for="reviewee">Ik wil vragen over deze persoon beantwoorden: </label>
						<select name="reviewee">
							<option value="">Kies gebruiker</option>
							<?php
								$users = get_users();
								$departments = get_departments();
								foreach ($departments as $department) {
									?>
									<optgroup label="<?php echo $department['Name']; ?>">
										<?php
										foreach ($users as $user) {
											if($user['Department'] == $department['ID']){
												?><option value="<?php echo $user['Name']; ?>"><?php echo $user['Name']; ?></option>
											<?php
											}
										}
									?>
									</optgroup>
									<?php
								}
							?>
						</select>
						<br />
					<input type="submit" value="Voeg toe" name="add_preferred" />
				</form>
			</td>
		</tr>
	</table>


	<?php
	if(isset($_POST['add_poll'])){
		$reviewer 	= $_POST['reviewer'];
		$reviewee 	= $_POST['reviewee'];
		$status		= $_POST['status'];
		create_poll($reviewer,$reviewee,$status);
	}

	if(isset($_POST['answer_question'])){
		$question = $_POST['question'];
		$poll = $_POST['poll'];
		$answer = $_POST['answer'];
		answer($poll, $question, $answer);
	}

	if(isset($_POST['add_preferred'])){
		$me = $_POST['me'];
		$reviewer = $_POST['reviewer'];
		$reviewee = $_POST['reviewee'];
		if(!empty($me)){
			if (empty($reviewer) && !empty($reviewee)) {
				add_preferred($me, $reviewee, $me);
			}else if (!empty($reviewer) && empty($reviewee)) {
				add_preferred($reviewer, $me, $me);
			}
		}
	}
	?>
		<h2>Polls:</h2>
			<table style="text-align:center;">
				<tr>
					<th>ID</th>
					<th>Reviewer</th>
					<th>Reviewee</th>
					<th>Tijdstip</th>
					<th>Bekijk antwoorden</th>
				</tr>
				<?php
				$polls = get_polls();
				foreach ($polls as $poll) {
					$reviewer = get_user_by_id($poll['Reviewer']);
					$reviewee = get_user_by_id($poll['Reviewee']);
					?>
					<tr>
						<td><?php echo $poll['ID']; ?></td>
						<td><?php echo $reviewer; ?></td>
						<td><?php echo $reviewee; ?></td>
						<td><?php echo $poll['Last_Update']; ?></td>
						<td><a href="?view_answer=<?php echo $poll['ID']; ?>">Bekijk</a></td>
					</tr>
				<?php
				}
				?>
			</table>
	<br />
	<?php
	if(isset($_GET['view_answer'])){
		$poll = $_GET['view_answer'];
		$answers = get_answers($poll);
		if(!$answers){
			echo 'Er zijn nog geen vragen beantwoord in deze poll.';
		}else{
			?>
			<table style="text-align:center;">
				<tr>
					<th>ID</th>
					<th>Poll ID</th>
					<th>Vraag</th>
					<th>Antwoord</th>
					<th>Tijd</th>
				</tr>
			<?php
			$totale_score = 0;
			$aantal_vragen = 0;
			foreach($answers as $answer){
				$totale_score += $answer['Answer'];
				$aantal_vragen += 1;
				?>
				<tr>
					<td><?php echo $answer['ID']; ?></td>
					<td><?php echo $answer['Poll']; ?></td>
					<td><?php echo $answer['Question']; ?></td>
					<td><?php echo $answer['Answer']; ?></td>
					<td><?php echo $answer['Last_Update']; ?></td>
				</tr>
				<?php
			}
			$gemiddelde_score = $totale_score/$aantal_vragen;

			?>
			<h2>Gemiddelde score: <?php echo $gemiddelde_score; ?></h2>
			<h2>Gemiddelde score: <?php echo mysql_result(mysql_query("SELECT * FROM gemiddelde_score;"), 0); ?></h2>
			</table>
			<?php
		}
	}
	/*$users = get_managers();
	foreach($users as $user) {
		echo $user['Department'].": ".$user['Name']."<br />";
	}*/
?>
<?php require('includes/footer.php') ?>