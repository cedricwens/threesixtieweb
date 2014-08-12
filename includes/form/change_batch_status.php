<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="batch_id" value="<?php echo $batch['ID']; ?>" />
	<?php
	if(get_batch_status_name($batch['Status']) == 'Init'){
		?>
		<input type="submit" name="change_batch_status" value="Start" <?php if(get_running1_batch_id() || get_running2_batch_id()){echo 'disabled="disabled"';}?>/>
		<?php
	}else if(get_batch_status_name($batch['Status']) == 'Running1'){
		?>
		<input type="submit" name="change_batch_status" value="Run" />
		<?php
	}else if(get_batch_status_name($batch['Status']) == 'Running2'){
		?>
		<input type="submit" name="change_batch_status" value="Stop" />
		<?php
	}else if(get_batch_status_name($batch['Status']) == 'Finished'){
		?>
		<input type="submit" name="change_batch_status" value="Delete" disabled="disabled" />
		<?php
	}
	?>
</form>