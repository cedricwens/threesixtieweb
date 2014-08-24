<?php
require('core/init.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>ThreeSixtyWeb</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--<link rel="stylesheet" type="text/css" href="main.css">-->
	<script type="text/javascript">
		function moveItem(a, b){
			var fromBox = document.getElementById(a),
		    	toBox = document.getElementById(b);

		  	for(var i=0, opts = fromBox.options; opts[i]; i++){
		    	if(opts[i].selected)
		    	{
		      		toBox.value = opts[i].value;

		      		if(toBox.selectedIndex == -1 || (opts[i].text != toBox.options[toBox.selectedIndex].text)){
		        		toBox.options.add(new Option(opts[i].text, opts[i].value));
		        		opts.remove(i);
		        		i--;
		      		}
		    	}
		  	}
		}
	</script>
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
	function save_question(question_id, question){
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
	  		xmlhttp=new XMLHttpRequest();
	  	}
		else{// code for IE6, IE5
	  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  	}
	  	xmlhttp.open("GET","save_question.php?id="+question_id+"&question="+question,true);
		xmlhttp.onreadystatechange=function(){
	  		if (xmlhttp.readyState==4 && xmlhttp.status==200){
	    			document.getElementById("questions").innerHTML=xmlhttp.responseText;
	    			location.reload();
	   		}
	  	}	
		xmlhttp.send();
	}
	</script>
</head>
<body class="body">
	<header class="mainHeader" <?php if(isset($_SESSION['admin_id'])){ echo 'id="mainHeader"';} ?>>
		<img src="img/logo.png" />
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
						<li <?php if($selected_page == 'User'){ echo 'class="active"';} ?>><a href="user.php"><?php echo get_text('User_results'); ?></a></li>
						<li <?php if($selected_page == 'Admin'){ echo 'class="active"';} ?>><a href="admin.php"><?php echo get_text('Admin'); ?></a></li>
						<?php
					}
					if(logged_in() || isset($_SESSION['admin_id'])){
						?>
						<li><a href="logout.php"><?php echo get_text('Logout'); ?></a></li>
						<?php
					}
				?>
			</ul>
		</nav>
	</header>
	<div class="mainContent">