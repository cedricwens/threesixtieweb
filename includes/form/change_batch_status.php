<form action="" method="post">
<input type="hidden" name="batch_id" value="<?php echo $batch['ID']; ?>" />
	<?php
	if(get_batch_status_name($batch['Status']) == 'Init'){
		?>
		<input type="submit" name="change_batch_status" onclick="change_batchstatus(<?php echo $batch['ID']; ?>, 'Start')" value="Start" <?php if(get_running1_batch_id() || get_running2_batch_id()){echo 'disabled="disabled"';}?>/>
		<?php
	}else if(get_batch_status_name($batch['Status']) == 'Running1'){
		?>
		<input type="submit" name="change_batch_status" onclick="change_batchstatus(<?php echo $batch['ID']; ?>, 'Calculate')" value="Calculate Polls" <?php if(get_users_not_answered_own_questions()){echo 'disabled="disabled"';} ?> />
		<?php
	}else if(get_batch_status_name($batch['Status']) == 'Calculate'){
		?>
		<input type="submit" name="change_batch_status" onclick="change_batchstatus(<?php echo $batch['ID']; ?>, 'Run')" value="Run" />
		<?php
	}else if(get_batch_status_name($batch['Status']) == 'Running2'){
		?>
		<input type="submit" name="change_batch_status" onclick="change_batchstatus(<?php echo $batch['ID']; ?>, 'Publish')" value="Stop and Publish results" <?php if(get_users_not_answered_other_questions()){echo 'disabled="disabled"';} ?> />
		<?php
	}else if(get_batch_status_name($batch['Status']) == 'Published'){
		?>
		<input type="submit" name="change_batch_status" onclick="change_batchstatus(<?php echo $batch['ID']; ?>, 'Delete')" value="Delete" disabled="disabled" />
		<?php
	}
	?>
</form>