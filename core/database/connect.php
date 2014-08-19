<?php
	$connect_error = 'Er is een probleem opgetreden bij het verbinden met de databank. Onze excuses voor het ongemak.';
	mysql_connect('localhost', 'root', '') or die($connect_error);
	/* consider using minimal privileges for app : */
	/* dba user = root (all privs on all dbs) */
	/* admin user = create drop constraint ... */
	/* app user = insert update delete select (this one we need in the php ) */
	mysql_select_db('threesixtyweb') or die($connect_error);
?>