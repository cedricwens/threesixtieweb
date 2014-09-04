<?php
if(isset($_GET['Start'])){
	$result = "";
	?>
	<div class="content">
		<?php
		if(isset($_GET['Poll']) && get_poll_status($_GET['Poll']) != get_poll_status_id('Commentaar')){
			?>
			<div class="sidebarContent">
				<?php include('includes/aside/fase2.php'); ?>
			</div>
			<?php
		}
		if(!isset($_GET['Poll'])){
			if(!empty($_POST['user']) && !empty($_POST['comment']) && isset($_POST['add_comment'])){
				$id = $_POST['user'];
				$comment = $_POST['comment'];
				add_comment($id, $comment);
			}
			?>
			<div class="topContent">
				<h3><?php echo get_text('Select_poll_to_answer'); ?></h3>
				<?php
					$polls = get_polls_by_reviewer($_SESSION['user_id'], get_running2_batch_id());
					if($polls){
						?>
						<table>
							<?php
							foreach ($polls as $poll) {
								if($poll['Reviewer'] != $poll['Reviewee']){
									?>
									<tr>
										<?php $user = get_user_by_id($poll['Reviewee']); ?>
										<td style="width: 75%;"><?php echo $user[0].' '.$user[1]; ?></td>
										<td>
											<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
												<input type="hidden" name="Start" value="<?php echo get_text('Start'); ?>" />
												<input type="hidden" name="Poll" value="<?php echo $poll['ID']; ?>" />
												<?php
													if($poll['Status'] == get_poll_status_id('Ingestuurd')){
														?>
														<input type="submit" value="<?php echo get_text('Poll_already_answered'); ?>" />
														<?php
													}else{
														?>
														<input type="submit" name="answer_poll" value="<?php echo get_text('Answer_poll'); ?>" />
														<?php
													}
												?>
											</form>
										</td>
									</tr>
									<?php
								}
							}
							?>
						</table>
						<?php
					}else{
						echo get_text('No_polls_found');
					}
				?>
			</div>
			<div class="middleContent">
				<h3><?php echo get_text('Written_extra_comment_about'); ?>:</h3>
				<?php
					$polls = get_only_comment_polls($_SESSION['user_id'], get_running2_batch_id());
					if($polls){
						?>
						<table>
							<?php
							foreach ($polls as $poll) {
								if($_SESSION['user_id'] != $poll['Reviewee']){
									?>
									<tr>
										<?php $user = get_user_by_id($poll['Reviewee']); ?>
										<td style="width: 50%;"><?php echo $user[0].' '.$user[1]; ?></td>
										<td>
											<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
												<input type="hidden" name="Start" value="<?php echo get_text('Start'); ?>" />
												<input type="hidden" name="Poll" value="<?php echo $poll['ID']; ?>" />
												<?php
													if($poll['Status'] == get_poll_status_id('Ingestuurd')){
														?>
														<input type="submit" value="<?php echo get_text('Poll_already_answered'); ?>" />
														<?php
													}else{
														?>
														<input type="submit" name="edit_comment" value="<?php echo get_text('Edit_comment'); ?>" />
														<input type="submit" name="delete_comment" value="<?php echo get_text('Delete_comment'); ?>" />
														<?php
													}
												?>
											</form>
										</td>
									</tr>
									<?php
								}
							}
							?>
						</table>
						<?php
					}else{
						echo get_text('No_polls_found');
					}
				?>
			</div>
			<div class="bottomContent">
				<h3><?php echo get_text('Extra_comment_about_user'); ?></h3>
				<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
					<label for="user"><?php echo get_text('User'); ?>: </label>
					<select name="user">
						<option value=""><?php echo get_text('Choose_a').' '.strtolower(get_text('User')); ?></option>
						<?php
						foreach ($departments as $department) {
							?>
							<optgroup label="<?php echo $department['Name']; ?>">
								<?php
								$users = get_not_reviewed_users($_SESSION['user_id']);
								foreach ($users as $user) {
									$user_department = get_user_department($user['ID']);
									if($user_department == $department['ID']){
										?><option value="<?php echo $user['ID']; ?>"><?php echo $user['Firstname'].' '.$user['Lastname']; ?></option>
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
					<textarea name="comment" class="comment"></textarea>
					<br />
					<input type="submit" value="<?php echo get_text('Add'); ?>" name="add_comment" />
				</form>
			</div>
			<?php
		}else{
			if(isset($_GET['delete_comment'])){
				delete_comment($_GET['Poll']);
			}
			$poll = $_GET['Poll'];
			$poll_status = get_poll_status($poll);
			$reviewee_id = get_poll_reviewee($poll);
			$reviewee = get_user_by_id($reviewee_id);
			if(isset($_POST['answer_questions']) || isset($_POST['save_questions']) || isset($_POST['add_comment'])){
				if(!isset($_POST['add_comment'])){
					$poll = get_poll_by_reviewer_reviewee_batch($_SESSION['user_id'],$reviewee_id, get_running2_batch_id());
					for ($question=1; $question < 30; $question++) {
						$answer = $_POST[$question];
						answer($poll, $question, $answer);
					}
					if(isset($_POST['answer_questions'])){
						change_poll_status($poll, 'Ingestuurd');
						$result = "<p>".get_text('Poll_send_successfully')."</p>";
						if(isset($_POST['comment'])){
							$comment = $_POST['comment'];
							add_poll_comment($poll,$comment);
							$result = "<p>".get_text('Comment_added_successfully')."</p>";
						}
					}else if(isset($_POST['save_questions'])){
						change_poll_status($poll, 'Opgeslagen');
						if(isset($_POST['comment'])){
							$comment = $_POST['comment'];
							add_poll_comment($poll,$comment);
							$result = "<p>".get_text('Comment_added_successfully')."</p>";
						}
						$result = "<p>".get_text('Poll_saved_successfully')."</p>";
					}
				}else{
					add_comment($reviewee_id, $_POST['comment']);
				}
		
				?>
				<div class="topContent">
					<?php if($result){echo $result;} ?>
					<p><?php echo get_text('Click_next_to_select_new_poll'); ?></p>
					<p><?php echo get_text('Click_back_to_return_to_poll'); ?></p>
					<h3 class="back"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?Start=start&amp;Poll=<?php echo $poll; ?>"><?php echo get_text('Back'); ?></a></h3>
					<h3 class="next"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?Start=start"><?php echo get_text('Next'); ?></a></h3>
				</div>
					
				<?php
			}else{
				?>
				<div class="topContent">
					<h3><?php echo get_text('Poll_about'); ?>: <?php echo $reviewee[0].' '.$reviewee[1]; ?></h3>
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?Start=start&amp;Poll=<?php echo $poll; ?>">
					<?php
					if($poll_status != get_poll_status_id('Commentaar')){ 
						?>
						<table class="questions">
							<thead>
								<tr>
									<th><?php get_text('Question'); ?></th>
									<?php
									for ($value=1; $value < 7; $value++) { 
										?>
										<th><?php echo get_answer_name($value); ?></th>
										<?php
									}
									?>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($categories as $category) {
									?>
									<td colspan="7"><b><?php echo $category['Name']; ?></b></td>
									<?php
									foreach ($questions as $key=>$question) {
										if($category['ID'] == $question['Category']){
											?>
											<tr id="poll">
												<td><?php echo ($key+1).'. '.$question['Question']; ?></td>
												<?php
												if($poll_status == get_poll_status_id('Niet ingevuld')){
													for ($value=1; $value < 7; $value++) {
														?>
														<td style="text-align:center;">
															<input type="radio" name="<?php echo $question['ID']; ?>" value="<?php echo $value; ?>" <?php if($value == get_answer_value_by_name('Neutraal')){echo 'checked';} ?>/>
														</td>
														<?php
													}
												}else if($poll_status == get_poll_status_id('Opgeslagen')){
													for ($value=1; $value < 7; $value++) {
														?>
														<td style="text-align:center;">
															<input type="radio" name="<?php echo $question['ID']; ?>" value="<?php echo $value; ?>" <?php if($value == get_answer($poll, $question['ID'])){echo 'checked';} ?>/>
														</td>
														<?php
													}
												}else if($poll_status == get_poll_status_id('Ingestuurd')){
													for ($value=1; $value < 7; $value++) {
														?>
														<td style="text-align:center;">
															<input type="radio" name="<?php echo $question['ID']; ?>" value="<?php echo $value; ?>" <?php if($value == get_answer($poll, $question['ID'])){echo 'checked';} ?> disabled />
														</td>
														<?php
													}
												}
												?>
											</tr>
											<?php
										}
									}
								}
								?>
							</tbody>
						</table>
						<?php
					}
					?>
					<p><b><?php echo get_text('Add_extra_comment_here'); ?>:</b></p>
					<textarea class="comment" <?php if($poll_status == get_poll_status_id('Ingestuurd')){echo "disabled";} ?> id="comment" name="comment"><?php if(get_comment($poll)){ echo get_comment($poll);} ?></textarea>
					<br />
					<?php
					if($poll_status == get_poll_status_id('Ingestuurd')){
						?>
						<h3><a href="<?php $_SERVER['PHP_SELF'];?>?Start&amp;Step=2"><?php echo get_text('Next'); ?></a></h3>
						<?php
					}else if($poll_status == get_poll_status_id('Commentaar')){ 
						?>
						<input type="submit" value="<?php echo get_text('Send'); ?>" name="add_comment" />
						<?php
					}else{
						?>
						<input type="submit" value="<?php echo get_text('Save'); ?>" name="save_questions" />
						<input type="submit" value="<?php echo get_text('Send'); ?>" name="answer_questions" />
						<br />
						<?php
						echo get_text('Save_explanation');
						echo "<br />";
						echo get_text('Submit_explanation');
					}
					?>
					</form>
				</div>
				<?php
			}
		}
		?>
	</div>
	<?php
	if(isset($_GET['Poll']) && get_poll_status($_GET['Poll']) != get_poll_status_id('Commentaar')){
		?>
		<div class="topSidebar step">
			<?php include('includes/aside/fase2.php'); ?>
		</div>	
		<?php
	}
}else{
	?>
	<div class="topContent">
		<?php echo get_text('Phase2_text'); ?>
		<span id="start"><a href="?Start"><h1><?php echo get_text('View').' '.strtolower(get_text('Polls')); ?> >></h1></a></span>
	</div>
	<?php
}
?>