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
	<script>
	function change_batchstatus(batch, action){
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
	  		xmlhttp=new XMLHttpRequest();
	  	}
		else{// code for IE6, IE5
	  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  	}
		xmlhttp.onreadystatechange=function(){
	  		//if (xmlhttp.readyState==4 && xmlhttp.status==200){
	    		document.getElementById("batches").innerHTML=xmlhttp.responseText;
	   		//}
	  	}	
		xmlhttp.open("GET","change_batch_status.php?id="+batch+"&action="+action,true);
		xmlhttp.send();
	}
	</script>
</head>
<body class="body">
	<header class="mainHeader" <?php if(isset($_SESSION['admin_id'])){ echo 'id="mainHeader"';} ?>>
		<img src="img/logo.png" />
		<nav id="menu">
			<ul>
				<li <?php if($selected_page == 'Home'){ echo 'class="active"';} ?>><a href="index.php">Home</a></li>
				<?php
					if(isset($_SESSION['user_id'])){
						?>
						<li <?php if($selected_page == 'MyResults'){ echo 'class="active"';} ?>><a href="pdf.php?id=<?php echo $_SESSION['user_id']; ?>">My results</a></li>
						<?php
					}
					if(isset($_SESSION['admin_id'])){
						?>
						<li <?php if($selected_page == 'User'){ echo 'class="active"';} ?>><a href="user.php">User</a></li>
						<li <?php if($selected_page == 'Admin'){ echo 'class="active"';} ?>><a href="admin.php">Admin</a></li>
						<?php
					}
					if(logged_in() || isset($_SESSION['admin_id'])){
						?>
						<li><a href="logout.php">Logout</a></li>
						<?php
					}
				?>
			</ul>
		</nav>
	</header>
	<div class="mainContent">