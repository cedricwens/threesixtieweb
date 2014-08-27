<?php
$selected_page = "Admin";
require_once('includes/header.php');
if(!isset($_SESSION['admin_id'])){
	header('Location:admin_login.php');
}
$add_user_message = "";
$add_department_message = "";
?>
<div class="content">
	<?php
	if(get_running1_batch_id() || get_running2_batch_id()){
		?>
		<div class="topContent questions_list" id="parameters">
			<table>
			<?php
				if(get_running1_batch_id()){
					$users = get_users_not_answered_own_questions();
					if($users){
						$number = 0;
						foreach ($users as $user) {
							$number++;
						}
						?>
						<tbody>
							<tr>
								<td style="width: 100%;"><b><?php echo $number; ?></b> <?php echo get_text('Users_have_not_filled_in_own_poll'); ?>.</td>
								<td>
									<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
										<input type="submit" name="reminder_1" value="<?php echo get_text('Send_reminder'); ?>">
									</form>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<?php
									if(isset($_POST['reminder_1'])){
										foreach ($users as $user) {
											send_reminder_phase1($user['Firstname'], $user['Email']);
										}
										echo get_text('Reminder_send').'.';
									}
									?>
								</td>
							</tr>
						</tbody>
						<?php
					}else{
						echo get_text('Every_user_has_answered_own_poll_can_start_phase_2');
					}
				}else if(get_running2_batch_id()){
					$users = get_users_not_answered_other_questions();
					if($users){
						$number = 0;
						foreach ($users as $user) {
							$number++;
						}
						?>
						<tr>
							<td><b><?php echo $number; ?></b> <?php echo get_text('Users_have_not_filled_in_other_poll'); ?>.</td>
							<td>
								<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
									<input type="submit" name="reminder_2" value="<?php echo get_text('Send_reminder'); ?>">
								</form>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<?php
								if(isset($_POST['reminder2'])){
									foreach ($users as $user) {
										send_reminder_phase2($user['Firstname'], $user['Email']);
									}
									echo get_text('Reminder_send').'.';
								}
								?>
							</td>
						</tr>
						<?php
					}else{
						echo get_text('Every_user_has_answered_other_poll_can_start_publish_results');
					}
				}

			?>
			</table>
		</div>
		<?php
	}else if(get_init_batch_id()){
		?>
		<div class="topContent" id="parameters">
			<?php
			$parameters = get_parameters();
			?>
			<table>
				<thead>
					<tr style="text-align:center;">
						<th><?php echo get_text('Parameter'); ?></th>
						<th><?php echo get_text('Value'); ?></th>
						<th><?php echo get_text('Action'); ?></th>
					</tr>
				</thead>
			<tbody>
			<?php
			foreach ($parameters as $parameter) {
				?>
					<tr>
						<form action="" method="post">
							<td><?php echo $parameter['Name']; ?></td>
							<td><input type="text" value="<?php echo $parameter['Value']; ?>" size="1" id="value<?php echo $parameter['ID']; ?>" /></td>
							<script>
								parameter<?php echo $parameter['ID']; ?> = document.getElementById("value<?php echo $parameter['ID']; ?>");
							</script>
							<td><input type="submit" value="<?php echo get_text('Edit'); ?>" onclick="edit_parameter(<?php echo $parameter['ID']; ?>,parameter<?php echo $parameter['ID']; ?>.value);" /></td>
						</form>
					</tr>
				<?php
			}
			?>
			</tbody>
			</table>
		</div>
		<?php
	}else{
		?>
		<div class="topContent">
			<?php echo get_text('Admin_intro'); ?>
		</div>
		<?php
	}
	?>
	<div class="middleContent">

		<h2><?php echo get_text('List_of_batches'); ?>:</h2>
		<?php
		echo get_text('Batches_text');
		$batches = get_batches();
		
		if($batches){
			?>
			<table class="users">
				<thead>
					<tr>
						<th><?php echo get_text('ID'); ?></th>
						<th><?php echo get_text('Init_date'); ?></th>
						<th><?php echo get_text('Start_phase_1'); ?></th>
						<th><?php echo get_text('Start_phase_2'); ?></th>
						<th><?php echo get_text('Finished_date'); ?></th>
						<th><?php echo get_text('Status'); ?></th>
						<th><?php echo get_text('Comment'); ?></th>
						<th><?php echo get_text('Action'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($batches as $batch) {
							?>
							<tr>
								<td><?php echo $batch['ID']; ?></td>
								<td><?php echo $batch['Init_date']; ?></td>
								<td>
									<?php
									if($batch['Running1_date']){
										echo $batch['Running1_date'];
									}else{
										echo "\\";
									}
									?>
								</td>
								<td>
									<?php
									if($batch['Running2_date']){
										echo $batch['Running2_date'];
									}else{
										echo "\\";
									}
									?>
								</td>
								<td>
									<?php
									if($batch['Finished_date']){
										echo $batch['Finished_date'];
									}else{
										echo "\\";
									}
									?>
								</td>
								<td><?php echo get_batch_status_name($batch['Status']); ?></td>
								<td>
									<?php
									if($batch['Comment']){
										echo $batch['Comment'];
									}else{
										echo "\\";
									}
									?>
								</td>
								<td>
									<?php include('includes/form/change_batch_status.php'); ?>
								</td>
							</tr>
							<?php
					}
					?>
				</tbody>
			</table>
			<?php
		}else{
			echo '<br />'.get_text('No_batches_found');
		}
		if(isset($_POST['add_batch'])){
			add_batch();
		}
		?>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<input type="submit" name="add_batch" value="<?php echo get_text('Add_batch'); ?>" />
		</form>
	</div>
	<?php
	 if(get_init_batch_id()){
		?>
		<div class="bottomContent">
			<h2><?php echo get_text('Questions'); ?></h2>
			<?php
			if(isset($_POST['edit'])){
				?>
				<div id="questions">
					<?php
					$categories = get_categories();
					if($categories){
						foreach ($categories as $category) {
							?>
							<table>
								<thead>
									<tr>
										<td colspan="3"><h3><?php echo $category['Name']; ?></h3></td>
									</tr>
								</thead>
							</table>
							<?php
							foreach ($questions as $key=>$question) {
								if($question['Category'] == $category['ID']){
									?>
									<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="questions_list" name="save_question">
										<table>
											<tbody>
												<tr>
													<?php
														if($question['ID'] == $_POST['question_id']){
															?>
															<td style="width: 100%;"><textarea class="comment" name="question_text" id="question_text"><?php echo $question['Question']; ?></textarea></td>
															<?php
														}else{
															?>
															<td><?php echo $key+1; ?></td>
															<td><?php echo $question['Question']; ?></td>
															<?php
														}
													?>
													<td>
														<input type="hidden" name="question_id" id="question_id" value="<?php echo $question['ID']; ?>" />
														<?php
														if($question['ID'] == $_POST['question_id']){
															?>
															<input type="submit" name="save" value="<?php echo get_text('Save'); ?>" />
															<?php
														}else{
															?>
															<input type="submit" name="edit" value="<?php echo get_text('Edit'); ?>" />
															<!--</td>
															<td>
																<input type="submit" name="delete" value="<?php echo get_text('Delete'); ?>" />-->
															<?php
														}
														?>
													</td>
												</tr>
											</tbody>
										</table>
									</form>
									<?php
								}
							}
						}
					}
				?>
				</div>
				<?php
			}else if(isset($_POST['save'])){
				$question = $_POST['question_text'];
				$id = $_POST['question_id'];
				save_question($id, $question);
			}else if(isset($_POST['delete'])){
				delete_question($_POST['question_id']);
			}else if(isset($_POST['add']) && !empty($_POST['question'])){
				add_question($_POST['question'], $_POST['category']);
			}else{
				?>
				<div id="questions">
					<?php
					$categories = get_categories();
					if($categories){
						foreach ($categories as $category) {
							?>
							<table>
								<thead>
									<tr>
										<td colspan="3"><h3><?php echo $category['Name']; ?></h3></td>
									</tr>
								</thead>
							</table>
							<?php
							foreach ($questions as $key=>$question) {
								if($question['Category'] == $category['ID']){
									?>
									<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="questions_list">
										<table>
											<tbody>
												<tr>
													<td><?php echo $key+1; ?></td>
													<td><?php echo $question['Question']; ?></td>
													<td>
														<input type="hidden" name="question_id" value="<?php echo $question['ID']; ?>" />
														<input type="submit" name="edit" value="<?php echo get_text('Edit'); ?>" />
													</td>
													<!--<td>
														<input type="submit" name="delete" value="<?php echo get_text('Delete'); ?>" />
													</td>-->
												</tr>
											</tbody>
										</table>
									</form>
									<?php
								}
							}
						}
					}
					?>
					<h3><?php echo get_text('Add_question'); ?></h3>
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
						<textarea name="question" class="comment"></textarea>
						<select name="category">
							<?php 
							$categories = get_categories();
							if($categories){
								foreach ($categories as $category) {
									?>
									<option value="<?php echo $category['Name']; ?>"><?php echo $category['Name']; ?></option>
									<?php
								}
							}
							?>
						</select>
						<input type="submit" name="add" value="<?php echo get_text('Add'); ?>">
					</form>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	}
	?>
	
</div>
<?php
		/*if(isset($_POST['add_poll'])){
			$reviewer 	= $_POST['reviewer'];
			$reviewee 	= $_POST['reviewee'];
			$status		= $_POST['status'];
			$error = create_poll($reviewer,$reviewee,$status);
		}*/
		if(isset($_POST['add_user'])){
			$firstname 	= $_POST['firstname'];
			$lastname 	= $_POST['lastname'];
			$department	= $_POST['department'];
			$email 		= $_POST['email'];
			if(!empty($_POST['job_title'])){
				$job_title = $_POST['job_title'];
				$error = add_user($firstname,$lastname,$department,$email,$job_title);
			}else{
				$error = add_user($firstname,$lastname,$department,$email,NULL);
			}
		}else if(isset($_GET['AddUser'])){
			$add_user_message = "Gebruiker toegevoegd";
		}else if(isset($_POST['add_department'])){
			$department = $_POST['department'];
			$manager = $_POST['manager'];
			add_department($department, $manager);
		}else if(isset($_GET['AddDepartment'])){
			$add_department_message = "Department toegevoegd";
		}
	?>
	<aside class="topSidebar">
		<h2><?php echo get_text('Add_user'); ?></h2>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<label for="firstname"><?php echo get_text('Firstname'); ?>: </label><br /><input type="text" id="firstname" name="firstname" required /><br />
			<label for="lastname"><?php echo get_text('Lastname'); ?>: </label><br /><input type="text" id="lastname" name="lastname" required /><br />
			<label for="department"><?php echo get_text('Department'); ?>: </label><br />
			<select id="department" name="department">
				<?php
				foreach ($departments as $department) {
					?>
					<option value="<?php echo $department['Name']; ?>"><?php echo $department['Name']; ?></option>
					<?php
				}
				?>
			</select><br />
			<label for="email"><?php echo get_text('Email'); ?>: </label><br /><input type="text" id="email" name="email" required /><br />
			<label for="job_title"><?php echo get_text('Job_title'); ?>: </label><br /><input type="text" id="job_title" name="job_title" /><br />
			<input type="submit" value="<?php echo get_text('Add_user'); ?>" name="add_user" />
		</form>
		<?php echo $add_user_message; ?>
	</aside>
	<aside class="middleSidebar">
		<h2><?php echo get_text('Add_department'); ?></h2>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<label for="user_department"><?php echo get_text('Department'); ?>: </label><br /><input type="text" id="user_department" name="department" required /><br />
			<label for="manager"><?php echo get_text('Manager'); ?>: <br />
			<select id="manager" name="manager">
				<?php
				$managers = get_managers_info();
				if($managers){
					foreach ($managers as $manager) {
						?>
						<option value="<?php echo $manager['ID']; ?>"><?php echo $manager['Lastname'].' '.$manager['Firstname']; ?></option>
						<?php
					}
				}else{
					?>
					<option value=""><?php echo get_text('No_managers_found'); ?></option>
					<?php
				}
				?>
				<br />
			</select><br />
			<input type="submit" value="<?php echo get_text('Add_department'); ?>" name="add_department" />
		</form>
		<?php echo $add_department_message; ?>
	</aside>
	<!--<aside class="topSidebar">
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
			<input type="submit" value="<?php echo get_text('Add_poll'); ?>" name="add_poll" />
		</form>
		<?php echo $error; ?>
	</aside>-->
	<!--<aside class="middleSidebar">
		<h2><?php echo get_text('Add_answer'); ?></h2>
		<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
			<label for="question"><?php echo get_text('Question'); ?>: </label>
			<select name="question">
				<?php
				foreach ($categories as $category) {
					?>
					<optgroup label="<?php echo $category['Name']; ?>">
						<?php
						foreach ($questions as $key=>$question) {
							if($question['Category'] == $category['ID']){
								?>
								<option value="<?php echo $question['ID']; ?>"><?php echo $key+1; echo ". ".$question['Question']; ?></option>
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
					<option value="<?php echo $poll['ID']; ?>"><?php echo $reviewer[0].' '.strtolower(get_text('About')).' '.$reviewee[0]; ?></option>
					<?php
				}
				?>
			</select>
			<br />
			<label for="answer"><?php echo get_text('Answer'); ?>: </label><input type="text" name="answer" /><br />
			<input type="submit" value="<?php echo get_text('Answers'); ?>" name="answer_question"/>
		</form>
	</aside>-->
	<?php
	if(isset($_POST['answer_question'])){
		$question = $_POST['question'];
		$poll = $_POST['poll'];
		$answer = $_POST['answer'];
		answer($poll, $question, $answer);
	}
	?>
	<!--<aside class="bottomSidebar">
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
						$users = get_users();
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
			<input type="submit" value="<?php echo get_text('Add'); ?>" name="add_preferred" />
		</form>
	</aside>-->
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