/* Nederlandse tekst toevoegen aan database */
DELETE FROM text_nl;

INSERT INTO text_nl (Name, Text) VALUES
	('Title', 		'ThreeSixtyWeb'),
	('ID', 			'ID'),
	('Username', 	'Gebruikersnaam'),
	('Password', 	'Wachtwoord'),
	('User', 		'Gebruiker'),
	('Reviewer', 	'Reviewer'),
	('Reviewee', 	'Reviewee'),
	('Poll', 		'Vragenlijst'),
	('Polls', 		'Vragenlijsten'),
	('Question', 	'Vraag'),
	('Questions', 	'Vragen'),
	('Answer', 		'Antwoord'),
	('Answers', 	'Antwoorden'),
	('Add_poll', 	'Vragenlijst toevoegen'),
	('Add_answer', 	'Antwoord toevoegen'),
	('Add_answers', 'Antwoorden toevoegen'),
	('Preferences', 'Voorkeuren'),
	('No_polls_found', 'Geen vragenlijsten gevonden'),
	('Choose_a', 	'Kies een'),
	('View', 		'Bekijk'),
	('About', 		'Over'),
	('This_person_may_answer_my_poll', 'Deze persoon mag mijn vragenlijst invullen'),
	('I_want_to_answer_poll_about_this_person', 'Ik wil de vragenlijst van deze persoon invullen'),
	('Time_Created', 'Aangemaakt op');