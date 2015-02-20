DELETE FROM user_department;
DELETE FROM user;
DELETE FROM department;

/* Departmenten toevoegen aan database */
INSERT INTO department (Name) VALUES
  ('Support/Communications'),
  ('Operations'),
  ('Development'),
  ('Management'),
  ('Finance/HR');

/* Admin toevoegen aan database */
INSERT INTO admin (Username, Password, Email) VALUES
  ('Admin', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO', 'johanh@dnsbelgium.be');

/* Users toevoegen aan database*/
INSERT INTO user (Firstname, Lastname, Username, Password, Email) VALUES
  ('Maarten', 'Bosteels', 'MaartenB', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO',
   'johanh@dnsbelgium.be'),
  ('Kathleen', 'Buffels', 'KathleenB', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO', 'johanh@dnsbelgium.be'),
  ('Dimitri', 'De Graef', 'DimitriDG', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO', 'johanh@dnsbelgium.be'),
  ('Leander', 'Dierckx', 'LeanderD', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO', 'johanh@dnsbelgium.be'),
  ('Kevin', 'Dillaerts', 'KevinD', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO', 'johanh@dnsbelgium.be'),
  ('Philip', 'Du Bois', 'PhilipDB', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO', 'johanh@dnsbelgium.be'),
  ('Ronald', 'Geens', 'RonaldG', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO', 'johanh@dnsbelgium.be'),
  ('Kurt', 'Gielen', 'KurtG', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO', 'johanh@dnsbelgium.be'),
  ('Lut', 'Goedhuys', 'LutG', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO', 'johanh@dnsbelgium.be'),
  ('David', 'Goelen', 'DavidG', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO', 'johanh@dnsbelgium.be'),
  ('Loesje', 'Hermans', 'LoesjeH', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO', 'johanh@dnsbelgium.be'),
  ('Johan', 'Heylen', 'JohanH', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO', 'johanh@dnsbelgium.be'),
  ('Kevin', 'Jacquemyn', 'KevinJ', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO', 'johanh@dnsbelgium.be'),
  ('Jasper', 'Kesteloot', 'JasperK', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO', 'johanh@dnsbelgium.be'),
  ('Kristof', 'Konings', 'KristofK', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO', 'johanh@dnsbelgium.be'),
  ('Bert', 'Maleszka', 'BertM', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO', 'johanh@dnsbelgium.be'),
  ('Stijn', 'Niclaes', 'StijnN', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO', 'johanh@dnsbelgium.be'),
  ('Helga', 'Parijs', 'HelgaP', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO', 'johanh@dnsbelgium.be'),
  ('Nico', 'Point', 'NicoP', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO', 'johanh@dnsbelgium.be'),
  ('Veerle', 'Tenier', 'VeerleT', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO', 'johanh@dnsbelgium.be'),
  ('Kristof', 'Tuyteleers', 'KristofT', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO', 'johanh@dnsbelgium.be'),
  ('Hilde', 'Van Bree', 'HildeVB', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO',
   'johanh@dnsbelgium.be'),
  ('Cecile', 'Van der Borght', 'CecileVDB', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO',
   'johanh@dnsbelgium.be'),
  ('Veronique', 'Van der Borght', 'VeroniqueVDB', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO',
   'johanh@dnsbelgium.be'),
  ('Sven', 'Van Dyck', 'SvenVD', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO',
   'johanh@dnsbelgium.be'),
  ('Karen', 'Van Rillaer', 'KarenVR', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO',
   'johanh@dnsbelgium.be'),
  ('Pieter', 'Vandepitte', 'PieterV', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO',
   'johanh@dnsbelgium.be'),
  ('Peter', 'Vergote', 'PeterV', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO',
   'johanh@dnsbelgium.be'),
  ('Koen', 'Zagers', 'KoenZ', '$2y$10$CQtvXZmXCjMBfC9LePexPeUOeX/ihEzClezWg/bCsFqwXbw0zKRKO', 'johanh@dnsbelgium.be');

/* Users koppelen aan departement */
INSERT INTO user_department (User, Department) VALUES
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Maarten' AND Lastname = 'Bosteels'), (SELECT ID
                                                             FROM department
                                                             WHERE Name = 'Management')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Kathleen' AND Lastname = 'Buffels'), (SELECT ID
                                                             FROM department
                                                             WHERE Name = 'Support/Communications')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Dimitri' AND Lastname = 'De Graef'), (SELECT ID
                                                             FROM department
                                                             WHERE Name = 'Operations')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Leander' AND Lastname = 'Dierckx'), (SELECT ID
                                                            FROM department
                                                            WHERE Name = 'Operations')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Kevin' AND Lastname = 'Dillaerts'), (SELECT ID
                                                            FROM department
                                                            WHERE Name = 'Support/Communications')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Philip' AND Lastname = 'Du Bois'), (SELECT ID
                                                           FROM department
                                                           WHERE Name = 'Management')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Ronald' AND Lastname = 'Geens'), (SELECT ID
                                                         FROM department
                                                         WHERE Name = 'Management')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Kurt' AND Lastname = 'Gielen'), (SELECT ID
                                                        FROM department
                                                        WHERE Name = 'Operations')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Lut' AND Lastname = 'Goedhuys'), (SELECT ID
                                                         FROM department
                                                         WHERE Name = 'Management')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'David' AND Lastname = 'Goelen'), (SELECT ID
                                                         FROM department
                                                         WHERE Name = 'Management')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Loesje' AND Lastname = 'Hermans'), (SELECT ID
                                                           FROM department
                                                           WHERE Name = 'Development')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Johan' AND Lastname = 'Heylen'), (SELECT ID
                                                         FROM department
                                                         WHERE Name = 'Development')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Kevin' AND Lastname = 'Jacquemyn'), (SELECT ID
                                                            FROM department
                                                            WHERE Name = 'Development')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Jasper' AND Lastname = 'Kesteloot'), (SELECT ID
                                                             FROM department
                                                             WHERE Name = 'Support/Communications')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Kristof' AND Lastname = 'Konings'), (SELECT ID
                                                            FROM department
                                                            WHERE Name = 'Development')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Bert' AND Lastname = 'Maleszka'), (SELECT ID
                                                          FROM department
                                                          WHERE Name = 'Development')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Stijn' AND Lastname = 'Niclaes'), (SELECT ID
                                                          FROM department
                                                          WHERE Name = 'Development')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Helga' AND Lastname = 'Parijs'), (SELECT ID
                                                         FROM department
                                                         WHERE Name = 'Finance/HR')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Nico' AND Lastname = 'Point'), (SELECT ID
                                                       FROM department
                                                       WHERE Name = 'Operations')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Veerle' AND Lastname = 'Tenier'), (SELECT ID
                                                          FROM department
                                                          WHERE Name = 'Operations')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Kristof' AND Lastname = 'Tuyteleers'), (SELECT ID
                                                               FROM department
                                                               WHERE Name = 'Operations')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Hilde' AND Lastname = 'Van Bree'), (SELECT ID
                                                           FROM department
                                                           WHERE Name = 'Support/Communications')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Cecile' AND Lastname = 'Van der Borght'), (SELECT ID
                                                                  FROM department
                                                                  WHERE Name = 'Support/Communications')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Veronique' AND Lastname = 'Van der Borght'), (SELECT ID
                                                                     FROM department
                                                                     WHERE Name = 'Support/Communications')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Sven' AND Lastname = 'Van Dyck'), (SELECT ID
                                                          FROM department
                                                          WHERE Name = 'Operations')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Karen' AND Lastname = 'Van Rillaer'), (SELECT ID
                                                              FROM department
                                                              WHERE Name = 'Finance/HR')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Pieter' AND Lastname = 'Vandepitte'), (SELECT ID
                                                              FROM department
                                                              WHERE Name = 'Development')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Peter' AND Lastname = 'Vergote'), (SELECT ID
                                                          FROM department
                                                          WHERE Name = 'Management')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Koen' AND Lastname = 'Zagers'), (SELECT ID
                                                        FROM department
                                                        WHERE Name = 'Operations'));

/* Managers toevoegen aan department*/
UPDATE department
SET Manager = (SELECT ID
               FROM user
               WHERE Firstname = 'Lut' AND Lastname = 'Goedhuys')
WHERE Name = 'Support/Communications';
UPDATE department
SET Manager = (SELECT ID
               FROM user
               WHERE Firstname = 'David' AND Lastname = 'Goelen')
WHERE Name = 'Operations';
UPDATE department
SET Manager = (SELECT ID
               FROM user
               WHERE Firstname = 'Maarten' AND Lastname = 'Bosteels')
WHERE Name = 'Development';
UPDATE department
SET Manager = (SELECT ID
               FROM user
               WHERE Firstname = 'Philip' AND Lastname = 'Du Bois')
WHERE Name = 'Management';
UPDATE department
SET Manager = (SELECT ID
               FROM user
               WHERE Firstname = 'Peter' AND Lastname = 'Vergote')
WHERE Name = 'Finance/HR';