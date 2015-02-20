DELETE FROM user_department;
DELETE FROM user;
DELETE FROM department;

INSERT INTO department (Name) VALUES
  ('Department A'),
  ('Department B'),
  ('Management');

/* Admin toevoegen aan database */
INSERT INTO admin (Username, Password, Email) VALUES
  ('Admin', '$2y$10$hvyKNSAyFM6FzwqH4WyjqO9MkXxM0vRuQdUMrD5XadkQZf6FbAae2', 'johanh@dnsbelgium.be');

/* Users toevoegen aan database*/
INSERT INTO user (Firstname, Lastname, Username, Password, Email) VALUES
  ('CEO', 'Management', 'CEOM', '$2y$10$hvyKNSAyFM6FzwqH4WyjqO9MkXxM0vRuQdUMrD5XadkQZf6FbAae2', 'johanh@dnsbelgium.be'),
  ('CEO', 'Department A', 'CEOA', '$2y$10$hvyKNSAyFM6FzwqH4WyjqO9MkXxM0vRuQdUMrD5XadkQZf6FbAae2',
   'johanh@dnsbelgium.be'),
  ('CEO', 'Department B', 'CEOB', '$2y$10$hvyKNSAyFM6FzwqH4WyjqO9MkXxM0vRuQdUMrD5XadkQZf6FbAae2',
   'johanh@dnsbelgium.be'),
  ('Member 1', 'Department A', 'M1A', '$2y$10$hvyKNSAyFM6FzwqH4WyjqO9MkXxM0vRuQdUMrD5XadkQZf6FbAae2',
   'johanh@dnsbelgium.be'),
  ('Member 2', 'Department A', 'M2A', '$2y$10$hvyKNSAyFM6FzwqH4WyjqO9MkXxM0vRuQdUMrD5XadkQZf6FbAae2',
   'johanh@dnsbelgium.be'),
  ('Member 1', 'Department B', 'M1B', '$2y$10$hvyKNSAyFM6FzwqH4WyjqO9MkXxM0vRuQdUMrD5XadkQZf6FbAae2',
   'johanh@dnsbelgium.be'),
  ('Member 2', 'Department B', 'M2B', '$2y$10$hvyKNSAyFM6FzwqH4WyjqO9MkXxM0vRuQdUMrD5XadkQZf6FbAae2',
   'johanh@dnsbelgium.be'),
  ('Member 3', 'Department B', 'M3B', '$2y$10$hvyKNSAyFM6FzwqH4WyjqO9MkXxM0vRuQdUMrD5XadkQZf6FbAae2',
   'johanh@dnsbelgium.be');

INSERT INTO user_department (User, Department) VALUES
  ((SELECT ID
    FROM user
    WHERE Firstname = 'CEO' AND Lastname = 'Department A'), (SELECT ID
                                                             FROM department
                                                             WHERE Name = 'Management')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'CEO' AND Lastname = 'Department B'), (SELECT ID
                                                             FROM department
                                                             WHERE Name = 'Management')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'CEO' AND Lastname = 'Management'), (SELECT ID
                                                           FROM department
                                                           WHERE Name = 'Management')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Member 1' AND Lastname = 'Department A'), (SELECT ID
                                                                  FROM department
                                                                  WHERE Name = 'Department A')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Member 2' AND Lastname = 'Department A'), (SELECT ID
                                                                  FROM department
                                                                  WHERE Name = 'Department A')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Member 1' AND Lastname = 'Department B'), (SELECT ID
                                                                  FROM department
                                                                  WHERE Name = 'Department B')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Member 2' AND Lastname = 'Department B'), (SELECT ID
                                                                  FROM department
                                                                  WHERE Name = 'Department B')),
  ((SELECT ID
    FROM user
    WHERE Firstname = 'Member 3' AND Lastname = 'Department B'), (SELECT ID
                                                                  FROM department
                                                                  WHERE Name = 'Department B'));

UPDATE department
SET Manager = (SELECT ID
               FROM user
               WHERE Firstname = 'CEO' AND Lastname = 'Department A')
WHERE Name = 'Department A';
UPDATE department
SET Manager = (SELECT ID
               FROM user
               WHERE Firstname = 'CEO' AND Lastname = 'Department B')
WHERE Name = 'Department B';
UPDATE department
SET Manager = (SELECT ID
               FROM user
               WHERE Firstname = 'CEO' AND Lastname = 'Management')
WHERE Name = 'Management';