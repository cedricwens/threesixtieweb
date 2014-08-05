CREATE OR REPLACE VIEW gemiddelde_score AS
SELECT AVG(Answer)
FROM answer
WHERE Poll = 1;

/*CREATE OR REPLACE VIEW user_view AS
SELECT *
FROM user u
WHERE u.department = 1;

CREATE OR REPLACE VIEW manager_view AS
SELECT u.*
FROM user u, department d
WHERE d.ID = 1 and d.Manager = u.ID;*/

/*SELECT count(*) AS teammember
FROM user_view u
UNION
SELECT count(*) AS manager
FROM manager_view;*/
/*SELECT
	(SELECT count(*) FROM user_view) AS teammember,
	(SELECT count(*) FROM manager_view) AS manager
FROM dual;*/

CREATE OR REPLACE VIEW teammember_view AS
SELECT count(*)
FROM user
WHERE ID IN (
	SELECT reviewer
	FROM poll
	WHERE
		reviewee = 1
		AND
		reviewer != 1
		AND
		reviewer NOT IN (
			SELECT Manager
			FROM department
		)
		AND
		reviewer IN (
			SELECT ID
			FROM user
			WHERE department = (
				SELECT department
				FROM user
				WHERE ID = 1)
		)
		/*AND
		reviewer IN (
			SELECT Manager
			FROM department
		)*/
);
CREATE OR REPLACE VIEW notteammember_view AS
SELECT count(*)
FROM user
WHERE ID IN (
	SELECT reviewer
	FROM poll
	WHERE
		reviewee = 1
		AND
		reviewer NOT IN (
			SELECT Manager
			FROM department
		)
		AND
		reviewer NOT IN (
			SELECT ID
			FROM user
			WHERE department = (SELECT department FROM user WHERE ID = 1)
		)
);

CREATE OR REPLACE VIEW teammanager_view AS
SELECT count(*)
FROM user
WHERE
	ID IN (
        SELECT reviewer
        FROM poll
        WHERE reviewee = 1
        AND
        reviewer IN (
            SELECT Manager
           	FROM department
            WHERE ID = 3
        )
	);

CREATE OR REPLACE VIEW notteammanager_view AS
SELECT count(*)
FROM user
WHERE
	ID IN (
        SELECT reviewer
        FROM poll
        WHERE reviewee = 1
        AND
        reviewer IN (
            SELECT Manager
           	FROM department
            WHERE ID != 3
        )
	);

CREATE OR REPLACE VIEW preferred_reviewers_view AS
SELECT count(*)
FROM user u
WHERE
	u.ID IN (
		SELECT reviewer
		FROM preferred_poll
		WHERE reviewee = 1
	);

CREATE OR REPLACE VIEW preferred_reviewees_view AS
SELECT count(*)
FROM user u
WHERE
	u.ID IN (
		SELECT reviewee
		FROM preferred_poll
		WHERE reviewer = 1
	);