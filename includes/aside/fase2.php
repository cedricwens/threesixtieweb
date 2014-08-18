<ol>
	<li class="<?php if(!isset($_GET['Poll'])){ echo 'activeStep';} ?>"><?php echo get_text('Select_poll'); ?></li>
	<li class="<?php if(isset($_GET['Poll'])){ echo 'activeStep';} ?>"><?php echo get_text('Answer_poll'); ?></li>
</ol>