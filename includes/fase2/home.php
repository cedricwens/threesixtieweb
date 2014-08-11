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
					$polls = get_polls_by_reviewer($_SESSION['user_id']);
					?>
					<table>
						<?php
						foreach ($polls as $poll) {
							if($poll['Reviewer'] != $poll['Reviewee']){
								?>
								<tr>
									<?php $user = get_user_name($poll['Reviewee']); ?>
									<td style="width: 75%;"><?php echo $user[0].' '.$user[1]; ?></td>
									<td>
										<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
											<input type="hidden" name="Start" value="start" />
											<input type="hidden" name="Poll" value="<?php echo $poll['ID']; ?>" />
											<?php
												if($poll['Status'] == get_poll_status_id('Ingestuurd')){
													?>
													<input type="submit" value="Deze enquete werd reeds ingevuld" disabled="disabled" />
													<?php
												}else{
													?>
													<input type="submit" name="answer_poll" value="Vragenlijst invullen" />
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
				<!--<h3><a href="<?php echo $_SERVER['PHP_SELF']; ?>?Start&amp;Step=1">Verder</a></h3>-->
			</div>

			<?php
		}else{
			$poll = $_GET['Poll'];
			$poll_status = get_poll_status($poll);
			$reviewee_id = get_poll_reviewee($poll);
			$reviewee = get_user_name($reviewee_id);
			if(isset($_POST['answer_questions']) || isset($_POST['save_questions'])){
				$poll = get_poll_by_reviewer_reviewee($_SESSION['user_id'],$reviewee_id);	
				for ($question=1; $question < 30; $question++) {
					$answer = $_POST[$question];
					answer($poll, $question, $answer);
				}
				if(isset($_POST['answer_questions'])){
					change_poll_status($poll, 'Ingestuurd');
					$result = "<p>Je vragenlijst is succesvol doorgestuurd.</p>";
				}else if(isset($_POST['save_questions'])){
					change_poll_status($poll, 'Opgeslagen');
					$result = "<p>Je vragenlijst is succesvol opgeslagen.</p>";
				}
				?>
				<div class="topContent">
					<?php echo $result; ?>
					<p>Klik op Volgende om naar de volgende stap te gaan.</p>
					<h3><a href="<?php echo $_SERVER['PHP_SELF']; ?>?Start=start&Poll=<?php echo $poll; ?>">Vorige</a></h3>
					<h3><a href="<?php echo $_SERVER['PHP_SELF']; ?>?Start=start">Volgende</a></h3>
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
							$number = 1;
							foreach ($categories as $category) {
								?>
								<td colspan="7"><b><?php echo $category['Name']; ?></b></td>
								<?php
								foreach ($questions as $question) {
									if($category['ID'] == $question['Category']){
										?>
										<tr>
											<td><?php echo $number.'. '.$question['Question']; ?></td>
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
										$number++;
									}
								}
							}
							?>
						</table>
						<?php
						if($poll_status == get_poll_status_id('Ingestuurd')){
							?>
							<h3><a href="<?php $_SERVER['PHP_SELF'];?>?Start&Step=2">Verder</a></h3>
							<?php
						}else{
							?>
							<input type="submit" value="Versturen" name="answer_questions" />
							<input type="submit" value="Opslaan" name="save_questions" />
							<?php
						}
						?>
					</form>
				</div>
				<?php
				/*$poll = get_poll_by_reviewer_reviewee($_SESSION['user_id'],$_SESSION['user_id']);
				if($poll){
					$poll_status = get_poll_status($poll);
					echo '<div class="topContent">';
						include('includes/form/own_poll.php');
					echo '</div>';
				}else{
					echo '<div class="topContent">Er is een fout opgetreden. Probeer later nog eens.</div>';
				}*/
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
		Welkom bij het ThreeSixtyWeb evaluatieproject, fase 2.
		<br />
		We hebben het algoritme losgelaten op onze database en deze heeft dan, rekening houdend met uw voorkeuren, koppels berekend.
		<br />
		De voor u berekende koppels worden op de volgende pagina weergegeven. U kan vanaf nu de vragenlijsten van deze gebruikers invullen.
		<span id="start"><a href="?Start"><h1>Bekijk vragenlijsten >></h1></a></span>
	</div>
	<?php
}
?>