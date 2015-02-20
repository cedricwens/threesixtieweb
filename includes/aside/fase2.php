<ol>
    <li class="<?php if (!isset($_GET['Poll'])) {
        echo 'activeStep';
    } ?>"><?php echo get_text('Select_poll'); ?></li>
    <li class="<?php if (isset($_GET['Poll']) && !isset($_POST['answer_questions']) && !isset($_POST['save_questions']) && !isset($_POST['add_comment'])) {
        echo 'activeStep';
    } ?>"><?php echo get_text('Answer_poll'); ?></li>
    <li class="<?php if (isset($_POST['answer_questions']) || isset($_POST['save_questions']) || isset($_POST['add_comment'])) {
        echo 'activeStep';
    } ?>"><?php echo get_text('End'); ?></li>
</ol>