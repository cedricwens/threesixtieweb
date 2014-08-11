<ol>
	<li class="<?php if(!isset($_GET['Step'])){ echo 'activeStep';} ?>">Start</li>
	<li class="<?php if(isset($_GET['Step']) && $_GET['Step'] == 1){ echo 'activeStep';} ?>">Vragenlijst invullen</li>
	<li class="<?php if(isset($_GET['Step']) && $_GET['Step'] == 2){ echo 'activeStep';} ?>">Keuze: Jouw vragenlijst</li>
	<li class="<?php if(isset($_GET['Step']) && $_GET['Step'] == 3){ echo 'activeStep';} ?>">Keuze: Andere vragenlijst</li>
</ol>