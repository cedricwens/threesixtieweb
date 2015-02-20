<?php
$connect_error = 'Sorry, we\'re experiencing connection problems with the database.';
/* mysql_connect('localhost', 'root', '') or die($connect_error); */
mysql_connect('127.0.0.1', 'threesixtyweb', 'threesixtywebapp') or die($connect_error);
/* consider using minimal privileges for app : */
/* dba user = root (all privs on all dbs) */
/* admin user = create drop constraint ... */
/* app user = insert update delete select (this one we need in the php ) */
mysql_select_db('threesixtyweb') or die($connect_error);
?>