/* Database leeg maken*/
DELETE FROM answer;
DELETE FROM question;
DELETE FROM category;
DELETE FROM poll;
DELETE FROM user;
DELETE FROM department;
DELETE FROM poll_status;
DELETE FROM batch_status;


/* Database opvullen */

/* Categorien toevoegen aan database */
INSERT INTO category (Name) VALUES
	('Professionaliteit'),
	('Communicatie'),
	('Organisatie'),
	('Samenwerking'),
	('Andere');

/* Batch status toevoegen aan database */
INSERT INTO batch_status (Name, Description) VALUES
	('Init', 	'Deze batch is geinitialiseerd en kan gestart worden'),
	('Running1', 'Dit is een actieve batch in fase 1'),
	('Calculate', 'De polls van deze batch kunnen berekend worden'),
	('Running2', 'Dit is een actieve batch in fase 2'),
	('Published','De resultaten van deze batch zijn toegangkelijk voor de gebruikers'),
	('Finished','Deze batch is afgelopen');

/* Batch toevoegen aan database */
/*INSERT INTO batch (Init_date, Running1_date, Running2_date, Finished_date, Status) VALUES
	('2014-08-08 15:53:02', NULL, NULL, NULL, (SELECT ID FROM batch_status WHERE Name = 'Init')),
	('2014-08-07 15:53:02', NULL, NULL, NULL, (SELECT ID FROM batch_status WHERE Name = 'Init'));*/

