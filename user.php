<?php
$selected_page = "User";
require('includes/header.php');
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) {
    header('Location: login.php');
}
if (!get_running1_batch_id() && !get_running2_batch_id() && !get_published_batch_id() && isset($_SESSION['user_id'])) {
    // destroy session
    session_destroy();

    //unset cookies
    setcookie("username", "", time() - 7200);
    header('Location: login.php');
}
if (isset($_SESSION['admin_id']) && !get_published_batch_id()) {
    header('Location: admin.php');
}
?>
    <div class="content">
        <?php if (isset($_SESSION['admin_id'])) { ?>
            <aside class="sidebarContent">
                <h2><?php echo get_text('Information') . ' ' . strtolower(get_text('About')) . ' ' . strtolower(get_text('User_as_participant')); ?></h2>
                <?php include('includes/form/choose_user.php'); ?>
            </aside>
        <?php } ?>
        <div class="topContent">
            <?php
            if (isset($_SESSION['user_id'])) {
                if (get_published_batch_id()) {
                    $user = $_SESSION['user_id'];
                    $name = get_user_by_id($user);
                    $batch = get_published_batch_id();
                    echo "<h2>" . get_text('Information') . " " . strtolower(get_text('About')) . ": $name[0] $name[1]</h2>";
                    ?>
                    <p>
                        <a href="pdf.php?id=<?php echo $_SESSION['user_id']; ?>"><?php echo get_text('View') . ' ' . get_text('PDF'); ?></a>
                    </p>
                    <?php
                    get_user_info($user, $batch);
                }
            } else
                if (isset($_SESSION['admin_id'])) {
                    if (isset($_POST['user'])) {
                        if (empty($_POST['user'])) {
                            echo get_text('Please_choose_a_user');
                        } else {
                            $user = $_POST['user'];
                            $id = get_user_id($user);
                            $name = get_user_by_id($id);
                            $batch = get_published_batch_id();
                            echo "<h2>" . get_text('Information') . " " . strtolower(get_text('About')) . ": $name[0] $name[1]</h2>";
                            ?>
                            <p>
                                <a href="pdf.php?id=<?php echo $id; ?>"><?php echo get_text('View') . ' ' . get_text('PDF'); ?></a>
                            </p>
                            <?php
                            get_user_info($id, $batch);
                        }
                    } else {
                        if (isset($_POST['poll'])) {
                            if (empty($_POST['poll'])) {
                                echo get_text('Please_choose_a_poll');
                            } else {
                                $poll = $_POST['poll'];
                                $poll_status = get_poll_status($poll);
                                $reviewee_id = get_poll_reviewee($poll);
                                $reviewer_id = get_poll_reviewer($poll);
                                $reviewee = get_user_by_id($reviewee_id);
                                $reviewer = get_user_by_id($reviewer_id);
                                ?>
                                <h3><?php echo get_text('Answered_by'); ?>
                                    : <?php echo $reviewer[0] . ' ' . $reviewer[1]; ?></h3>
                                <h3><?php echo get_text('Poll_about'); ?>
                                    : <?php echo $reviewee[0] . ' ' . $reviewee[1]; ?></h3>
                                <?php if ($poll_status != get_poll_status_id('Commentaar')) { ?>
                                    <table class="questions">
                                        <?php
                                        $number = 1;
                                        foreach ($categories as $category) {
                                        ?>
                                        <thead>
                                        <tr style="margin-top: 25px;">
                                            <th id="category"><?php echo $category['Name']; ?></th>
                                            <?php
                                            for ($value = 1; $value < 7; $value++) {
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
                                            if ($category['ID'] == $question['Category']) {
                                                ?>
                                                <tr id="poll">
                                                    <td><?php echo $number . '. ' . $question['Question']; ?></td>
                                                    <?php
                                                    for ($value = 1; $value < 7; $value++) {
                                                        ?>
                                                        <td style="text-align:center;">
                                                            <input type="radio"
                                                                   name="<?php echo $question['ID']; ?>"
                                                                   value="<?php echo $value; ?>" <?php if ($value == get_answer($poll, $question['ID'])) {
                                                                echo 'checked';
                                                            } ?> disabled/>
                                                        </td>
                                                    <?php
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
                                }
                                ?>
                                <textarea class="comment" disabled id="comment"
                                          name="comment"><?php if (get_comment($poll)) {
                                        echo get_comment($poll);
                                    } ?></textarea>
                            <?php
                            }
                        } else {
                            echo "<p>" . get_text('Please_choose_a_user') . ".</p>";
                        }
                    }
                }
            ?>
        </div>
    </div>
<?php if (isset($_SESSION['admin_id'])) { ?>
    <aside class="topSidebar step">
        <h2><?php echo get_text('Information') . ' ' . strtolower(get_text('About')) . ' ' . strtolower(get_text('User_as_participant')); ?></h2>
        <?php include('includes/form/choose_user.php'); ?>
        <?php if ((isset($_POST['user']) && !empty($_POST['user'])) || (isset($_POST['poll']) && !empty($_POST['poll']))) { ?>
            <h2><?php
                $user = $_POST['user'];
                $id = get_user_id($user);
                $name = get_user_by_id($id);
                echo get_text('Information') . ' ' . strtolower(get_text('About')) . ' ' . strtolower(get_text('Polls')) . ' ' . strtolower(get_text('About')) . ": $name[0] $name[1]"; ?></h2>
            <?php include('includes/form/choose_poll.php'); ?>
        <?php } ?>
    </aside>
<?php } ?>
<?php require('includes/footer.php'); ?>