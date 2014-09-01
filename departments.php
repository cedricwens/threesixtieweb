<?php 
$selected_page = 'Departments';
require_once('includes/header.php');
if(!isset($_SESSION['admin_id'])){
	header('Location:admin_login.php');
}
?>

<div class="topContent">
	<h2><?php echo get_text('Edit_or_delete_departments'); ?></h2>
	<div id="departments" class="user_list">
		<table class="users">
			<thead>
				<tr>
					<th><?php echo get_text('ID'); ?></th>
					<th><?php echo get_text('Name'); ?></th>
					<th><?php echo get_text('Manager'); ?></th>
					<th><?php echo get_text('Action'); ?></th>
				</tr>
			</thead>
		</table>
		<?php 
		if(isset($_POST['delete'])){
			$id = $_POST['department_id'];
			delete_department($id);
		}else if(isset($_POST['edit'])){
			$id = $_POST['department_id'];
			$department = get_department_by_id($id);
			$managers = get_managers_info();
			?>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="users">
				<table>
					<tbody>
						<tr>
							<td><?php echo $id; ?></td>
							<td><input type="text" value="<?php echo $department['Name']; ?>" name="name" /></td>
							<td>
								<select id="manager" name="manager">
									<?php
									foreach ($managers as $manager) {
										if($manager['ID'] == $department['Manager']){		
											?>
											<option value="<?php echo $manager['ID']; ?>" selected><?php echo $manager['Firstname'].' '.$manager['Lastname']; ?></option>
											<?php
										}else{
											?>
											<option value="<?php echo $manager['ID']; ?>"><?php echo $manager['Firstname'].' '.$manager['Lastname']; ?></option>
											<?php
										}
									}
									?>
								</select>
							</td>
							<td>
								<input type="hidden" value="<?php echo $id; ?>" name="department_id">
								<input type="submit" value="<?php echo get_text('Save'); ?>" name="save" />
							</td>
						</tr>
					</tbody>
				</table>
			</form>
			<?php
		}else if(isset($_POST['save'])){
			$id = $_POST['department_id'];
			$name = $_POST['name'];
			$manager = $_POST['manager'];
			save_department($id, $name, $manager);
		}

		foreach ($departments as $department) {
			$manager = get_user_by_id($department['Manager']);
			?>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="users">
				<table>
					<tbody>
						<tr>
							<td><?php echo $department['ID']; ?></td>
							<td><?php echo $department['Name']; ?></td>
							<td><?php echo $manager['Firstname'].' '.$manager['Lastname']; ?></td>
							<td>
								<input type="hidden" value="<?php echo $department['ID']; ?>" name="department_id">
								<input type="submit" value="<?php echo get_text('Edit'); ?>" name="edit" />
								<input type="submit" value="<?php echo get_text('Delete'); ?>" name="delete" />
							</td>
						</tr>
					</tbody>
				</table>
			</form>
			<?php
		}
		?>
	</div>
</div>

<?php require_once('includes/footer.php'); ?>