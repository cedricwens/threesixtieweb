<?php
	include'core/init.php';
	add_batch();
	$batches = get_batches();
	echo mysql_error();
	?>
	<tr>
		<th><?php echo get_text('ID'); ?></th>
		<th><?php echo get_text('Init_date'); ?></th>
		<th><?php echo get_text('Running_phase_1'); ?></th>
		<th><?php echo get_text('Running_phase_2'); ?></th>
		<th><?php echo get_text('Finished_date'); ?></th>
		<th><?php echo get_text('Status'); ?></th>
		<th><?php echo get_text('Comment'); ?></th>
		<th><?php echo get_text('Action'); ?></th>
	</tr>
	<?php
	foreach ($batches as $batch) {
		?>
		<tr>
			<td><?php echo $batch['ID']; ?></td>
			<td><?php echo $batch['Init_date']; ?></td>
			<td><?php echo $batch['Running1_date']; ?></td>
			<td><?php echo $batch['Running2_date']; ?></td>
			<td><?php echo $batch['Finished_date']; ?></td>
			<td><?php echo get_batch_status_name($batch['Status']); ?></td>
			<td><?php echo $batch['Comment']; ?></td>
			<td>
				<?php include('includes/form/change_batch_status.php'); ?>
			</td>
		</tr>
	<?php
	}
	?>
	<tr>
		<td colspan="8">
			<form action="" method="post">
				<input type="submit" name="add_batch" onclick="add_batch()" value="<?php echo get_text('Add_batch'); ?>">
			</form>
		</td>
	</tr>