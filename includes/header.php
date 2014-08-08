<?php
require('core/init.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>ThreeSixtyWeb</title>
	<link rel="stylesheet" type="text/css" href="main.css">
	<!-- consider adding a logo here /somewhere on the page
				dnsbelgium.png (please ask for the file)-->
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

</head>
<body>
	<div id="container">
	<div id="header_container">
		<header><h1><?php echo get_Text('Title'); ?></h1></header>
		<nav id="menu">
			<ul>
				<li><a href="home.php">Home</a></li>
				<?php
				if(isset($_SESSION['admin_id'])){
					?>
					 - <li><a href="user.php">User</a></li>
					 - <li><a href="admin.php">Admin</a></li>
					<?php
				}
				if(logged_in() || isset($_SESSION['admin_id'])){
					?>
					 - <li><a href="logout.php">Logout</a></li>
					<?php
				}
				?>
			</ul>
		</nav>
	</div>
	<div class="content_wrapper">