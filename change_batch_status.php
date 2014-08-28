<?php
	include'core/init.php';
	if(isset($_GET['id']) && isset($_GET['action'])){
		if($_GET['action'] != 'View'){
			$batch = $_GET['id'];
			$action = $_GET['action'];
			switch ($_GET['action']) {
				case 'Start':
					stop_batch(get_published_batch_id());
					start_batch($_GET['id']);
					
					break;
				case 'Calculate':
					calculate_couples($_GET['id']);
					break;
				case 'Accept':
					accept_calculated_polls($_GET['id']);
					break;
				case 'Run':
					run_batch($_GET['id']);
					break;
				case 'Publish':
					publish_batch($_GET['id']);
					break;
				case 'Stop':
					stop_batch($_GET['id']);
					break;
				default:
						# code...
				break;
			}
			$batches = get_batches();
			echo mysql_error();
			?>
			<tr>
				<th><?php echo get_text('ID'); ?></th>
				<th><?php echo get_text('Init_date'); ?></th>
				<th><?php echo get_text('Start_phase_1'); ?></th>
				<th><?php echo get_text('Start_phase_2'); ?></th>
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
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
						<input type="submit" name="add_batch" onclick="add_new_batch();" value="<?php echo get_text('Add_batch'); ?>" />
					</form>
				</td>
			</tr>
			<?php
		}
	}
?>