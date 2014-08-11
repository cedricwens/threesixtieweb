<?php
if(isset($_GET['Start'])){
	?>
	<div class="content">
		<div class="sidebarContent">
			<?php include('includes/aside/fase1.php'); ?>
		</div>
		<?php
		if(!isset($_GET['Step'])){
			?>
			<div class="topContent">
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
		<?php include('includes/aside/fase1.php'); ?>
	</div>
<?php
}else{
	?>
	<div class="topContent">
		Welkom bij het ThreeSixtyWeb evaluatieproject.
		<br />
		Klik op <b>Start</b> om de vragenlijsten in te vullen.
		<span id="start"><a href="?Start"><h1>Start >></h1></a></span>
	</div>
	<?php
}
?>