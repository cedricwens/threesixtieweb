<?php
include'core/init.php';
if(isset($_GET['parameter']) && isset($_GET['value'])){
	edit_parameter($_GET['parameter'],$_GET['value']);
	echo mysql_error();
	$parameters = get_parameters();
	?>
	<table>
		<tr style="text-align:center;">
			<th>Parameter</th>
			<th>Waarde</th>
			<th>Actie</th>
		</tr>
	<?php
	foreach ($parameters as $parameter) {
		?>
		<tr>
			<form action="" method="post">
				<td><?php echo $parameter['Name']; ?></td>
				<td style="text-align:center;"><input type="text" value="<?php echo $parameter['Value']; ?>" size="1" id="value<?php echo $parameter['ID']; ?>" /></td>
				<script>
					parameter<?php echo $parameter['ID']; ?> = document.getElementById("value<?php echo $parameter['ID']; ?>");
				</script>
				<td><input type="submit" value="Wijzigen" onclick="edit_parameter(<?php echo $parameter['ID']; ?>,parameter<?php echo $parameter['ID']; ?>.value);" /></td>
			</form>
		</tr>
		<?php
	}
	?>
	</table>
	<?php
}
?>