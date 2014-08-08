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