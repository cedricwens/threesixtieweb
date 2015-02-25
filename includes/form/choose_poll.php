<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
    <label for="poll"><?php echo get_text('Select_a') . ' ' . strtolower(get_text('Poll')); ?>: </label>
    <select name="poll">
        <option value=""><?php echo get_text('Choose_a') . ' ' . strtolower(get_text('Poll')); ?></option>
        <?php
        if (isset($_POST['user']) && !empty($_POST['user'])) {
            $id = get_user_id($_POST['user']);
        }
        if (isset($_POST['poll']) && !empty($_POST['poll'])) {
            $id = get_poll_reviewee($_POST['poll']);
        }
        if (!empty($id)) {
            $batch = get_published_batch_id();
            $polls = get_polls_by_reviewee($id, $batch);
            foreach ($polls as $poll) {
                $selected = (isset($_POST['poll']) && $poll['ID'] == $_POST['poll']);
                $name = get_user_by_id($poll['Reviewer']);
                $reviewer = $name[0] . ' ' . $name[1];
                ?>
                <option
                    value="<?php echo $poll['ID']; ?>" <?php if ($selected) {
                    echo 'selected';
                } ?>><?php echo get_text('Answered_by') . ': ' . $reviewer; ?></option>
            <?php
            }
        }
        ?>
    </select>
    <br/>
    <input type="submit" value="<?php echo get_text('View'); ?>" name="view_poll_info"/>
</form>