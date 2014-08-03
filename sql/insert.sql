/* Database leeg maken*/
DELETE FROM answer;
DELETE FROM question;
DELETE FROM category;
DELETE FROM poll;
DELETE FROM user_department;
DELETE FROM department;
DELETE FROM user;

/* Database opvullen */

/* Categorien toevoegen aan database */
INSERT INTO category (Name) VALUES
	('Professionaliteit'),
	('Communicatie'),
	('Organisatie'),
	('Samenwerking'),
	('Andere');

/* Vragen toevoegen aan database */
INSERT INTO question (CategoryID, Question) VALUES
	('1', 'Is enthousiast over zijn/haar vakgebied'),
	('1', 'Straalt vertouwen uit over de kennis die hij/zij heeft in zijn/haar vakgebied'),
	('1', 'Is in staat begrijpbaar advies te geven over zijn/haar vakgebied'),
	('1', 'Kent de core business van het bedrijf genoeg om de juiste prioriteiten te leggen in zijn/haar werk'),
	('1', 'Komt steeds op tijd voor meetings en afspraken'),
	('1', 'Neemt initiatief als er acties vereist zijn en houdt zich aan deze verantwoordelijkheden'),

	('2', 'Communiceert respectvol'),
	('2', 'Is helder in zijn/haar briefings aan anderen'),
	('2', 'Deelt informatie met anderen en houdt deze niet voor zich'),
	('2', 'Is duidelijk in zijn/haar verbale communicatie'),
	('2', 'Is duidelijk in zijn/haar schriftelijke communicatie'),
	('2', 'Luistert goed en gebruik de informatie op een correcte manier'),
	('2', 'Toont begrip voor anderen'),

	('3', 'Helpt graag medewerkers met problemen'),
	('3', 'Stelt het belang van de organisatie voorop en toont toewijding'),
	('3', 'Durft problemen binnen de organisatie aan te kaarten'),
	('3', 'Handhaaft de afgesproken waarden en normen binnen de organisatie'),
	('3', 'Draagt mee aan een goede werksfeer'),

	('4', 'Werkt graag in teamverband'),
	('4', 'Durft beslissingen te nemen en hier de verantwoordelijkheid voor te dragen. Ook wanneer het misloopt.'),
	('4', 'Draagt op efficiënte manier bij aan meetings'),
	('4', 'Draagt bij tot een goede samenwerking tussen departementen'),
	('4', 'Neemt een vragende houding aan, ipv eisend over te komen'),

	('5', 'Is enthousiast in het uitvoeren van zijn/haar job'),
	('5', 'Kan anderen goed motiveren'),
	('5', 'Komt eerlijk en betrouwbaar over'),
	('5', 'Toont makkelijk waardering voor anderen'),
	('5', 'Is hulpvaardig'),
	('5', 'Kan zaken makkelijk relativeren');

/* Users toevoegen aan databank*/
INSERT INTO user (Name) VALUES
	('Johanh'),
	('Leander'),
	('Kristof'),
	('Kevin'),
	('Karen'),
	('Philipdb'),
	('Maarten');

/* Departmenten toevoegen aan database */
INSERT INTO department (Name, Manager) VALUES
	('Support', 		NULL),
	('Operations', 		(SELECT ID FROM user WHERE Name = 'Leander')),
	('Development',		(SELECT ID FROM user WHERE Name = 'Johanh')),
	('Management', 		(SELECT ID FROM user WHERE Name = 'Philipdb')),
	('Communication', 	(SELECT ID FROM user WHERE Name = 'Kevin')), 
	('Finance', 		(SELECT ID FROM user WHERE Name = 'Karen')),
	('HumanResources', 	NULL);


/* Users koppelen aan department */
INSERT INTO user_department (UserID, DepartmentID) VALUES
	((SELECT ID FROM user WHERE Name = 'Johanh'),	(SELECT ID FROM department WHERE Name = 'Development')),
	((SELECT ID FROM user WHERE Name = 'Leander'),	(SELECT ID FROM department WHERE Name = 'Operations')),
	((SELECT ID FROM user WHERE Name = 'Kristof'),	(SELECT ID FROM department WHERE Name = 'Operations')),
	((SELECT ID FROM user WHERE Name = 'Kevin'),	(SELECT ID FROM department WHERE Name = 'Communication')),
	((SELECT ID FROM user WHERE Name = 'Karen'),	(SELECT ID FROM department WHERE Name = 'Finance')),
	((SELECT ID FROM user WHERE Name = 'Philipdb'),	(SELECT ID FROM department WHERE Name = 'Management')),
	((SELECT ID FROM user WHERE Name = 'Maarten'),	(SELECT ID FROM department WHERE Name = 'Management'));