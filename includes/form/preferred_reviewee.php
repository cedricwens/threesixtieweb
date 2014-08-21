<h3>Van welke medewerkers wil jij de vragenlijst invullen?</h3>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?Start&amp;Step=3" method="post">
	<?php
	foreach ($users as $user){
		if($user['ID'] != $_SESSION['user_id']){
			if(is_preferred_reviewee($_SESSION['user_id'], $user['ID'], get_running1_batch_id())){
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
	<input type="submit" value="<?php echo get_text('Send'); ?>" name="add_preferred_reviewees">
</form>