# Introduction #
De vragen die in dit document beschreven worden, zijn vragen die door de database beantwoord kunnen worden. Eerst zullen er enkel de vragen staan, maar systematisch zullen er ook queries toegevoegd worden.

# Details #
  * Wie heeft zijn/haar eigen vragenlijst nog niet ingevuld?
```
    SELECT *
    FROM user
    WHERE ID != ANY(
        SELECT Reviewer
        FROM poll
        WHERE Reviewee = Reviewer
    );
```
  * Wie heeft alle vragenlijsten ingevuld?
```
    SELECT *
    FROM user
    WHERE
        ID IN (
            SELECT Reviewer
            FROM poll
        )
        AND
        ID IN(
            SELECT Reviewer
            FROM poll
            WHERE Status = (
                SELECT ID 
                FROM Status 
                WHERE Name = 'Ingestuurd'
            )
    );
```
  * Wie heeft nog geen andere vragenlijsten ingevuld?
```
    SELECT *
    FROM user
    WHERE 
  	ID NOT IN(
    	    SELECT Reviewer
    	    FROM poll
    	    WHERE Reviewer != Reviewee
        )
        OR
        ID = ANY(
            SELECT Reviewer
            FROM poll
            WHERE Status = (
                SELECT ID
                FROM status
                WHERE Name = 'Niet ingevuld'
            )
        );
```
  * Wat is de gemiddelde score op 1 vraag van 1 gebruiker?
```
    SELECT p.Reviewee AS Reviewee, a.Question AS Question, AVG(a.Answer) AS Average_Score
    FROM answer a
    JOIN poll p
    ON a.Poll = p.ID
    GROUP BY QUESTION, REVIEWEE;
```
  * Wat is de gemiddelde score op 1 vraag van iedereen?
```
    SELECT a.Question AS Question, AVG(a.Answer) AS Average_Score
    FROM answer a
    JOIN poll p
    ON a.Poll = p.ID
    GROUP BY Question;
```
  * Door hoeveel teamleden wordt een gebruiker gereviewed?
```
    SELECT p.Reviewee, count(*) AS Aantal_Teamleden
    FROM poll p
    WHERE
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
```
  * Door hoeveel niet-teamleden wordt een gebruiker gereviewed?
```
    SELECT p.Reviewee, count(*) AS Aantal_NietTeamleden
    FROM poll p
    WHERE
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
```
  * Door hoeveel managers wordt een gebruiker gereviewed (eigen manager mag niet)?
```
    SELECT p.Reviewee, count(*) AS Aantal_NietTeamManagers
    FROM poll p
    WHERE
        p.Reviewee != p.Reviewer
        AND
        p.Reviewer = ANY (
    	    SELECT Manager
            FROM department
            WHERE ID != (
            	SELECT Department
           		FROM user
            	WHERE ID = p.Reviewee
            )
        )
    GROUP BY Reviewee;
```
  * Hoeveel reviews heeft een gebruiker gegeven (doorgestuurd)?
```
    SELECT Reviewer, count(*) AS Aantal_Reviews_Doorgestuurd
    FROM poll
    WHERE 
	Status = (
            SELECT ID 
            FROM Status
            WHERE Name = 'Ingestuurd'
        )
        AND
        Reviewer != Reviewee
    GROUP BY Reviewer;
```
  * Hoeveel reviews een een gebruiker gekregen (doorgestuurd)?
```
    SELECT Reviewee, count(*) AS Aantal_Reviews_Gekregen
    FROM poll
    WHERE 
	Status = (
            SELECT ID
            FROM Status
            WHERE Name = 'Ingestuurd'
        )
        AND
        Reviewer != Reviewee
    GROUP BY Reviewee;
```
  * Wie heeft alle reviews ingevuld (opgeslagen) maar nog niet doorgestuurd?
```
    SELECT *
    FROM user
    WHERE
        ID IN (
            SELECT Reviewer
            FROM poll
        )
        AND
        ID IN(
            SELECT Reviewer
            FROM poll
            WHERE Status = (
                SELECT ID 
                FROM Status 
                WHERE Name = 'Opgeslagen'
            )
    );
```
  * Hoeveel reviewees, die een reviewer heeft geselecteerd, mag hij/zij ook effectief reviewen?
```
    SELECT Reviewer, count(*) AS Aantal_Preferred_Reviewees
    FROM preferred_poll pf
    WHERE
        pf.Reviewee = ANY(SELECT Reviewee FROM poll WHERE Reviewer = pf.Reviewer)
        AND
    	pf.User = pf.Reviewer
    GROUP BY pf.Reviewer;
```
  * Hoeveel reviewers, die een reviewee heeft geselecteerd, reviewed deze reviewer ook effectief?
```
    SELECT User AS Reviewee, count(*) AS Aantal_Preferred_Reviewers
    FROM preferred_poll pf
    WHERE pf.Reviewer = ANY(SELECT Reviewer FROM poll WHERE Reviewee = pf.User)
    GROUP BY pf.Reviewee;
```

Extra:
  * Wat is de gemiddelde duur voor het invullen van een poll?
```
    SELECT AVG(TIMESTAMPDIFF(SECOND,Time_Created, Last_Update))
    FROM poll
    WHERE Status = (
        SELECT ID
        FROM status
        WHERE Name = 'Ingestuurd'
    );
```
  * Wat is het (minst) favoriete tijdstip voor het invullen van een poll?
> Hiervan vind ik de specifieke query nog niet direct. Dit is volgens mij ook moeilijk om te bepalen uit de database. Als we 'tijdstip' interpreteren als dag, moet men de dagen uit de database sorteren, en dan de datum die het minst voorkomt gebruiken. Maar als we 'tijdstip' gaan interpreteren als uur, dan moet de data gesorteerd worden en dan moet het uur tussen begin en eind datum, dat het minst voorkomt, geselecteerd worden.
  * Wie is de best/slechts beoordeelde gebruiker?
```
    CREATE VIEW Total_Average_Score AS
    SELECT p.Reviewee AS Reviewee, AVG(a.Answer) AS Average_Score
    FROM answer a
    JOIN poll p ON a.Poll = p.ID
    GROUP BY Reviewee;

    SELECT Reviewee, MAX(Average_Score)
    FROM Total_Average_Score;
```