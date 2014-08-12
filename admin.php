<?php
$selected_page = "Admin";
require('includes/header.php');
if(!isset($_SESSION['admin_id'])){
	header('Location:admin_login.php');
}
$error = "";
?>
<div class="content">
	<div class="topContent">
		Deze gebruikers hebben hun eigen vragenlijst nog niet ingevuld:
		<table>
		<?php
			$users = get_users_not_answered_own_questions();
			if($users){
				foreach ($users as $user) {
					?>
					<tr>
						<td style="width: 75%;"><?php echo $user['Firstname'].' '.$user['Lastname']; ?></td>
						<td>
							<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
								<input type="hidden" name="user_name" value="<?php echo $user['Firstname'].' '.$user['Lastname']; ?>">
								<input type="hidden" name="email" value="<?php echo $user['Email']; ?>">
								<input type="submit" name="reminder_1" value="Stuur herinnering">
							</form>
						</td>
					</tr>
					<?php
				}
			}else{
				?>
					Elke gebruiker heeft zijn eigen vragenlijst ingevuld. Fase 2 kan gestart worden.
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
						<input type="submit" name="start_fase_2" value="Start fase 2">
					</form>
				<?php

			}
		?>
		</table>
	</div>
	<div class="middleContent">

		<h3>Lijst van batches:</h3>
		Er kan maar 1 batch in 'Init' state zijn, en maar 1 batch in 'Running' state. Er staat geen limiet op het aantal batches in 'Finished' state.
		<?php
		$batches = get_batches();
		?>
		<table id="batches">
			<tr>
				<th>ID</th>
				<th>Init Date</th>
				<th>Running Date Phase 1</th>
				<th>Running Date Phase 2</th>
				<th>Finished Date</th>
				<th>Status</th>
				<th>Comment</th>
				<th>Action</th>
			</tr>
			<?php
			foreach ($batches as $batch) {
				?>
				<tr>
					<td><?php echo $batch['ID']; ?></td>
					<td><?php echo $batch['Init_date']; ?></td>
					<td><?php echo $batch['Running1_date']; ?></td>
					<td><?php echo $batch['Running2_date']; ?></td>
					<td><?php echo $batch['Finished_date']; ?></td>
					<td><?php echo get_batch_status_name($batch['Status']); ?></td>
					<td><?php echo $batch['Comment']; ?></td>
					<td>
						<?php include('includes/form/change_batch_status.php'); ?>
					</td>
				</tr>
				

				<?php
			}
			?>
		</table>
	</div>
	<div class="bottomContent">
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
						<th>Gemiddelde score</th>
					</tr>
					<?php
					foreach($answers as $answer){
						$question = $answer['Question'];
						$average_score = get_average_score_poll($poll, $question);
						?>
						<tr>
							<td><?php echo $answer['ID']; ?></td>
							<td><?php echo $answer['Poll']; ?></td>
							<td><?php echo $answer['Question']; ?></td>
							<td><?php echo $answer['Answer']; ?></td>
							<td><?php echo $answer['Last_Update']; ?></td>
							<td>
								<?php 
									if($average_score == ""){
										echo "Er is geen gemiddelde score bekend voor deze vraag";
									}else{
										echo $average_score;
									} 
								?>
							</td>
						</tr>
						<?php
					}

					?>
					<h2>Gemiddelde score (alle vragenlijsten samen):
						<?php
							
							if($average_score == ""){
								echo "Er is geen gemiddelde score bekend voor deze vraag";
							}else{
								echo $average_score;
							}
						?>
					</h2>
				</table>
				<?php
			}
		}
		?>
	</div>
</div>
<?php
if(isset($_POST['change_batch_status'])){
	switch ($_POST['change_batch_status']) {
		case 'Init':
			break;
		case 'Start':
			start_batch($_POST['batch_id']);
			break;
		case 'Run':
			run_batch($_POST['batch_id']);
			break;
		case 'Stop':
			stop_batch($_POST['batch_id']);
			break;
		default:
				# code...
		break;
	}
}
if(isset($_POST['reminder_1'])){
	$user = $_POST['user_name'];
	$email = $_POST['email'];
	send_reminder_phase1($user, $email);
}
?>
	<?php
		if(isset($_POST['add_poll'])){
			$reviewer 	= $_POST['reviewer'];
			$reviewee 	= $_POST['reviewee'];
			$status		= $_POST['status'];
			$error = create_poll($reviewer,$reviewee,$status);
		}
	?>
	<aside class="topSidebar">
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
			</select>
			<input type="submit" value="Voeg toe" name="add_poll" />
		</form>
		<?php echo $error; ?>
	</aside>
	<aside class="middleSidebar">
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
	</aside>
	<?php
	if(isset($_POST['answer_question'])){
		$question = $_POST['question'];
		$poll = $_POST['poll'];
		$answer = $_POST['answer'];
		answer($poll, $question, $answer);
	}
	?>
	<aside class="bottomSidebar">
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
							$user_department = get_user_department($user['ID']);
							if($user_department == $department['ID']){
								?><option value="<?php echo $user['Username']; ?>"><?php echo $user['Firstname'].' '.$user['Lastname']; ?></option>
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
							$user_department = get_user_department($user['ID']);
							if($user_department == $department['ID']){
								?><option value="<?php echo $user['Username']; ?>"><?php echo $user['Firstname'].' '.$user['Lastname']; ?></option>
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
							$user_department = get_user_department($user['ID']);
							if($user_department == $department['ID']){
								?><option value="<?php echo $user['Username']; ?>"><?php echo $user['Firstname'].' '.$user['Lastname']; ?></option>
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
	</aside>
	<?php
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
	<?php require('includes/footer.php') ?>