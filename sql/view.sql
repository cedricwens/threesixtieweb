CREATE OR REPLACE VIEW average_score_view AS
SELECT p.Reviewee AS Reviewee, a.Question AS Question, AVG(a.Answer) AS Average_Score
FROM answer a
JOIN poll p
ON a.Poll = p.ID
GROUP BY QUESTION, REVIEWEE;

CREATE OR REPLACE VIEW reviews_given_view AS
SELECT p.Reviewer AS Reviewer, count(*) AS Aantal_Reviews
FROM poll p
WHERE
    p.Reviewer = ANY (
        SELECT ID
        FROM user
        )
    AND
        p.Status = 2
    AND
        p.Reviewer != p.Reviewee
GROUP BY p.Reviewer;

CREATE OR REPLACE VIEW reviews_received_view AS
SELECT p.Reviewee AS Reviewee, count(*) AS Aantal_Reviews
FROM poll p
WHERE
    p.Reviewee = ANY(
        SELECT ID
        FROM user
        )
    AND
        p.Reviewee != p.Reviewer
GROUP BY p.Reviewee;

CREATE OR REPLACE VIEW teammember_view AS
SELECT p.Reviewee, count(*) AS Aantal_Teamleden
FROM poll p
WHERE
	p.Reviewee = ANY (
        SELECT ID FROM user
    )
    AND
    p.Reviewee != p.Reviewer
    AND
    p.Reviewer NOT IN (
        SELECT Manager
        FROM department
        WHERE ID = (
            SELECT Department
            FROM user
            WHERE ID = p.Reviewee
        )
    )
    AND
    p.Reviewer = ANY (
        SELECT ID
        FROM user
        WHERE Department = (
            SELECT Department
            FROM user
            WHERE ID = p.Reviewee
        )
    )
GROUP BY Reviewee;   

CREATE OR REPLACE VIEW notteammember_view AS
SELECT p.Reviewee, count(*) AS Aantal_NietTeamleden
FROM poll p
WHERE
    p.Reviewee = ANY (
        SELECT ID FROM user
    )
    AND
    p.Reviewee != p.Reviewer
    AND
    p.Reviewer NOT IN (
        SELECT Manager
        FROM department
    )
    AND
    p.Reviewer NOT IN (
        SELECT ID
        FROM user
        WHERE Department = (
            SELECT Department
            FROM user
            WHERE ID = p.Reviewee
        )
    )
GROUP BY Reviewee;

CREATE OR REPLACE VIEW teammanager_view AS
SELECT p.Reviewee, count(*) AS Aantal_TeamManagers
FROM poll p
WHERE
	p.Reviewee = ANY (
        SELECT ID FROM user
    )
    AND
    p.Reviewee != p.Reviewer
    AND
    p.Reviewer = ANY (
    	SELECT Manager
        FROM department
        WHERE ID = (
            SELECT Department
            FROM user
            WHERE ID = p.Reviewee
        )
    )
GROUP BY Reviewee;

CREATE OR REPLACE VIEW notteammanager_view AS
SELECT p.Reviewee, count(*) AS Aantal_NietTeamManagers
FROM poll p
WHERE
	p.Reviewee = ANY (
        SELECT ID FROM user
    )
    AND
    p.Reviewee != p.Reviewer
    AND
    p.Reviewer = ANY (
    	SELECT Manager
        FROM department
        WHERE
        	ID != (
            	SELECT Department
           		FROM user
            	WHERE ID = p.Reviewee
        	)
    )
GROUP BY Reviewee;

CREATE OR REPLACE VIEW preferred_reviewers_view AS
SELECT User AS Reviewee, count(*) AS Aantal_Preferred_Reviewers
FROM preferred_poll pf
WHERE
	pf.User = ANY(
        SELECT ID FROM user
    )
    AND
        pf.Reviewer = ANY(SELECT Reviewer FROM poll WHERE Reviewee = pf.User)
GROUP BY pf.Reviewee;


CREATE OR REPLACE VIEW preferred_reviewees_view AS
SELECT Reviewer, count(*) AS Aantal_Preferred_Reviewees
FROM preferred_poll pf
WHERE
	pf.User = ANY(
        SELECT ID FROM user
    )
    AND
        pf.Reviewee = ANY(SELECT Reviewee FROM poll WHERE Reviewer = pf.Reviewer)
    AND
    	pf.User = pf.Reviewer
GROUP BY pf.Reviewer;