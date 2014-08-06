<!DOCTYPE>
<html>
	<head>
		<title>ThreeSixtyWeb</title>
		<link rel="stylesheet" type="text/css" href="main.css">
	</head>
	<body>
		<div id="container">
			<div id="header_container">
				<header><h1>ThreeSixtyWeb</h1></header>
				<nav id="menu">
					<ul>
						<li><a href="index.php">Home</a></li>
						<li><a href="user.php">User</a></li>
					</ul>
				</nav>
			</div>
			<div class="content_wrapper">
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
	    										<li>Op het laatste venster dien je tenslotte medewerkers te selecteren waarvan u graag de vragen lijst invult</li>
	    										De selecties die u hebt gemaakt in stap 1 en 2 worden gebruikt om de bepalen welke vragenlijsten u uiteindelijk mag invullen, en welke medewerkers u vragenlijst zullen invullen.
	    									</ol>
	    								</li>
	    								<li>
	    									Zodra alle gebruikers fase 1 hebben afgerond, wordt fase 2 gestart. Tijdens deze fase dient u de vragenlijsten in te vullen van een aantal medewerkers.
	    									Ook hier is het mogelijk om de vragenlijst op te slaan, zodat u deze later nog kan aanpassen alvorens deze definitief te verzenden.
	    								</li>
	    							</ol>
	    						<?php
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
  			</div>
		</div>
	</body>
</html>