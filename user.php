<?php require('includes/header.php'); ?>

<h2>Informatie over specifieke gebruiker</h2>
<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
	<label for="user">Selecteer gebruiker: </label>
		<select name="user">
			<option value="">Kies een gebruiker</option>
			<?php
				$users = get_users();
				$departments = get_departments();
				foreach ($departments as $department) {
					?>
					<optgroup label="<?php echo $department['Name']; ?>">
						<?php
						foreach ($users as $user) {
							if($user['Department'] == $department['ID']){
								?><option value="<?php echo $user['Name']; ?>"><?php echo $user['Name']; ?></option>
							<?php
							}
						}
					?>
					</optgroup>
					<?php
				}
				?>
		</select>
		<br />
	<input type="submit" value="Bekijk" name="view_user_info" />
</form>


<?php
if (isset($_POST['user']) && !empty($_POST['user'])) {
	$user = $_POST['user'];
	$id = get_user_id($user);
	echo "<h2>Informatie over: $user</h2>";
	get_user_info($id);
}
?>




<?php require('includes/footer.php'); ?>