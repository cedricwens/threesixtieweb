<h3><?php echo get_text('Who_may_answer_your_poll'); ?></h3>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?Start&amp;Step=2" method="post">
    <?php
    foreach ($users as $user) {
        if ($user['ID'] != $_SESSION['user_id']) {
            $batch = get_running1_batch_id();
            if (is_preferred_reviewer($_SESSION['user_id'], $user['ID'], $batch)) {
                ?>
                <input type="checkbox" name="preferred_reviewer[]" id="<?php echo $user['Username']; ?>"
                       value="<?php echo $user['Username']; ?>" checked/><label
                    for="<?php echo $user['Username']; ?>"><?php echo $user['Lastname'] . ' ' . $user['Firstname']; ?></label>
                <br/>
            <?php
            } else {
                ?>
                <input type="checkbox" name="preferred_reviewer[]" id="<?php echo $user['Username']; ?>"
                       value="<?php echo $user['Username']; ?>"/><label
                    for="<?php echo $user['Username']; ?>"><?php echo $user['Lastname'] . ' ' . $user['Firstname']; ?></label>
                <br/>
            <?php
            }
        }
    }
    ?>
    <input type="submit" value="<?php echo get_text('Send'); ?>" name="add_preferred_reviewers">
</form>