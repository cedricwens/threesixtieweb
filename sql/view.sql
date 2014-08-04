CREATE OR REPLACE VIEW gemiddelde_score AS
SELECT AVG(Answer)
FROM answer
WHERE Poll = 1;

CREATE OR REPLACE VIEW user_view AS
SELECT *
FROM user u
WHERE u.department = 1;

CREATE OR REPLACE VIEW manager_view AS
SELECT u.*
FROM user u, department d
WHERE d.ID = 1 and d.Manager = u.ID;

SELECT count(*) AS teammember
FROM user_view u
UNION
SELECT count(*) AS manager
FROM manager_view;
/*SELECT
	(SELECT count(*) FROM user_view) AS teammember,
	(SELECT count(*) FROM manager_view) AS manager
FROM dual;*/

SELECT reviewer FROM poll WHERE reviewee = 1;