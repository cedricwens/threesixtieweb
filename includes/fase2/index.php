<?php
if(isset($_GET['Start'])){
	?>
	<div class="content">
		<div class="sidebarContent">
			<?php include('includes/aside/fase2.php'); ?>
		</div>
		<?php
		if(!isset($_GET['Poll'])){
			?>
			<div class="topContent">
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
												<input type="hidden" name="Start" value="start" />
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

			<?php
		}else{
			$poll = $_GET['Poll'];
			$poll_status = get_poll_status($poll);
			$reviewee_id = get_poll_reviewee($poll);
			$reviewee = get_user_by_id($reviewee_id);
			if(isset($_POST['answer_questions']) || isset($_POST['save_questions'])){
				$poll = get_poll_by_reviewer_reviewee_batch($_SESSION['user_id'],$reviewee_id, get_running2_batch_id());
				for ($question=1; $question < 30; $question++) {
					$answer = $_POST[$question];
					answer($poll, $question, $answer);
				}
				if(isset($_POST['answer_questions'])){
					change_poll_status($poll, 'Ingestuurd');
					$result = "<p>".get_text('Poll_send_successfully')."</p>";
				}else if(isset($_POST['save_questions'])){
					change_poll_status($poll, 'Opgeslagen');
					$result = "<p>".get_text('Poll_send_successfully')."</p>";
				}
				if(isset($_POST['comment'])){
					$comment = $_POST['comment'];
					add_poll_comment($poll,$comment);
				}
				?>
				<div class="topContent">
					<?php echo $result; ?>
					<p><?php get_text('Click_next_for_next_step'); ?></p>
					<h3 class="back"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?Start=start&Poll=<?php echo $poll; ?>"><?php echo get_text('Back'); ?></a></h3>
					<h3 class="next"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?Start=start"><?php echo get_text('Next'); ?></a></h3>
				</div>
					
				<?php
			}else{
				?>
				<div class="topContent">
					<h3><?php echo $reviewee[0].' '.$reviewee[1]; ?></h3>
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?Start=start&Poll=<?php echo $poll; ?>">
						<table class="questions">
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
							<?php
							foreach ($categories as $category) {
								?>
								<td colspan="7"><b><?php echo $category['Name']; ?></b></td>
								<?php
								foreach ($questions as $key=>$question) {
									if($category['ID'] == $question['Category']){
										?>
										<tr>
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
						</table>
						<p><b>Als je nog extra opmerking hebt, kan je deze hieronder invullen:</b></p>
						<textarea style="width:50%; height: 100px;" <?php if($poll_status == get_poll_status_id('Ingestuurd')){echo "disabled";} ?> name="comment"><?php /*if(get_comment($poll)){ */echo get_comment($poll);/* } */?></textarea>
						<br />
						<?php
						if($poll_status == get_poll_status_id('Ingestuurd')){
							?>
							<h3><a href="<?php $_SERVER['PHP_SELF'];?>?Start&amp;Step=2"><?php echo get_text('Next'); ?></a></h3>
							<?php
						}else{
							?>
							<input type="submit" value="<?php echo get_text('Send'); ?>" name="answer_questions" />
							<input type="submit" value="<?php echo get_text('Save'); ?>" name="save_questions" />
							<?php
						}
						?>
					</form>
				</div>
				<?php
			}
		}
		?>
	</div>
	<div class="topSidebar step">
		<?php include('includes/aside/fase2.php'); ?>
	</div>
<?php
}else{
	?>
	<div class="topContent">
		<?php echo get_text('Phase2_text'); ?>
		<span id="start"><a href="?Start"><h1><?php echo get_text('View').' '.strtolower(get_text('Polls')); ?> >></h1></a></span>
	</div>
	<?php
}
?>