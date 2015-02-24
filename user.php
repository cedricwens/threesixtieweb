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
                <h2><?php echo get_text('Information') . ' ' . strtolower(get_text('About')) . ' ' . strtolower(get_text('User')); ?></h2>
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
                        echo "<p>" . get_text('Please_choose_a_user') . ".</p>";
                    }
                }
            ?>
        </div>
    </div>
<?php if (isset($_SESSION['admin_id'])) { ?>
    <aside class="topSidebar step">
        <h2><?php echo get_text('Information') . ' ' . strtolower(get_text('About')) . ' ' . strtolower(get_text('User')); ?></h2>
        <?php include('includes/form/choose_user.php'); ?>
    </aside>
<?php } ?>
<?php require('includes/footer.php'); ?>