<?php
	include'core/init.php';
	add_batch();
	$batches = get_batches();
	echo mysql_error();
	?>
	<tr>
		<th>ID</th>
		<th>Init Date</th>
		<th>Running Date Phase 1</th>
		<th>Running Date Phase 2</th>
		<th>Finished Date</th>
		<th>Status</th>
		<th>Comment</th>
		<th>Action</th>
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
				<input type="submit" name="add_batch" onclick="add_batch()" value="Batch toevoegen">
			</form>
		</td>
	</tr>