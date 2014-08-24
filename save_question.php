<?php
include'core/init.php';
if(isset($_GET['id']) && isset($_GET['question'])){
	save_question($_GET['id'],$_GET['question']);
	echo mysql_error();
	$categories = get_categories();
	if($categories){
		foreach ($categories as $category) {
			?>
			<table>
				<tr>
					<td colspan="3"><h3><?php echo $category['Name']; ?></h3></td>
				</tr>
			</table>
			<?php
			foreach ($questions as $key=>$question) {
				if($question['Category'] == $category['ID']){
					?>
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
						<table>
							<tr>
								<td width="90%"><?php echo $key+1; echo '. '.$question['Question']; ?></td>
								<td>
									<input type="hidden" name="question_id" value="<?php echo $question['ID']; ?>" />
									<input type="submit" name="edit" value="<?php echo get_text('Edit'); ?>" />
								</td>
								<td>
									<input type="submit" name="delete" value="<?php echo get_text('Delete'); ?>" />
								</td>
							</tr>
						</table>
					</form>
					<?php
				}
			}
		}
	}
}
?>