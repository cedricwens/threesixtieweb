<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?Start&amp;Step=1">
	<?php 
	$user = get_user_by_id($_SESSION['user_id']);
	?>
	<h3><?php echo get_text('Poll_about').': '.$user[0].' '.$user[1]; ?></h3>
	<table class="questions">
		<?php
		$number = 1;
		foreach ($categories as $category) {
			?>
			<thead>
				<tr style="margin-top: 25px;">
					<th><?php echo $category['Name']; ?></th>
					<?php
					for ($value=1; $value < 7; $value++) { 
						?>
						<th style="font-size: 12px;"><?php echo get_answer_name($value); ?></th>
						<?php
					}
					?>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach ($questions as $question) {
				if($category['ID'] == $question['Category']){
					?>
					<tr id="poll">
						<td><?php echo $number.'. '.$question['Question']; ?></td>
						<?php
						if($poll_status == get_poll_status_id('Niet ingevuld')){
							for ($value=1; $value < 7; $value++) {
								?>
								<td style="text-align:center;">
									<input type="radio" name="<?php echo $question['ID']; ?>" value="<?php echo $value; ?>" <?php if($value == get_answer_value_by_name('Neutraal')){echo 'checked';} ?>/>
								</td>
								<?php
							}
						}else if($poll_status == get_poll_status_id('Opgeslagen')){
							for ($value=1; $value < 7; $value++) {
								?>
								<td style="text-align:center;">
									<input type="radio" name="<?php echo $question['ID']; ?>" value="<?php echo $value; ?>" <?php if($value == get_answer($poll, $question['ID'])){echo 'checked';} ?>/>
								</td>
								<?php
							}
						}else if($poll_status == get_poll_status_id('Ingestuurd')){
							for ($value=1; $value < 7; $value++) {
								?>
								<td style="text-align:center;">
									<input type="radio" name="<?php echo $question['ID']; ?>" value="<?php echo $value; ?>" <?php if($value == get_answer($poll, $question['ID'])){echo 'checked';} ?> disabled />
								</td>
								<?php
							}
						}
						?>
					</tr>
					<?php
					$number++;
				}
			}
			?>
			<tr class="spacer"></tr>
			<?php
		}
		?>
		</tbody>
	</table>
	<?php
	if($poll_status == get_poll_status_id('Ingestuurd')){
		?>
		<h3><a href="<?php $_SERVER['PHP_SELF'];?>?Start&amp;Step=2"><?php echo get_text('Next'); ?></a></h3>
		<?php
	}else{
		?>
		<input type="submit" value="<?php echo get_text('Save'); ?>" name="save_own_questions" />
		<input type="submit" value="<?php echo get_text('Send'); ?>" name="answer_own_questions" />
		<br />
		<?php
		echo get_text('Save_explanation');
		echo "<br />";
		echo get_text('Submit_explanation');
	}
	?>
</form>