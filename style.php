<?php
	require('core/init.php');
    header("Content-type: text/css; charset: UTF-8");
?>

body{
	background-image: url('img/bg.png');
	color: #000305;
	font-size: 87.5%;
	font-family: Arial, 'Lucida Sans Unicode';
	line-height: 1.5;
	text-align: left;
}
textarea{
	font-family: Arial, 'Lucida Sans Unicode';
}
h1,h2,h3{
	color: #009EE3;
}
a{
	text-decoration: none;
}
a:link, a:visited{
	color: #009EE3;
}
a:hover, a:active{
	color: #005FAB;
}
#menu{
	opacity: 0.93;
}
#menu ul{
	background-color: #666666;
	overflow: hidden;
	color: white;
	padding: 0;
	text-align: center;
	margin: 0;
	-webkit-transition: max-height 0.4s;
	-ms-transition: max-height 0.4s;
	-moz-transition: max-height 0.4s;
	-o-transition: max-height 0.4s;
	transition: max-height 0.4s;
}
#menu ul li{
	background-color: #666666;
	transition: background-color .25s ease-in-out;
  	-moz-transition: background-color .25s ease-in-out;
   	-webkit-transition: background-color .25s ease-in-out;
}
#menu ul li:hover{
	background-color: #009EE3;
}

.body{
	margin: 0 auto;
	width: 70%;
	clear: both;
}
.back{		
	display: inline;		
	margin-right: 25px;		
}		
.next{		
	display: inline;		
}
.mainHeader img{
	width: 30%;
	max-width: 350px;
	height: auto;
	max-height: 90px;
	margin: 2% 0;
}
/*.mainHeader nav{
	background-color: #666;
	height: 40px;
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
}
.mainHeader nav ul{
	list-style: none;
	margin: 0 auto;
}
.mainHeader nav ul li{
	float: left;
	display: inline;
}
.mainHeader nav a:link,
.mainHeader nav a:visited{
	color: #FFF;
	display: inline-block;
	padding: 10px 25px;
	height: 20px;
}
.mainHeader nav a:hover,
.mainHeader nav a:active,
.mainHeader nav .active a:link,
.mainHeader nav .active a:visited{
	background-color: #009EE3;
	text-shadow: none;
}
.mainHeader nav ul li a{
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
}*/


.mainContent{
	line-height: 25px;
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
}
.content{
	width: 70%;
	float: left;
}
.sidebarContent{
	display: none;
	background-color: #FFF;
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	padding: 3% 5%;
	margin-top: 2%;
}
.topContent{
	background-color: #FFF;
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	padding: 3% 5%;
	margin-top: 2%;
}
.middleContent{
	background-color: #FFF;
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	padding: 3% 5%;
	margin-top: 2%;
}
.bottomContent{
	background-color: #FFF;
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	padding: 3% 5%;
	margin-top: 2%;
}
.centerContent{
	background-color: #FFF;
	width: 200px;
	text-align: center;
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	padding: 3% 5%;
	margin: 0 auto;
	margin-top: 2%;
	box-shadow: 5px 5px 5px #888888;
}
.topSidebar{
	width: 21%;
	float: left;
	background-color: #FFF;
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	margin: 1.5% 0 0% 3%;
	padding: 2% 3%;
}
.middleSidebar{
	width: 21%;
	float: left;
	background-color: #FFF;
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	margin: 1.5% 0 0% 3%;
	padding: 2% 3%;
	overflow: hidden;
}
.bottomSidebar{
	width: 21%;
	float: left;
	background-color: #FFF;
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	margin: 1.5% 0 0% 3%;
	padding: 2% 3%;
}
.mainFooter{
	width: 100%;
	height: 40px;
	float: left;
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	background-color: #666;
	margin: 2% 0;
}
.mainFooter p{
	width: 92%;
	margin: 10px auto;
	color: #FFF;
	text-align: center;
}
.activeStep{
	font-weight: bold;
}
.login input[type=text], .login input[type=password]{
	/* Size and position */
    padding: 8px 4px 8px 10px;
    margin-bottom: 15px;
 
    /* Styles */
    border: 1px solid #4e3043; /* Fallback */
    border: 1px solid rgba(78,48,67, 0.8);
    background: rgba(0,0,0,0.05);
    border-radius: 2px;
    box-shadow: 
        0 1px 0 rgba(255,255,255,0.2), 
        inset 0 1px 1px rgba(0,0,0,0.1);
    -webkit-transition: all 0.3s ease-out;
    -moz-transition: all 0.3s ease-out;
    -ms-transition: all 0.3s ease-out;
    -o-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;
 
    /* Font styles */
    font-family: 'Raleway', 'Lato', Arial, sans-serif;
    color: black;
    font-size: 13px;
}

