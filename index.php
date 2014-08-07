<?php require('includes/header.php'); ?>
	<div>
		<h2><?php echo get_text('Add_poll'); ?></h2>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<label for="reviewer">Reviewer: </label><input type="text" name="reviewer" /><br />
			<label for="reviewee">Reviewee: </label><input type="text" name="reviewee" /><br />
			<label for="status">Status: </label>
				<select name="status">
				<?php
					foreach ($poll_statuses as $poll_status) {
						?>
							<option value="<?php echo $poll_status['Name']; ?>"><?php echo $poll_status['Name']; ?></option>
						<?php
					}
				?>
			<br />
			<input type="submit" value="Voeg toe" name="add_poll" />
		</form>
	</div>
	<div>
		<h2><?php echo get_text('Add_answer'); ?></h2>
		<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
			<label for="question"><?php echo get_text('Question'); ?>: </label>
				<select name="question">
					<?php
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
			<label for="poll"><?php echo get_text('Poll'); ?>: </label>
				<select name="poll">
					<?php
						foreach ($polls as $poll) {
							$reviewer = get_user_by_id($poll['Reviewer']);
							$reviewee = get_user_by_id($poll['Reviewee']);
							?>
							<option value="<?php echo $poll['ID']; ?>"><?php echo $reviewer.' '.strtolower(get_text('About')).' '.$reviewee; ?></option>
							<?php
						}
					?>
				</select>
			<br />
			<label for="answer"><?php echo get_text('Answer'); ?>: </label><input type="text" name="answer" /><br />
				<input type="submit" value="Beantwoord" name="answer_question"/>
		</form>
	</div>
	<div>
		<h2><?php echo get_text('Preferences'); ?></h2>
		<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
			<label for="me">Ik ben: </label>
				<select name="me">
					<option value=""><?php echo get_text('Choose_a').' '.strtolower(get_text('user')); ?></option>
					<?php
						foreach ($departments as $department) {
							?>
							<optgroup label="<?php echo $department['Name']; ?>">
								<?php
								foreach ($users as $user) {
									if($user['Department'] == $department['ID']){
										?>
										<option value="<?php echo $user['Username']; ?>"><?php echo $user['Firstname'].' '.$user['Lastname']; ?></option>
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
			<label for="reviewer"><?php echo get_text('This_person_may_answer_my_poll'); ?>: </label>
				<select name="reviewer">
					<option value=""><?php echo get_text('Choose_a').' '.strtolower(get_text('user')); ?></option>
					<?php
						foreach ($departments as $department) {
							?>
							<optgroup label="<?php echo $department['Name']; ?>">
								<?php
								foreach ($users as $user) {
									if($user['Department'] == $department['ID']){
										?>
										<option value="<?php echo $user['Username']; ?>"><?php echo $user['Firstname'].' '.$user['Lastname']; ?></option>
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
			<label for="reviewee"><?php echo get_text('I_want_to_answer_poll_about_this_person'); ?>: </label>
				<select name="reviewee">
					<option value=""><?php echo get_text('Choose_a').' '.strtolower(get_text('user')); ?></option>
					<?php
						foreach ($departments as $department) {
							?>
							<optgroup label="<?php echo $department['Name']; ?>">
								<?php
								foreach ($users as $user) {
									if($user['Department'] == $department['ID']){
										?>
										<option value="<?php echo $user['Username']; ?>"><?php echo $user['Firstname'].' '.$user['Lastname']; ?></option>
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
	</div>


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
		<h2><?php echo get_text('Polls'); ?>:</h2>				
		<?php
		if($polls){
			?>
			<table style="text-align:center;">
				<tr>
					<th><?php echo get_text('ID'); ?></th>
					<th><?php echo get_text('Reviewer'); ?></th>
					<th><?php echo get_text('Reviewee'); ?></th>
					<th><?php echo get_text('Time_Created'); ?></th>
					<th><?php echo get_text('View').' '.strtolower(get_text('Answers')); ?></th>
				</tr>
				<?php
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
			}else{
				echo "Er zijn geen polls gevonden.";
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
?>
<?php require('includes/footer.php') ?>