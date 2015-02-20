USE threesixtyweb;
SELECT count(1)
FROM (SELECT
        ID,
        Reviewee,
        Score
      FROM candidate_poll
      WHERE Ok_reviewee = 1 AND Reviewer = 1
      ORDER BY Score DESC
      LIMIT 5) AS A
UNION ALL
SELECT count(1)
FROM (SELECT
        ID,
        Reviewee,
        Score
      FROM candidate_poll
      WHERE Ok_reviewee = 1 AND Reviewer = 2
      ORDER BY Score DESC
      LIMIT 5) AS B
UNION ALL
SELECT count(1)
FROM (SELECT
        ID,
        Reviewee,
        Score
      FROM candidate_poll
      WHERE Ok_reviewee = 1 AND Reviewer = 3
      ORDER BY Score DESC
      LIMIT 5) AS C
UNION ALL
SELECT count(1)
FROM (SELECT
        ID,
        Reviewee,
        Score
      FROM candidate_poll
      WHERE Ok_reviewee = 1 AND Reviewer = 4
      ORDER BY Score DESC
      LIMIT 5) AS D
UNION ALL
SELECT count(1)
FROM (SELECT
        ID,
        Reviewee,
        Score
      FROM candidate_poll
      WHERE Ok_reviewee = 1 AND Reviewer = 5
      ORDER BY Score DESC
      LIMIT 5) AS E
UNION ALL
SELECT count(1)
FROM (SELECT
        ID,
        Reviewee,
        Score
      FROM candidate_poll
      WHERE Ok_reviewee = 1 AND Reviewer = 6
      ORDER BY Score DESC
      LIMIT 5) AS F
UNION ALL
SELECT count(1)
FROM (SELECT
        ID,
        Reviewee,
        Score
      FROM candidate_poll
      WHERE Ok_reviewee = 1 AND Reviewer = 7
      ORDER BY Score DESC
      LIMIT 5) AS G
UNION ALL
SELECT count(1)
FROM (SELECT
        ID,
        Reviewee,
        Score
      FROM candidate_poll
      WHERE Ok_reviewee = 1 AND Reviewer = 8
      ORDER BY Score DESC
      LIMIT 5) AS H
UNION ALL
SELECT count(1)
FROM (SELECT
        ID,
        Reviewee,
        Score
      FROM candidate_poll
      WHERE Ok_reviewee = 1 AND Reviewer = 9
      ORDER BY Score DESC
      LIMIT 5) AS I
UNION ALL
SELECT count(1)
FROM (SELECT
        ID,
        Reviewee,
        Score
      FROM candidate_poll
      WHERE Ok_reviewee = 1 AND Reviewer = 10
      ORDER BY Score DESC
      LIMIT 5) AS J
UNION ALL
SELECT count(1)
FROM (SELECT
        ID,
        Reviewee,
        Score
      FROM candidate_poll
      WHERE Ok_reviewee = 1 AND Reviewer = 11
      ORDER BY Score DESC
      LIMIT 5) AS K
UNION ALL
SELECT count(1)
FROM (SELECT
        ID,
        Reviewee,
        Score
      FROM candidate_poll
      WHERE Ok_reviewee = 1 AND Reviewer = 12
      ORDER BY Score DESC
      LIMIT 5) AS L
UNION ALL
SELECT count(1)
FROM (SELECT
        ID,
        Reviewee,
        Score
      FROM candidate_poll
      WHERE Ok_reviewee = 1 AND Reviewer = 13
      ORDER BY Score DESC
      LIMIT 5) AS M