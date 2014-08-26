<?php 
	$selected_page = 'Departments';
	require_once('includes/header.php');
	if(!isset($_SESSION['admin_id'])){
		header('Location:admin_login.php');
	}
?>

<div class="topContent">
	Hier worden alle departementen opgelijst, met de mogelijkheid om de te verwijderen en te bewerken (naam en manager).
	Als je op de naam van een departement klikt, krijg je een overzicht van alle gebruikers die in dat departement zitten.
	Als je in users.php op het departement van een gebruiker klikt, wordt deze doorverwezen naar departments.php met een bepaalde department_id
</div>

<?php require_once('includes/footer.php'); ?>