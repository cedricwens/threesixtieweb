<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?Start&Step=1">
	<table class="questions">
		<tr>
			<th><?php get_text('Question'); ?></th>
			<?php
			for ($value=1; $value < 7; $value++) { 
				?>
				<th><?php echo get_answer_name($value); ?></th>
				<?php
			}
			?>
		</tr>
		<?php
		$number = 1;
		foreach ($categories as $category) {
			?>
			<td colspan="7"><b><?php echo $category['Name']; ?></b></td>
			<?php
			foreach ($questions as $question) {
				if($category['ID'] == $question['Category']){
					?>
					<tr>
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
		}
		?>
	</table>
	<?php
	if($poll_status == get_poll_status_id('Ingestuurd')){
		?>
		<h3><a href="<?php $_SERVER['PHP_SELF'];?>?Start&Step=2">Verder</a></h3>
		<?php
	}else{
		?>
		<input type="submit" value="<?php echo get_text('Send'); ?>" name="answer_own_questions" />
		<input type="submit" value="<?php echo get_text('Save'); ?>" name="save_own_questions" />
		<?php
	}
	?>
</form>