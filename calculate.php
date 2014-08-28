<?php

/**
 * De verschillende poll scores: (hoge score is beter)
 * Teammanager:
 *		JA=  [0;	-10]
 *		NEE= [0;	10]
 * Usermember:
 * 		JA=	 [0;	-10]
 * 		NEE= [10; 	20]
 **/
set_time_limit(30);
$selected_page = "Home";
require('includes/header.php');
$users = get_users_order_by_id();
if(isset($_GET['id'])){
	if(isset($_POST['recalculate'])){
		calculate_couples($_GET['id']);
		header('Location: calculate.php?id='.$_GET['id']);
	}else if(isset($_POST['accept'])){
		accept_calculated_polls($_GET['id']);
	}
	echo '<div class="content">';
	foreach ($users as $user) {
		$user_name = get_user_by_id($user['ID']);
		echo '<div class="topContent">';
		echo '<h3>'.$user_name[0].' '.$user_name[1].'</h3>';
		get_candidate_user_info($user['ID']);
		echo '</div>';
	}
	echo '</div>';
	?>
	<aside class="topSidebar">
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $_GET['id']; ?>" method="post">
			<input type="hidden" name="batch_id" value="<?php echo $_GET['id']; ?>" />
			<input type="submit" name="recalculate" value="<?php echo get_text('Recalculate'); ?>" />
			<input type="submit" name="accept" value="<?php echo get_text('Accept'); ?>" />
		</form>
	</aside>
	<?php
}


?>