/* Vragen toevoegen aan database */
INSERT INTO question (Category, Question, Batch) VALUES
	((SELECT ID FROM category WHERE Name = 'Professionaliteit'), 'Is enthousiast over zijn/haar vakgebied', 															(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init'))),
	((SELECT ID FROM category WHERE Name = 'Professionaliteit'), 'Straalt vertouwen uit over de kennis die hij/zij heeft in zijn/haar vakgebied',						(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init'))),
	((SELECT ID FROM category WHERE Name = 'Professionaliteit'), 'Is in staat begrijpbaar advies te geven over zijn/haar vakgebied', 									(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init'))),
	((SELECT ID FROM category WHERE Name = 'Professionaliteit'), 'Kent de core business van het bedrijf genoeg om de juiste prioriteiten te leggen in zijn/haar werk',	(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init'))),
	((SELECT ID FROM category WHERE Name = 'Professionaliteit'), 'Komt steeds op tijd voor meetings en afspraken', 														(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init'))),
	((SELECT ID FROM category WHERE Name = 'Professionaliteit'), 'Neemt initiatief als er acties vereist zijn en houdt zich aan deze verantwoordelijkheden', 			(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init'))),

	((SELECT ID FROM category WHERE Name = 'Communicatie'), 'Communiceert respectvol', 											(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init'))),
	((SELECT ID FROM category WHERE Name = 'Communicatie'), 'Is helder in zijn/haar briefings aan anderen', 					(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init'))),
	((SELECT ID FROM category WHERE Name = 'Communicatie'), 'Deelt informatie met anderen en houdt deze niet voor zich', 		(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init'))),
	((SELECT ID FROM category WHERE Name = 'Communicatie'), 'Is duidelijk in zijn/haar verbale communicatie', 					(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init'))),
	((SELECT ID FROM category WHERE Name = 'Communicatie'), 'Is duidelijk in zijn/haar schriftelijke communicatie', 			(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init'))),
	((SELECT ID FROM category WHERE Name = 'Communicatie'), 'Luistert goed en gebruik de informatie op een correcte manier', 	(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init'))),
	((SELECT ID FROM category WHERE Name = 'Communicatie'), 'Toont begrip voor anderen',										(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init'))),

	((SELECT ID FROM category WHERE Name = 'Organisatie'), 'Helpt graag medewerkers met problemen', 							(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init'))),
	((SELECT ID FROM category WHERE Name = 'Organisatie'), 'Stelt het belang van de organisatie voorop en toont toewijding', 	(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init'))),
	((SELECT ID FROM category WHERE Name = 'Organisatie'), 'Durft problemen binnen de organisatie aan te kaarten', 				(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init'))),
	((SELECT ID FROM category WHERE Name = 'Organisatie'), 'Handhaaft de afgesproken waarden en normen binnen de organisatie', 	(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init'))),
	((SELECT ID FROM category WHERE Name = 'Organisatie'), 'Draagt mee aan een goede werksfeer', 								(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init'))),

	((SELECT ID FROM category WHERE Name = 'Samenwerking'), 'Werkt graag in teamverband', 																				(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init'))),
	((SELECT ID FROM category WHERE Name = 'Samenwerking'), 'Durft beslissingen te nemen en hier de verantwoordelijkheid voor te dragen. Ook wanneer het misloopt.', 	(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init'))),
	((SELECT ID FROM category WHERE Name = 'Samenwerking'), 'Draagt op efficiente manier bij aan meetings', 															(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init'))),
	((SELECT ID FROM category WHERE Name = 'Samenwerking'), 'Draagt bij tot een goede samenwerking tussen departementen', 												(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init'))),
	((SELECT ID FROM category WHERE Name = 'Samenwerking'), 'Neemt een vragende houding aan, ipv eisend over te komen', 												(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init'))),

	((SELECT ID FROM category WHERE Name = 'Andere'), 'Is enthousiast in het uitvoeren van zijn/haar job', 	(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init'))),
	((SELECT ID FROM category WHERE Name = 'Andere'), 'Kan anderen goed motiveren', 						(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init'))),
	((SELECT ID FROM category WHERE Name = 'Andere'), 'Komt eerlijk en betrouwbaar over', 					(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init'))),
	((SELECT ID FROM category WHERE Name = 'Andere'), 'Toont makkelijk waardering voor anderen', 			(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init'))),
	((SELECT ID FROM category WHERE Name = 'Andere'), 'Is hulpvaardig', 									(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init'))),
	((SELECT ID FROM category WHERE Name = 'Andere'), 'Kan zaken makkelijk relativeren', 					(SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Init')));

/* Departmenten toevoegen aan database */
INSERT INTO department (Name) VALUES
	('Support/Communication'),
	('Operations'),
	('Development'),
	('Management'),
	('Finance/HR');

/* Admin toevoegen aan database */
INSERT INTO admin(Username, Password) VALUES
	('Admin', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO');

/* Users toevoegen aan database*/
INSERT INTO user (Firstname, Lastname, Password) VALUES
	('Johan',		'Heylen', 		'$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO'),
	('Loesje',		'Hermans', 		'$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO'),
	('Leander',		'Dierckx', 		'$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO'),
	('Kristof',		'Tuyteleers', 	'$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO'),
	('Kevin',		'Jacquemyn', 	'$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO'),
	('Kathleen',	'Buffels', 		'$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO'),
	('Karen',		'Van Rillaer', 	'$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO'),
	('Helga',		'Parijs', 		'$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO'),
	('Philip',		'Du Bois', 		'$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO'),	
	('Maarten',		'Bosteels', 	'$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO'),
	('Lut',			'Goedhuys', 	'$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO'),
	('Peter',		'Vergote', 		'$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO'),
	('David',		'Goelen', 		'$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO');

/* Username genereren */
UPDATE user SET Username = REPLACE(CONCAT_WS('.',Lastname, Firstname), ' ','');

/* Users koppelen aan departement */
INSERT INTO user_department (User, Department) VALUES
	((SELECT ID FROM user WHERE Firstname = 'Johan' 	AND Lastname = 'Heylen'), 		(SELECT ID FROM department WHERE Name = 'Development')),
	((SELECT ID FROM user WHERE Firstname = 'Loesje' 	AND Lastname = 'Hermans'),		(SELECT ID FROM department WHERE Name = 'Development')),
	((SELECT ID FROM user WHERE Firstname = 'Leander' 	AND Lastname = 'Dierckx'),		(SELECT ID FROM department WHERE Name = 'Operations')),
	((SELECT ID FROM user WHERE Firstname = 'Kristof' 	AND Lastname = 'Tuyteleers'),	(SELECT ID FROM department WHERE Name = 'Operations')),
	((SELECT ID FROM user WHERE Firstname = 'Kevin'		AND Lastname = 'Jacquemyn'),	(SELECT ID FROM department WHERE Name = 'Support/Communication')),
	((SELECT ID FROM user WHERE Firstname = 'Kathleen'	AND Lastname = 'Buffels'),		(SELECT ID FROM department WHERE Name = 'Support/Communication')),
	((SELECT ID FROM user WHERE Firstname = 'Karen' 	AND Lastname = 'Van Rillaer'),	(SELECT ID FROM department WHERE Name = 'Finance/HR')),
	((SELECT ID FROM user WHERE Firstname = 'Helga' 	AND Lastname = 'Parijs'),		(SELECT ID FROM department WHERE Name = 'Finance/HR')),
	((SELECT ID FROM user WHERE Firstname = 'Philip' 	AND Lastname = 'Du Bois'),		(SELECT ID FROM department WHERE Name = 'Management')),
	((SELECT ID FROM user WHERE Firstname = 'Maarten' 	AND Lastname = 'Bosteels'),		(SELECT ID FROM department WHERE Name = 'Management')),
	((SELECT ID FROM user WHERE Firstname = 'Lut'		AND Lastname = 'Goedhuys'),		(SELECT ID FROM department WHERE Name = 'Management')),
	((SELECT ID FROM user WHERE Firstname = 'Peter' 	AND Lastname = 'Vergote'),		(SELECT ID FROM department WHERE Name = 'Management')),
	((SELECT ID FROM user WHERE Firstname = 'David' 	AND Lastname = 'Goelen'),		(SELECT ID FROM department WHERE Name = 'Management'));

/* Managers toevoegen aan department*/
UPDATE department SET Manager = (SELECT ID FROM user WHERE Firstname = 'Lut' AND Lastname = 'Goedhuys') WHERE Name = 'Support/Communication';
UPDATE department SET Manager = (SELECT ID FROM user WHERE Firstname = 'David' AND Lastname = 'Goelen') WHERE Name = 'Operations';
UPDATE department SET Manager = (SELECT ID FROM user WHERE Firstname = 'Maarten' AND Lastname = 'Bosteels') WHERE Name = 'Development';
UPDATE department SET Manager = (SELECT ID FROM user WHERE Firstname = 'Philip' AND Lastname = 'Du Bois') WHERE Name = 'Management';
UPDATE department SET Manager = (SELECT ID FROM user WHERE Firstname = 'Peter' AND Lastname = 'Vergote') WHERE Name = 'Finance/HR';

/* Statussen toevoegen aan database*/
INSERT INTO poll_status (Name) VALUES 
	('Niet ingevuld'),
	('Opgeslagen'),
	('Ingestuurd');

/* Eigen polls toevoegen aan database */
/*INSERT INTO poll (Reviewer, Reviewee, Comment, Status, Time_Created, Last_Update, Batch) VALUES
	((SELECT ID FROM user WHERE Firstname = 'Johan'		AND Lastname='Heylen'), 	(SELECT ID FROM user WHERE Firstname = 'Johan'	 	AND Lastname='Heylen'),		NULL, (SELECT ID FROM poll_status WHERE Name = 'Niet ingevuld'), '2014-08-05 09:49:00', '2014-08-06 09:49:00', (SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Running1'))),
	((SELECT ID FROM user WHERE Firstname = 'Loesje'	AND Lastname='Hermans'), 	(SELECT ID FROM user WHERE Firstname = 'Loesje' 	AND Lastname='Hermans'),	NULL, (SELECT ID FROM poll_status WHERE Name = 'Niet ingevuld'), '2014-08-05 09:49:00', '2014-08-06 09:49:00', (SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Running1'))),
	((SELECT ID FROM user WHERE Firstname = 'Leander'	AND Lastname='Dierckx'), 	(SELECT ID FROM user WHERE Firstname = 'Leander' 	AND Lastname='Dierckx'),	NULL, (SELECT ID FROM poll_status WHERE Name = 'Niet ingevuld'), '2014-08-05 09:49:00', '2014-08-06 09:49:00', (SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Running1'))),
	((SELECT ID FROM user WHERE Firstname = 'Kristof'	AND Lastname='Tuyteleers'), (SELECT ID FROM user WHERE Firstname = 'Kristof' 	AND Lastname='Tuyteleers'), NULL, (SELECT ID FROM poll_status WHERE Name = 'Niet ingevuld'), '2014-08-05 09:49:00', '2014-08-06 09:49:00', (SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Running1'))),
	((SELECT ID FROM user WHERE Firstname = 'Kevin'		AND Lastname='Jacquemyn'), 	(SELECT ID FROM user WHERE Firstname = 'Kevin'	 	AND Lastname='Jacquemyn'),	NULL, (SELECT ID FROM poll_status WHERE Name = 'Niet ingevuld'), '2014-08-05 09:49:00', '2014-08-06 09:49:00', (SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Running1'))),
	((SELECT ID FROM user WHERE Firstname = 'Kathleen'	AND Lastname='Buffels'), 	(SELECT ID FROM user WHERE Firstname = 'Kathleen' 	AND Lastname='Buffels'),	NULL, (SELECT ID FROM poll_status WHERE Name = 'Niet ingevuld'), '2014-08-05 09:49:00', '2014-08-06 09:49:00', (SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Running1'))),
	((SELECT ID FROM user WHERE Firstname = 'Karen'		AND Lastname='Van Rillaer'),(SELECT ID FROM user WHERE Firstname = 'Karen'	 	AND Lastname='Van Rillaer'),NULL, (SELECT ID FROM poll_status WHERE Name = 'Niet ingevuld'), '2014-08-05 09:49:00', '2014-08-06 09:49:00', (SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Running1'))),
	((SELECT ID FROM user WHERE Firstname = 'Helga'		AND Lastname='Parijs'), 	(SELECT ID FROM user WHERE Firstname = 'Helga'	 	AND Lastname='Parijs'),		NULL, (SELECT ID FROM poll_status WHERE Name = 'Niet ingevuld'), '2014-08-05 09:49:00', '2014-08-06 09:49:00', (SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Running1'))),
	((SELECT ID FROM user WHERE Firstname = 'Philip'	AND Lastname='Du Bois'), 	(SELECT ID FROM user WHERE Firstname = 'Philip'	 	AND Lastname='Du Bois'),	NULL, (SELECT ID FROM poll_status WHERE Name = 'Niet ingevuld'), '2014-08-05 09:49:00', '2014-08-06 09:49:00', (SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Running1'))),
	((SELECT ID FROM user WHERE Firstname = 'Maarten'	AND Lastname='Bosteels'), 	(SELECT ID FROM user WHERE Firstname = 'Maarten'	AND Lastname='Bosteels'),	NULL, (SELECT ID FROM poll_status WHERE Name = 'Niet ingevuld'), '2014-08-05 09:49:00', '2014-08-06 09:49:00', (SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Running1'))),
	((SELECT ID FROM user WHERE Firstname = 'Lut'		AND Lastname='Goedhuys'), 	(SELECT ID FROM user WHERE Firstname = 'Lut'	 	AND Lastname='Goedhuys'),	NULL, (SELECT ID FROM poll_status WHERE Name = 'Niet ingevuld'), '2014-08-05 09:49:00', '2014-08-06 09:49:00', (SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Running1'))),
	((SELECT ID FROM user WHERE Firstname = 'Peter'		AND Lastname='Vergote'), 	(SELECT ID FROM user WHERE Firstname = 'Peter'	 	AND Lastname='Vergote'),	NULL, (SELECT ID FROM poll_status WHERE Name = 'Niet ingevuld'), '2014-08-05 09:49:00', '2014-08-06 09:49:00', (SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Running1'))),
	((SELECT ID FROM user WHERE Firstname = 'David'		AND Lastname='Goelen'), 	(SELECT ID FROM user WHERE Firstname = 'David'	 	AND Lastname='Goelen'),		NULL, (SELECT ID FROM poll_status WHERE Name = 'Niet ingevuld'), '2014-08-05 09:49:00', '2014-08-06 09:49:00', (SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Running1')));*/



/* Polls toevoegen aan database */
/*INSERT INTO poll (Reviewer, Reviewee, Comment, Status, Time_Created, Last_Update, Batch) VALUES
	((SELECT ID FROM user WHERE Firstname = 'Johan' 	AND Lastname='Heylen'), 	(SELECT ID FROM user WHERE Firstname = 'Leander' 	AND Lastname='Dierckx'), 	NULL, (SELECT ID FROM poll_status WHERE Name = 'Niet ingevuld'), '2014-08-04 11:30:32', '2014-08-05 11:30:32', (SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Running1'))),
	((SELECT ID FROM user WHERE Firstname = 'Peter' 	AND Lastname='Vergote'), 	(SELECT ID FROM user WHERE Firstname = 'Maarten' 	AND Lastname='Bosteels'), 	NULL, (SELECT ID FROM poll_status WHERE Name = 'Niet ingevuld'), '2014-08-04 11:44:40', '2014-08-05 11:44:40', (SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Running1'))),
	((SELECT ID FROM user WHERE Firstname = 'Helga' 	AND Lastname='Parijs'), 	(SELECT ID FROM user WHERE Firstname = 'Karen' 		AND Lastname='Van Rillaer'),NULL, (SELECT ID FROM poll_status WHERE Name = 'Niet ingevuld'), '2014-08-04 11:44:53', '2014-08-05 11:44:53', (SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Running1'))),
	((SELECT ID FROM user WHERE Firstname = 'Johan' 	AND Lastname='Heylen'), 	(SELECT ID FROM user WHERE Firstname = 'Lut' 		AND Lastname='Goedhuys'), 	NULL, (SELECT ID FROM poll_status WHERE Name = 'Niet ingevuld'), '2014-08-04 13:06:30', '2014-08-05 13:06:30', (SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Running1'))),
	((SELECT ID FROM user WHERE Firstname = 'Johan' 	AND Lastname='Heylen'), 	(SELECT ID FROM user WHERE Firstname = 'Peter' 		AND Lastname='Vergote'), 	NULL, (SELECT ID FROM poll_status WHERE Name = 'Niet ingevuld'), '2014-08-04 13:31:39', '2014-08-05 13:31:39', (SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Running1'))),
	((SELECT ID FROM user WHERE Firstname = 'Karen' 	AND Lastname='Van Rillaer'),(SELECT ID FROM user WHERE Firstname = 'Johan' 		AND Lastname='Heylen'), 	NULL, (SELECT ID FROM poll_status WHERE Name = 'Niet ingevuld'), '2014-08-04 15:55:09', '2014-08-05 15:55:09', (SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Running1'))),
	((SELECT ID FROM user WHERE Firstname = 'Kathleen' 	AND Lastname='Buffels'), 	(SELECT ID FROM user WHERE Firstname = 'Johan' 		AND Lastname='Heylen'), 	NULL, (SELECT ID FROM poll_status WHERE Name = 'Niet ingevuld'), '2014-08-04 15:55:31', '2014-08-05 15:55:31', (SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Running1'))),
	((SELECT ID FROM user WHERE Firstname = 'David' 	AND Lastname='Goelen'), 	(SELECT ID FROM user WHERE Firstname = 'Johan' 		AND Lastname='Heylen'), 	NULL, (SELECT ID FROM poll_status WHERE Name = 'Niet ingevuld'), '2014-08-04 15:55:45', '2014-08-05 15:55:45', (SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Running1'))),
	((SELECT ID FROM user WHERE Firstname = 'Loesje' 	AND Lastname='Hermans'), 	(SELECT ID FROM user WHERE Firstname = 'Johan' 		AND Lastname='Heylen'), 	NULL, (SELECT ID FROM poll_status WHERE Name = 'Niet ingevuld'), '2014-08-04 15:55:53', '2014-08-05 15:55:53', (SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Running1'))),
	((SELECT ID FROM user WHERE Firstname = 'Helga' 	AND Lastname='Parijs'), 	(SELECT ID FROM user WHERE Firstname = 'Johan' 		AND Lastname='Heylen'), 	NULL, (SELECT ID FROM poll_status WHERE Name = 'Niet ingevuld'), '2014-08-04 15:56:03', '2014-08-05 15:56:03', (SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Running1'))),
	((SELECT ID FROM user WHERE Firstname = 'Maarten' 	AND Lastname='Bosteels'), 	(SELECT ID FROM user WHERE Firstname = 'Johan' 		AND Lastname='Heylen'), 	NULL, (SELECT ID FROM poll_status WHERE Name = 'Niet ingevuld'), '2014-08-04 16:25:17', '2014-08-05 16:25:17', (SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Running1'))),
	((SELECT ID FROM user WHERE Firstname = 'Peter' 	AND Lastname='Vergote'), 	(SELECT ID FROM user WHERE Firstname = 'Johan' 		AND Lastname='Heylen'), 	NULL, (SELECT ID FROM poll_status WHERE Name = 'Niet ingevuld'), '2014-08-04 16:39:56', '2014-08-05 16:39:56', (SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Running1'))),
	((SELECT ID FROM user WHERE Firstname = 'Philip'	AND Lastname='Du Bois'), 	(SELECT ID FROM user WHERE Firstname = 'Maarten' 	AND Lastname='Bosteels'),	NULL, (SELECT ID FROM poll_status WHERE Name = 'Niet ingevuld'), '2014-08-05 09:47:50', '2014-08-06 09:47:50', (SELECT ID FROM batch WHERE Status = (SELECT ID FROM batch_status WHERE Name = 'Running1')));*/
/* Parameters toevoegen aan database */
INSERT INTO parameter (Name, Value) VALUES
	('Aantal reviews geven', 5),
	('Aantal reviews krijgen', 5),
	('Maximum aantal reviews door (niet eigen) manager', 1),
	('Minimaal aantal reviews dat reviewer geeft aan gebruikers die hij heeft geselecteerd', 3),
	('Maximum aantal reviews uit eigen departement', 2),
	('Minimum aantal reviews dat reviewee krijgt van gebruikers die hij heeft geselecteerd', 2);

/* Antwoord mogelijkheden toevoegen aan database */
INSERT INTO answer_enum (Name, Description) VALUES
	('Heel Slecht', 'De gebruiker wordt zeer slecht beoordeeld op dit onderdeel'),
	('Slecht', 'De gebruiker wordt slecht beoordeeld op dit onderdeel'),
	('Neutraal', 'De gebruiker wordt neutraal beoordeeld op dit onderdeel'),
	('Goed', 'De gebruiker wordt goed beoordeeld op dit onderdeel'),
	('Zeer goed', 'De gebruiker wordt zeer goed beoordeeld op dit onderdeel'),
	('N.v.t', 'Dit onderdeel was niet van toepassing voor de gebruiker');