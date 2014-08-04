/* Database leeg maken*/
DELETE FROM answer;
DELETE FROM question;
DELETE FROM category;
DELETE FROM poll;
DELETE FROM user;
DELETE FROM department;


/* Database opvullen */

/* Categorien toevoegen aan database */
INSERT INTO category (Name) VALUES
	('Professionaliteit'),
	('Communicatie'),
	('Organisatie'),
	('Samenwerking'),
	('Andere');

/* Vragen toevoegen aan database */
INSERT INTO question (Category, Question) VALUES
	((SELECT ID FROM category WHERE Name = 'Professionaliteit'), 'Is enthousiast over zijn/haar vakgebied'),
	((SELECT ID FROM category WHERE Name = 'Professionaliteit'), 'Straalt vertouwen uit over de kennis die hij/zij heeft in zijn/haar vakgebied'),
	((SELECT ID FROM category WHERE Name = 'Professionaliteit'), 'Is in staat begrijpbaar advies te geven over zijn/haar vakgebied'),
	((SELECT ID FROM category WHERE Name = 'Professionaliteit'), 'Kent de core business van het bedrijf genoeg om de juiste prioriteiten te leggen in zijn/haar werk'),
	((SELECT ID FROM category WHERE Name = 'Professionaliteit'), 'Komt steeds op tijd voor meetings en afspraken'),
	((SELECT ID FROM category WHERE Name = 'Professionaliteit'), 'Neemt initiatief als er acties vereist zijn en houdt zich aan deze verantwoordelijkheden'),

	((SELECT ID FROM category WHERE Name = 'Communicatie'), 'Communiceert respectvol'),
	((SELECT ID FROM category WHERE Name = 'Communicatie'), 'Is helder in zijn/haar briefings aan anderen'),
	((SELECT ID FROM category WHERE Name = 'Communicatie'), 'Deelt informatie met anderen en houdt deze niet voor zich'),
	((SELECT ID FROM category WHERE Name = 'Communicatie'), 'Is duidelijk in zijn/haar verbale communicatie'),
	((SELECT ID FROM category WHERE Name = 'Communicatie'), 'Is duidelijk in zijn/haar schriftelijke communicatie'),
	((SELECT ID FROM category WHERE Name = 'Communicatie'), 'Luistert goed en gebruik de informatie op een correcte manier'),
	((SELECT ID FROM category WHERE Name = 'Communicatie'), 'Toont begrip voor anderen'),

	((SELECT ID FROM category WHERE Name = 'Organisatie'), 'Helpt graag medewerkers met problemen'),
	((SELECT ID FROM category WHERE Name = 'Organisatie'), 'Stelt het belang van de organisatie voorop en toont toewijding'),
	((SELECT ID FROM category WHERE Name = 'Organisatie'), 'Durft problemen binnen de organisatie aan te kaarten'),
	((SELECT ID FROM category WHERE Name = 'Organisatie'), 'Handhaaft de afgesproken waarden en normen binnen de organisatie'),
	((SELECT ID FROM category WHERE Name = 'Organisatie'), 'Draagt mee aan een goede werksfeer'),

	((SELECT ID FROM category WHERE Name = 'Samenwerking'), 'Werkt graag in teamverband'),
	((SELECT ID FROM category WHERE Name = 'Samenwerking'), 'Durft beslissingen te nemen en hier de verantwoordelijkheid voor te dragen. Ook wanneer het misloopt.'),
	((SELECT ID FROM category WHERE Name = 'Samenwerking'), 'Draagt op efficiënte manier bij aan meetings'),
	((SELECT ID FROM category WHERE Name = 'Samenwerking'), 'Draagt bij tot een goede samenwerking tussen departementen'),
	((SELECT ID FROM category WHERE Name = 'Samenwerking'), 'Neemt een vragende houding aan, ipv eisend over te komen'),

	((SELECT ID FROM category WHERE Name = 'Andere'), 'Is enthousiast in het uitvoeren van zijn/haar job'),
	((SELECT ID FROM category WHERE Name = 'Andere'), 'Kan anderen goed motiveren'),
	((SELECT ID FROM category WHERE Name = 'Andere'), 'Komt eerlijk en betrouwbaar over'),
	((SELECT ID FROM category WHERE Name = 'Andere'), 'Toont makkelijk waardering voor anderen'),
	((SELECT ID FROM category WHERE Name = 'Andere'), 'Is hulpvaardig'),
	((SELECT ID FROM category WHERE Name = 'Andere'), 'Kan zaken makkelijk relativeren');

/* Departmenten toevoegen aan database */
INSERT INTO department (Name) VALUES
	('Support/Communication'),
	('Operations'),
	('Development'),
	('Management'),
	('Finance/HR');

/* Users toevoegen aan databank*/
INSERT INTO user (Name, Department) VALUES
	('Johanh',	(SELECT ID FROM department WHERE Name = 'Development')),
	('Loesje',	(SELECT ID FROM department WHERE Name = 'Development')),
	('Leander',	(SELECT ID FROM department WHERE Name = 'Operations')),
	('Kristof',	(SELECT ID FROM department WHERE Name = 'Operations')),
	('Kevin',	(SELECT ID FROM department WHERE Name = 'Support/Communication')),
	('Kathleen',(SELECT ID FROM department WHERE Name = 'Support/Communication')),
	('Karen',	(SELECT ID FROM department WHERE Name = 'Finance/HR')),
	('Helga',	(SELECT ID FROM department WHERE Name = 'Finance/HR')),
	('Philipdb',(SELECT ID FROM department WHERE Name = 'Management')),
	('Maarten',	(SELECT ID FROM department WHERE Name = 'Management')),
	('Lut',		(SELECT ID FROM department WHERE Name = 'Management')),
	('Peter',	(SELECT ID FROM department WHERE Name = 'Management')),
	('Dave',	(SELECT ID FROM department WHERE Name = 'Management'));

/* Managers toevoegen aan department*/
UPDATE department SET Manager = (SELECT ID FROM user WHERE Name = 'Lut') WHERE Name = 'Support/Communication';
UPDATE department SET Manager = (SELECT ID FROM user WHERE Name = 'Dave') WHERE Name = 'Operations';
UPDATE department SET Manager = (SELECT ID FROM user WHERE Name = 'Maarten') WHERE Name = 'Development';
UPDATE department SET Manager = (SELECT ID FROM user WHERE Name = 'Philipdb') WHERE Name = 'Management';
UPDATE department SET Manager = (SELECT ID FROM user WHERE Name = 'Peter') WHERE Name = 'Finance/HR';