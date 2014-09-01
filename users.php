<?php
$selected_page = 'Users';
require_once('includes/header.php');
if(!isset($_SESSION['admin_id'])){
	header('Location:admin_login.php');
}
?>

<div class="topContent">
	<h2><?php echo get_text('Edit_or_delete_users'); ?></h2>
	<div id="users" class="user_list">
		<table class="users">
			<thead>
				<tr>
					<th><?php echo get_text('ID'); ?></th>
					<th><?php echo get_text('Firstname'); ?></th>
					<th><?php echo get_text('Lastname'); ?></th>
					<th><?php echo get_text('Email'); ?></th>
					<th><?php echo get_text('Department'); ?></th>
					<th><?php echo get_text('Action'); ?></th>
				</tr>
			</thead>
		</table>
		<?php 
		if(isset($_POST['delete'])){
			$id = $_POST['user_id'];
			delete_user($id);
		}else if(isset($_POST['edit'])){
			$id = $_POST['user_id'];
			$user = get_user_by_id($id);
			$email = get_user_email_by_id($id);
			$department = get_department_name(get_user_department($id));
			?>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="users">
				<table>
					<tbody>
						<tr>
							<td><?php echo $id; ?></td>
							<td><input type="text" value="<?php echo $user['Firstname']; ?>" name="firstname" /></td>
							<td><input type="text" value="<?php echo $user['Lastname']; ?>" name="lastname" /></td>
							<td><input type="text" value="<?php if($email){echo $email;}else{echo '\\';} ?>" name="email" /></td>
							<td>
								<select id="department" name="department">
									<?php
									foreach ($departments as $department) {
										if($department['ID'] == get_user_department($id)){
											?>
											<option value="<?php echo $department['Name']; ?>" selected><?php echo $department['Name']; ?></option>
											<?php
										}else{
											?>
												<option value="<?php echo $department['Name']; ?>"><?php echo $department['Name']; ?></option>
											<?php
										}
									}
									?>
								</select>
							</td>
								<!--<input type="text" value="<?php echo $department; ?>" name="department" /></td>-->
							<td>
								<input type="hidden" value="<?php echo $id; ?>" name="user_id">
								<input type="submit" value="<?php echo get_text('Save'); ?>" name="save" />
							</td>
						</tr>
					</tbody>
				</table>
			</form>
			<?php
		}else if(isset($_POST['save'])){
			$id = $_POST['user_id'];
			$firstname = $_POST['firstname'];
			$lastname = $_POST['lastname'];
			$department = $_POST['department'];
			$email = $_POST['email'];
			save_user($id, $firstname, $lastname, $email, $department);
		}

		foreach ($users as $user) {
			$email = get_user_email_by_id($user['ID']);
			$department = get_department_name(get_user_department($user['ID']));
			?>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="users">
				<table>
					<tbdoy>
						<tr>
							<td><?php echo $user['ID']; ?></td>
							<td><?php echo $user['Firstname']; ?></td>
							<td><?php echo $user['Lastname']; ?></td>
							<td>
								<?php
								if($email){
									echo $email;
								}else{
									echo '\\';
									}
								?>
							</td>
							<td><?php echo $department; ?></td>
							<td>
								<input type="hidden" value="<?php echo $user['ID']; ?>" name="user_id">
								<input type="submit" value="<?php echo get_text('Edit'); ?>" name="edit" />
								<input type="submit" value="<?php echo get_text('Delete'); ?>" name="delete" />
							</td>
						</tr>
					</tbdoy>
				</table>
			</form>
			<?php
		}
		?>
	</div>
</div>

<?php require_once('includes/footer.php'); ?>