.comment{
	border: 1px solid gray;
	padding: 10px;
	margin:10px;
}
.questions tr td:first-child{
	width: 45%;
}
.spacer{
	height:  50px;
}
textarea.comment{
	resize: none;
	width: 95%;
	height: 150px;
}
#batches{
	border-collapse: collapse;
	width: 100%;
}
td#batches, th#batches{
	border: 1px solid #bbbbbb;
	padding: 5px;
}
.users{
	width: 100%;
	text-align: center;
}
.users input[type="text"]{
	text-align: center;
}
.users form:nth-child(odd){
	background-color: #e8f2f7;
	/*background-color: #bbbbbb;*/
}
.users table{
	width: 100%;
	border-collapse: collapse;
}
.users table tr th{
	border-bottom: 2px solid #e8f2f7;
	/*border-bottom: 2px solid #bbbbbb;*/
}
.users table tr:nth-child(even){
	background-color: gray;
}
.users td{
	text-align: center;
}
.questions_list table tr td{
	width: 100%;
}
.handle{
	width: 100%;
	background: #009EE3;
	text-align: left;
	box-sizing: border-box;
	padding: 15px 10px;
	cursor: pointer;
	color: white;
	display: none;
}
@media screen and (min-width: 675px){
	#menu ul li{
		display: inline-block;
		text-align: center;
	}
	#menu ul li a{
		padding: 20px;
		display: block;
		color: white;
	}
	.menu_fixed{
		position: fixed;
		top:0;
		display: block;
		width: 70%;
		opacity: 0.93;
		z-index: 9999999;
	}
	.users table tr th:not(:first-child), .users tr td:not(:first-child){
		width: 19%;
	}
	.users table tr th:first-child, .users tr td:first-child{
		width: 5%;
	}
}
@media only screen and (min-width: 150px) and (max-width: 950px){
	.body{
		width: 90%;
		font-size: 95%;
	}
	.mainHeader img{
		width: 100%;
	}
	.mainHeader nav{
		height: 150px;
	}
	.mainHeader nav ul{
		padding-left: 0;
	}
	.mainHeader nav ul li{
		width: 100%;
		text-align: center;
	}
	.mainHeader nav a:link,
	.mainHeader nav a:visited{
		padding: 10px 25px;
		height: 20px;
		display: block;
	}
	#mainHeader nav{
		height: 160px;
	}
	.content{
		width: 100%;
	}
	.topSidebar, .middleSidebar, .bottomSidebar{
		width: 94%;
		margin: 2% 0 2% 0;
		padding: 2% 3%;
	}
}
@media only screen and (max-width: 950px){
	.sidebarContent{
		display: block;
	}
	.step{
		display: none;
	}
	.content{
		width: 100%;
	}
	.topSidebar, .middleSidebar, .bottomSidebar{
		width: 94%;
		margin: 2% 0 2% 0;
		padding: 2% 3%;
	}
	.menu_fixed{
		position: fixed;
		top:0;
		display: block;
		width: 90%;
		opacity: 0.93;
		z-index: 9999999;
	}
}
@media screen and (max-width: 675px){
	nav ul{
		max-height: 0;
	}
	.showing{
		max-height: 30em;
	}
	#menu ul li{
		border-sizing: border-box;
		display: inline-block;
		width: 100%;
		text-align: left;
	}
	#menu ul li a{
		padding: 20px;
		display: block;
		color: white;
	}
	.handle{
		display: block;
	}
	.icon:after{
		float:right;
		content: "";
		background: url('img/nav-icon.png') no-repeat;
		width: 30px;
		height: 30px;
		display: inline-block;
		right: 15px;
		top: 175px;
	}
}
/* 
Max width before this PARTICULAR table gets nasty
This query will take effect for any screen smaller than 760px
and also iPads specifically.
*/
@media only screen and (max-width: 675px), (min-device-width: 768px) and (max-device-width: 1024px)  {

	/* Force table to not be like tables anymore */
	table, thead, tbody, th, td, tr { 
		display: block; 
	}
	
	/* Hide table headers (but not display: none;, for accessibility) */
	thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	
	tr { border: 1px solid #ccc; }
	
	td{ 
		/* Behave  like a "row" */
		padding-left: 50%; 
	}
	td{
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
	}
	
	td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
	}
	
	/*
	Label the data
	*/
	#users td:nth-of-type(1):before { content: "<?php echo get_text('ID'); ?>"; }
	#users td:nth-of-type(2):before { content: "<?php echo get_text('Name'); ?>"; }
	#users td:nth-of-type(3):before { content: "<?php echo get_text('Firstname'); ?>"; }
	#users td:nth-of-type(4):before { content: "<?php echo get_text('Lastname'); ?>"; }
	#users td:nth-of-type(5):before { content: "<?php echo get_text('Email'); ?>"; }
	#users td:nth-of-type(6):before { content: "<?php echo get_text('Action'); ?>"; }

	#departments td:nth-of-type(1):before { content: "<?php echo get_text('ID'); ?>"; }
	#departments td:nth-of-type(2):before { content: "<?php echo get_text('Name'); ?>"; }
	#departments td:nth-of-type(3):before { content: "<?php echo get_text('Manager'); ?>"; }
	#departments td:nth-of-type(4):before { content: "<?php echo get_text('Action'); ?>"; }

	.departments table tr th, .users tr td{
		width: 50%;
	}
}