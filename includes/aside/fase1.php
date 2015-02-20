<ol>
    <li class="<?php if (!isset($_GET['Step'])) {
        echo 'activeStep';
    } ?>">Start
    </li>
    <li class="<?php if (isset($_GET['Step']) && $_GET['Step'] == 1) {
        echo 'activeStep';
    } ?>"><?php echo get_text('Answer_poll'); ?></li>
    <li class="<?php if (isset($_GET['Step']) && $_GET['Step'] == 2) {
        echo 'activeStep';
    } ?>"><?php echo get_text('Choice') . ': ' . get_text('Your_poll'); ?></li>
    <li class="<?php if (isset($_GET['Step']) && $_GET['Step'] == 3 && !isset($_POST['add_preferred_reviewees'])) {
        echo 'activeStep';
    } ?>"><?php echo get_text('Choice') . ': ' . get_text('Other_polls'); ?></li>
    <li class="<?php if (isset($_POST['add_preferred_reviewees'])) {
        echo 'activeStep';
    } ?>"><?php echo get_text('End'); ?></li>
</ol>