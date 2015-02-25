<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
    <label for="user"><?php echo get_text('Select_a') . ' ' . strtolower(get_text('User')); ?>: </label>
    <select name="user">
        <option value=""><?php echo get_text('Choose_a') . ' ' . strtolower(get_text('User')); ?></option>
        <?php
        foreach ($departments as $department) {
            ?>
            <optgroup label="<?php echo $department['Name']; ?>">
                <?php
                foreach ($users as $user) {
                    $user_department = get_user_department($user['ID']);
                    if ($user_department == $department['ID']) {
                        $selected = (isset($_POST['user']) && !empty($_POST['user']) && $user['Username'] == $_POST['user']);
                        if (!$selected) {
                            if (isset($_POST['poll']) && !empty($_POST['poll'])) {
                                $poll = $_POST['poll'];
                                $reviewee_id = get_poll_reviewee($poll);
                                $selected = ($user['ID'] == $reviewee_id);
                            }
                        }
                        ?>
                        <option
                            value="<?php echo $user['Username']; ?>" <?php if ($selected) {
                            echo 'selected';
                        } ?>><?php echo $user['Firstname'] . ' ' . $user['Lastname']; ?></option>
                    <?php
                    }
                }
                ?>
            </optgroup>
        <?php
        }
        ?>
    </select>
    <br/>
    <input type="submit" value="<?php echo get_text('View'); ?>" name="view_user_info"/>
</form>