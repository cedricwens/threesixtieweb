<?php
	require('includes/header.php');
	protect_page();
?>
<?php
if(isset($_GET['Start'])){
	?>
	<div id="aside">
		<ol>
			<li class="<?php if(!isset($_GET['Step'])){ echo 'active';} ?>">Start</li>
			<li class="<?php if(isset($_GET['Step']) && $_GET['Step'] == 1){ echo 'active';} ?>">Vragenlijst invullen</li>
			<li class="<?php if(isset($_GET['Step']) && $_GET['Step'] == 2){ echo 'active';} ?>">Keuze: Jouw vragenlijst</li>
			<li class="<?php if(isset($_GET['Step']) && $_GET['Step'] == 3){ echo 'active';} ?>">Keuze: Andere vragenlijst</li>
		</ol>
	</div>
	<div id="content">
		<?php
		if(!isset($_GET['Step'])){
			?>
			Het ThreeSixtyWeb evalutieproject bestaat uit twee fasen:
			<ol>
				<li>
					Fase 1 gaat over je eigen vragenlijst. Deze fase bestaat op zijn beurt weer uit 3 stappen:
					<ol>
						<li>Tijdens de eerste stap moet je je eigen vragenlijst invullen. Zodra deze vragenlijst is ingevuld, kan je deze insturen. Het is ook mogelijk om de vragenlijst op te slaan, zodat je deze later nog kan aanpassen. Zodra je de antwoorden op de vragenlijst heb doorgestuurd, is het niet meer mogelijk om deze aan te passen.</li>
						<li>Zodra je je eigen vragenlijst hebt doorgestuurd, kom je op een nieuw scherm terecht. Op dit scherm dient u medewerkers te selecteren waarvan u graag hebt dat zijn dezelfde vragenlijst over u invullen.</li>
						<li>Op het laatste venster dien je tenslotte medewerkers te selecteren waarvan u graag de vragenlijst invult</li>
						De selecties die u hebt gemaakt in stap 1 en 2 worden gebruikt om de bepalen welke vragenlijsten u uiteindelijk mag invullen, en welke medewerkers u vragenlijst zullen invullen.
					</ol>
				</li>
				<li>
					Zodra alle gebruikers fase 1 hebben afgerond, wordt fase 2 gestart. Tijdens deze fase dient u de vragenlijsten in te vullen van een aantal medewerkers.
					Ook hier is het mogelijk om de vragenlijst op te slaan, zodat u deze later nog kan aanpassen alvorens deze definitief te verzenden.
				</li>
			</ol>
			<a href="<?php echo $_SERVER['PHP_SELF']; ?>?Start&amp;Step=1">Verder</a>

			<?php
		}else{
			if(isset($_POST['answer_own_questions']) || isset($_POST['save_own_questions'])){
				$poll = get_poll_by_reviewer_reviewee($_SESSION['user_id'],$_SESSION['user_id']);	
				for ($question=1; $question < 30; $question++) {
					$answer = $_POST[$question];
					answer($poll, $question, $answer);
				}
				if(isset($_POST['answer_own_questions'])){
					change_poll_status($poll, 'Ingestuurd');
					?>
					<p>Je vragenlijst is succesvol doorgestuurd.</p>
					<?php
				}else if(isset($_POST['save_own_questions'])){
					change_poll_status($poll, 'Opgeslagen');
					?>
					<p>Je vragenlijst is succesvol opgeslagen.</p>
					<?php
				}
				?>
					
					<p>Klik op Volgende om naar de volgende stap te gaan.</p>
					<a href="<?php echo $_SERVER['PHP_SELF']; ?>?Start&Step=1">Vorige</a>
					<a href="<?php echo $_SERVER['PHP_SELF']; ?>?Start&Step=2">Volgende</a>
					
				<?php
			}else if(isset($_POST['add_preferred_reviewers'])){
				if(isset($_POST['preferred_reviewer'])){
					$preferred_reviewers = $_POST['preferred_reviewer'];
					$reviewee = get_username_by_id($_SESSION['user_id']);

					foreach ($preferred_reviewers as $preferred_reviewer){
						add_preferred($preferred_reviewer, $reviewee, $reviewee);
					}
					$success = true;
				}else{
					echo "Gelieve minstens x gebruikers te selecteren.";
					?>
					<br />
					<a href="<?php echo $_SERVER['PHP_SELF']; ?>?Start&Step=2">Vorige</a>
					<?php
					$success = false;
				}
				/*foreach ($preferred_reviewers as $preferred_reviewer) {
					echo $preferred_reviewer;
				}*/
				if($success){
				?>
					<p>Klik op Volgende om naar de volgende stap te gaan.</p>
					<a href="<?php echo $_SERVER['PHP_SELF']; ?>?Start&Step=2">Vorige</a>
					<a href="<?php echo $_SERVER['PHP_SELF']; ?>?Start&Step=3">Volgende</a>
					<?php
				}
			}else if(isset($_POST['add_preferred_reviewees'])){
				if(isset($_POST['preferred_reviewee'])){
					$preferred_reviewees = $_POST['preferred_reviewee'];
					$reviewer = get_username_by_id($_SESSION['user_id']);

					foreach ($preferred_reviewees as $preferred_reviewee){
						add_preferred($reviewer, $preferred_reviewee, $reviewer);
					}
					$success = true;
				}else{
					echo "Gelieve minstens x gebruikers te selecteren.";
					?>
					<br />
					<a href="<?php echo $_SERVER['PHP_SELF']; ?>?Start&Step=3">Vorige</a>
					<?php
					$success = false;
				}
				/*foreach ($preferred_reviewers as $preferred_reviewer) {
					echo $preferred_reviewer;
				}*/
				if($success){
				?>
					<p>Klik op Volgende om naar de volgende stap te gaan.</p>
					<a href="<?php echo $_SERVER['PHP_SELF']; ?>?Start&Step=3">Vorige</a>
					<a href="<?php echo $_SERVER['PHP_SELF']; ?>?Start&Step=3">Volgende</a>
					<?php
				}
			}else if($_GET['Step'] == 1){
				?>
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?Start&Step=1">
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
						$poll = get_poll_by_reviewer_reviewee($_SESSION['user_id'],$_SESSION['user_id']);
						$poll_status = get_poll_status($poll);
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
							<a href="<?php $_SERVER['PHP_SELF'];?>?Start&Step=2">Verder</a>
							<?php
						}else{
							?>
							<input type="submit" value="Versturen" name="answer_own_questions" />
							<input type="submit" value="Opslaan" name="save_own_questions" />
							<?php
						}
						?>
				</form>
				<?php
			}else if($_GET['Step'] == 2){
				?>
				<h3>Welke medewerkers mogen de vragenlijst over jouw invullen?</h3>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>?Start&Step=2" method="post">
					<?php
					foreach ($users as $user){
						if($user['ID'] != $_SESSION['user_id']){
							if(is_preferred_reviewer($_SESSION['user_id'], $user['ID'])){
								?>
								<input type="checkbox" name="preferred_reviewer[]" value="<?php echo $user['Username']; ?>" checked /><?php echo $user['Firstname'].' '.$user['Lastname']; ?><br />
								<?php
							}else{
								?>
								<input type="checkbox" name="preferred_reviewer[]" value="<?php echo $user['Username']; ?>" /><?php echo $user['Firstname'].' '.$user['Lastname']; ?><br />
								<?php
							}
						}
					}
					?>
					<input type="submit" value="Versturen" name="add_preferred_reviewers">
				</form>
				<?php
			}else if($_GET['Step'] == 3){
				?>
				<h3>Van welke medewerkers wil jij de vragenlijst invullen?</h3>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>?Start&Step=3" method="post">
					<?php
					foreach ($users as $user){
						if($user['ID'] != $_SESSION['user_id']){
							if(is_preferred_reviewee($_SESSION['user_id'], $user['ID'])){
								?>
								<input type="checkbox" name="preferred_reviewee[]" value="<?php echo $user['Username']; ?>" checked /><?php echo $user['Firstname'].' '.$user['Lastname']; ?><br />
								<?php
							}else{
								?>
								<input type="checkbox" name="preferred_reviewee[]" value="<?php echo $user['Username']; ?>" /><?php echo $user['Firstname'].' '.$user['Lastname']; ?><br />
								<?php
							}
						}
					}
					?>
					<input type="submit" value="Versturen" name="add_preferred_reviewees">
				</form>
				<?php
			}
		}
		?>
	</div>
	<?php
}else{
	?>
	Welkom bij het ThreeSixtyWeb evaluatieproject.
	<br />
	Klik op <b>Start</b> om de vragenlijsten in te vullen.
	<span id="start"><a href="?Start"><h1>Start >></h1></a></span>
	<?php
}
?>
<?php require('includes/footer.php'); ?>