<?php
if(isset($_GET['Start'])){
	?>
	<div class="content">
		<div class="sidebarContent">
				<ol>
					<li class="<?php if(!isset($_GET['Step'])){ echo 'activeStep';} ?>">Vragenlijst selecteren</li>
					<li class="<?php if(isset($_GET['Step']) && $_GET['Step'] == 1){ echo 'activeStep';} ?>">Vragenlijst invullen</li>
				</ol>
			</div>
		<?php
		if(!isset($_GET['Step'])){
			?>
			<div class="topContent">
				
				<h3><a href="<?php echo $_SERVER['PHP_SELF']; ?>?Start&amp;Step=1">Verder</a></h3>
			</div>

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
					$result = "<p>Je vragenlijst is succesvol doorgestuurd.</p>";
				}else if(isset($_POST['save_own_questions'])){
					change_poll_status($poll, 'Opgeslagen');
					$result = "<p>Je vragenlijst is succesvol opgeslagen.</p>";
				}
				?>
				<div class="topContent">
					<?php echo $result; ?>
					<p>Klik op Volgende om naar de volgende stap te gaan.</p>
					<h3><a href="<?php echo $_SERVER['PHP_SELF']; ?>?Start&Step=1">Vorige</a></h3>
					<h3><a href="<?php echo $_SERVER['PHP_SELF']; ?>?Start&Step=2">Volgende</a></h3>
				</div>
					
				<?php
			}else if(isset($_POST['add_preferred_reviewers'])){
				if(isset($_POST['preferred_reviewer'])){
					$preferred_reviewers = $_POST['preferred_reviewer'];
					$reviewee = get_username_by_id($_SESSION['user_id']);

					foreach ($preferred_reviewers as $preferred_reviewer){
						add_preferred($preferred_reviewer, $reviewee, $reviewee);
					}
					?>
					<div class="topContent">
						<p>Klik op Volgende om naar de volgende stap te gaan.</p>
						<h3><a href="<?php echo $_SERVER['PHP_SELF']; ?>?Start&Step=2">Vorige</a></h3>
						<h3><a href="<?php echo $_SERVER['PHP_SELF']; ?>?Start&Step=3">Volgende</a></h3>
					</div>
					<?php
				}else{
					$error = "Gelieve minstens x gebruikers te selecteren.";
					?>
					<div class="topContent">
						<?php echo $error; ?>
						<br />
						<h3><a href="<?php echo $_SERVER['PHP_SELF']; ?>?Start&Step=2">Vorige</a></h3>
					</div>
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
					$error = "Gelieve minstens x gebruikers te selecteren.";
					?>
					<div class="topContent">
						<?php echo $error; ?>
						<br />
						<h3><a href="<?php echo $_SERVER['PHP_SELF']; ?>?Start&Step=3">Vorige</a></h3>
					</div>
					<?php
					$success = false;
				}
				/*foreach ($preferred_reviewers as $preferred_reviewer) {
					echo $preferred_reviewer;
				}*/
				if($success){
				?>
					<div class="topContent">
						<p>U bent aan het einde gekomen van fase 1.</p>
						<p>Zodra alle gebruikers fase 1 hebben afgerond, zal fase 2 beginnen.</p>
						U zult via mail een bericht ontvangen wanneer fase 2 begint, zodat u de reviews van de andere gebruikers kan invullen.</p>
						<h3><a href="<?php echo $_SERVER['PHP_SELF']; ?>?Start&Step=3">Vorige</a></h3>
						<h3><a href="<?php echo $_SERVER['PHP_SELF']; ?>">Afsluiten</a></h3>
					</div>
					<?php
				}
			}else if($_GET['Step'] == 1){
				$poll = get_poll_by_reviewer_reviewee($_SESSION['user_id'],$_SESSION['user_id']);
				if($poll){
					$poll_status = get_poll_status($poll);
					echo '<div class="topContent">';
						include('includes/form/own_poll.php');
					echo '</div>';
				}else{
					echo '<div class="topContent">Er is een fout opgetreden. Probeer later nog eens.</div>';
				}
			}else if($_GET['Step'] == 2){
				echo '<div class="topContent">';
					include('includes/form/preferred_reviewer.php');
				echo '</div>';
			}else if($_GET['Step'] == 3){
				echo '<div class="topContent">';
					include('includes/form/preferred_reviewee.php');
				echo '</div>';
			}
		}
		?>
	</div>
	<div class="topSidebar step">
		<ol>
			<li class="<?php if(!isset($_GET['Step'])){ echo 'activeStep';} ?>">Start</li>
			<li class="<?php if(isset($_GET['Step']) && $_GET['Step'] == 1){ echo 'activeStep';} ?>">Vragenlijst invullen</li>
			<li class="<?php if(isset($_GET['Step']) && $_GET['Step'] == 2){ echo 'activeStep';} ?>">Keuze: Jouw vragenlijst</li>
			<li class="<?php if(isset($_GET['Step']) && $_GET['Step'] == 3){ echo 'activeStep';} ?>">Keuze: Andere vragenlijst</li>
		</ol>
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