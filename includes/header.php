<?php
require('core/init.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo get_text('Title'); ?></title>
	<link rel="stylesheet" type="text/css" href="style.php">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--<link rel="stylesheet" type="text/css" href="main.css">-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script>
	function change_batchstatus(batch, action){
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
	  		xmlhttp=new XMLHttpRequest();
	  	}
		else{// code for IE6, IE5
	  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  	}
	  	xmlhttp.open("GET","change_batch_status.php?id="+batch+"&action="+action,true);
		xmlhttp.onreadystatechange=function(){
			console.log ('xmlhttp : ' + xmlhttp.readyState + ', ' + xmlhttp.status);
	  		if (xmlhttp.readyState==4 && xmlhttp.status==200){
	    			document.getElementById("batches").innerHTML=xmlhttp.responseText;
	    			location.reload();
	   		}
	  	}	
		xmlhttp.send();
	}
	function edit_parameter(parameter, value){
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
	  		xmlhttp=new XMLHttpRequest();
	  	}
		else{// code for IE6, IE5
	  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  	}
	  	xmlhttp.open("GET","edit_parameter.php?parameter="+parameter+"&value="+value,true);
		xmlhttp.onreadystatechange=function(){
	  		//if (xmlhttp.readyState==4 && xmlhttp.status==200){
	    		document.getElementById("parameters").innerHTML=xmlhttp.responseText;
	   		//}
	  	}	
		xmlhttp.send();
	}
	</script>
	<script>
		$(window).scroll(function() {
			if($(this).scrollTop() > 133){
				document.getElementById('menu').className = "menu_fixed";
				document.getElementById('mainContent').style.paddingTop = "62px";
			}
			else{
				document.getElementById('mainContent').style.paddingTop = "";
			 	document.getElementById('menu').className = "";
			}		
		});
	</script>
</head>
<body class="body">
	<header class="mainHeader" <?php if(isset($_SESSION['admin_id'])){ echo 'id="mainHeader"';} ?>>
		<img src="img/logo.png" />
	</header>
		<nav id="menu">
			<ul>
				<?php
					if((isset($_SESSION['user_id']) && !get_published_batch_id()) || (strpos($_SERVER['PHP_SELF'],'forgot.php')!== false)) {
						?>
						<li <?php if($selected_page == 'Home'){ echo 'class="active"';} ?>><a href="index.php"><?php echo get_text('Home'); ?></a></li>
						<?php
					}
					if(isset($_SESSION['user_id']) && get_published_batch_id()){
						?>
						<li <?php if($selected_page == 'User'){ echo 'class="active"';} ?>><a href="user.php"><?php echo get_text('My_results'); ?></a></li>
						<?php
					}
					?>
					<?php
					if(isset($_SESSION['admin_id'])){
						?>
						<li <?php if($selected_page == 'Admin'){ echo 'class="active"';} ?>><a href="admin.php"><?php echo get_text('Admin'); ?></a></li>
						<li <?php if($selected_page == 'Users'){ echo 'class="active"';} ?>><a href="users.php"><?php echo get_text('Users'); ?></a></li>
						<li <?php if($selected_page == 'Departments'){ echo 'class="active"';} ?>><a href="departments.php"><?php echo get_text('Departments'); ?></a></li>
						<?php
						if(get_published_batch_id()){?>
							<li <?php if($selected_page == 'User'){ echo 'class="active"';} ?>><a href="user.php"><?php echo get_text('Results'); ?></a></li>
						<?php
						}

					}
					if(logged_in() || isset($_SESSION['admin_id'])){
						?>
						<li><a href="logout.php"><?php echo get_text('Logout'); ?></a></li>
						<?php
					}
				?>
			</ul>
			<div class="handle"><?php echo get_text('Menu'); ?><span class="icon"></span></div>
		</nav>
	<div id="mainContent">