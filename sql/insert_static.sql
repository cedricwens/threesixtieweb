/* Database leeg maken*/
DELETE FROM answer;
DELETE FROM question;
DELETE FROM category;
DELETE FROM poll;
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
  ('Init', 'Deze batch is geinitialiseerd en kan gestart worden'),
  ('Running1', 'Dit is een actieve batch in fase 1'),
  ('Calculate', 'De polls van deze batch kunnen berekend worden'),
  ('Accepted', 'De berekende polls zijn aanvaard'),
  ('Running2', 'Dit is een actieve batch in fase 2'),
  ('Published', 'De resultaten van deze batch zijn toegangkelijk voor de gebruikers'),
  ('Finished', 'Deze batch is afgelopen');

/* Vragen toevoegen aan database */
INSERT INTO question (Category, Question) VALUES
  ((SELECT ID
    FROM category
    WHERE Name = 'Professionaliteit'), 'Is enthousiast over zijn/haar vakgebied'),
  ((SELECT ID
    FROM category
    WHERE Name = 'Professionaliteit'), 'Straalt vertouwen uit over de kennis die hij/zij heeft in zijn/haar vakgebied'),
  ((SELECT ID
    FROM category
    WHERE Name = 'Professionaliteit'), 'Is in staat begrijpbaar advies te geven over zijn/haar vakgebied'),
  ((SELECT ID
    FROM category
    WHERE Name =
          'Professionaliteit'), 'Kent de core business van het bedrijf genoeg om de juiste prioriteiten te leggen in zijn/haar werk'),
  ((SELECT ID
    FROM category
    WHERE Name = 'Professionaliteit'), 'Komt steeds op tijd voor meetings en afspraken'),
  ((SELECT ID
    FROM category
    WHERE Name =
          'Professionaliteit'), 'Neemt initiatief als er acties vereist zijn en houdt zich aan deze verantwoordelijkheden'),

  ((SELECT ID
    FROM category
    WHERE Name = 'Communicatie'), 'Communiceert respectvol'),
  ((SELECT ID
    FROM category
    WHERE Name = 'Communicatie'), 'Is helder in zijn/haar briefings aan anderen'),
  ((SELECT ID
    FROM category
    WHERE Name = 'Communicatie'), 'Deelt informatie met anderen en houdt deze niet voor zich'),
  ((SELECT ID
    FROM category
    WHERE Name = 'Communicatie'), 'Is duidelijk in zijn/haar verbale communicatie'),
  ((SELECT ID
    FROM category
    WHERE Name = 'Communicatie'), 'Is duidelijk in zijn/haar schriftelijke communicatie'),
  ((SELECT ID
    FROM category
    WHERE Name = 'Communicatie'), 'Luistert goed en gebruikt de informatie op een correcte manier'),
  ((SELECT ID
    FROM category
    WHERE Name = 'Communicatie'), 'Toont begrip voor anderen'),
  ((SELECT ID
    FROM category
    WHERE Name = 'Organisatie'), 'Helpt graag medewerkers met problemen'),
  ((SELECT ID
    FROM category
    WHERE Name = 'Organisatie'), 'Stelt het belang van de organisatie voorop en toont toewijding'),
  ((SELECT ID
    FROM category
    WHERE Name = 'Organisatie'), 'Durft problemen binnen de organisatie aan te kaarten'),
  ((SELECT ID
    FROM category
    WHERE Name = 'Organisatie'), 'Handhaaft de afgesproken waarden en normen binnen de organisatie'),
  ((SELECT ID
    FROM category
    WHERE Name = 'Organisatie'), 'Draagt mee aan een goede werksfeer'),

  ((SELECT ID
    FROM category
    WHERE Name = 'Samenwerking'), 'Werkt graag in teamverband'),
  ((SELECT ID
    FROM category
    WHERE Name =
          'Samenwerking'), 'Durft beslissingen te nemen en hier de verantwoordelijkheid voor te dragen. Ook wanneer het misloopt.'),
  ((SELECT ID
    FROM category
    WHERE Name = 'Samenwerking'), 'Draagt op efficiente manier bij aan meetings'),
  ((SELECT ID
    FROM category
    WHERE Name = 'Samenwerking'), 'Draagt bij tot een goede samenwerking tussen departementen'),
  ((SELECT ID
    FROM category
    WHERE Name = 'Samenwerking'), 'Neemt een vragende houding aan, ipv eisend over te komen'),

  ((SELECT ID
    FROM category
    WHERE Name = 'Andere'), 'Is enthousiast in het uitvoeren van zijn/haar job'),
  ((SELECT ID
    FROM category
    WHERE Name = 'Andere'), 'Kan anderen goed motiveren'),
  ((SELECT ID
    FROM category
    WHERE Name = 'Andere'), 'Komt eerlijk en betrouwbaar over'),
  ((SELECT ID
    FROM category
    WHERE Name = 'Andere'), 'Toont makkelijk waardering voor anderen'),
  ((SELECT ID
    FROM category
    WHERE Name = 'Andere'), 'Is hulpvaardig'),
  ((SELECT ID
    FROM category
    WHERE Name = 'Andere'), 'Kan zaken makkelijk relativeren');

/* Statussen toevoegen aan database*/
INSERT INTO poll_status (Name) VALUES
  ('Niet ingevuld'),
  ('Opgeslagen'),
  ('Ingestuurd'),
  ('Commentaar');

/* Parameters toevoegen aan database */
/*gebruik hier ook een short-name kolom */
/* Hoe worden parameters door php opgehaald ? via ID of via beschrijving ? */
/* een ID (numeriek is weinig zeggend voor de lezer*/
/*short name column needs to be unique */
INSERT INTO parameter (Short_name, Name, Value) VALUES
  ('Reviews_to_give', 'Aantal reviews geven', 5),
  ('Reviews_to_receive', 'Aantal reviews krijgen', 5),
  ('Reviews_by_not_teammanager', 'Maximum aantal reviews door (niet eigen) manager', 1),
/*('Reviews_selected_reviewees', 'Minimaal aantal reviews dat reviewer geeft aan gebruikers die hij heeft geselecteerd', 3),
('Reviews_selected_reviewers', 'Minimaal aantal reviews dat reviewee krijgt van gebruikers die hij heeft geselecteerd', 2),*/
  ('Reviews_own_department', 'Maximum aantal reviews uit eigen departement', 2);

/* Antwoord mogelijkheden toevoegen aan database */
INSERT INTO answer_enum (Name, Description) VALUES
  ('Heel slecht', 'De gebruiker wordt zeer slecht beoordeeld op dit onderdeel'),
  ('Slecht', 'De gebruiker wordt slecht beoordeeld op dit onderdeel'),
  ('Neutraal', 'De gebruiker wordt neutraal beoordeeld op dit onderdeel'),
  ('Goed', 'De gebruiker wordt goed beoordeeld op dit onderdeel'),
  ('Zeer goed', 'De gebruiker wordt zeer goed beoordeeld op dit onderdeel'),
  ('N.v.t', 'Dit onderdeel was niet van toepassing voor de gebruiker');