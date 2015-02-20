/* Creatie van Database en tabellen */
DROP DATABASE IF EXISTS threesixtyweb;
CREATE DATABASE threesixtyweb
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;
USE threesixtyweb;

CREATE TABLE user (
  ID        INT          NOT NULL AUTO_INCREMENT,
  Firstname VARCHAR(255) NOT NULL,
  Lastname  VARCHAR(255) NOT NULL,
  Username  VARCHAR(255),
  Password  VARCHAR(255) NOT NULL,
  Email     VARCHAR(255),
  Job_Title VARCHAR(255),
  PRIMARY KEY (ID)
);

CREATE TABLE department (
  ID      INT          NOT NULL AUTO_INCREMENT,
  Name    VARCHAR(255) NOT NULL,
  Manager INT,
/*consider - non mandatory -  moving the manager value to usertable this will mitigate the circular dependency in an initial state */
  PRIMARY KEY (ID)
);

CREATE TABLE user_department (
  ID         INT NOT NULL AUTO_INCREMENT,
  User       INT NOT NULL,
  Department INT NOT NULL,
  PRIMARY KEY (ID)
);

CREATE TABLE admin (
  ID       INT NOT NULL AUTO_INCREMENT,
  Username VARCHAR(255),
  Password VARCHAR(255),
  Email    VARCHAR(255),
  PRIMARY KEY (ID)
);

CREATE TABLE poll (
  ID           INT NOT NULL AUTO_INCREMENT,
  Reviewer     INT NOT NULL,
  Reviewee     INT NOT NULL,
  Comment      VARCHAR(255),
  Status       INT NOT NULL,
  Time_Created DATETIME,
  Last_Update  DATETIME,
  Batch        INT,
  PRIMARY KEY (ID)
);

CREATE TABLE category (
  ID   INT          NOT NULL AUTO_INCREMENT,
  Name VARCHAR(255) NOT NULL,
  PRIMARY KEY (ID)
);

CREATE TABLE question (
  ID       INT          NOT NULL AUTO_INCREMENT,
  Category INT          NOT NULL,
  Question VARCHAR(255) NOT NULL,
  Comment  VARCHAR(255),
/*Batch int NOT NULL, feature not fully developed*/
  PRIMARY KEY (ID)
/* future improvement - non mandatory - add a column referring to BATCH*/
);

CREATE TABLE answer (
  ID           INT NOT NULL AUTO_INCREMENT,
  Poll         INT NOT NULL,
  Question     INT NOT NULL,
  Answer       INT NOT NULL,
  Time_Created DATETIME,
  Last_Update  DATETIME,
  PRIMARY KEY (ID)
);

CREATE TABLE preferred_poll (
  ID       INT NOT NULL AUTO_INCREMENT,
  Reviewer INT NOT NULL,
  Reviewee INT NOT NULL,
  User     INT NOT NULL,
  Batch    INT NOT NULL,
  PRIMARY KEY (ID)
);

CREATE TABLE poll_status (
  ID   INT          NOT NULL AUTO_INCREMENT,
  Name VARCHAR(255) NOT NULL,
  PRIMARY KEY (ID)
);

CREATE TABLE parameter (
  ID         INT          NOT NULL AUTO_INCREMENT,
  Short_name VARCHAR(255) NOT NULL,
  Name       VARCHAR(255) NOT NULL,
  Value      INT          NOT NULL,
  Comment    VARCHAR(255),
  PRIMARY KEY (ID)
);

CREATE TABLE batch (
  ID            INT NOT NULL AUTO_INCREMENT,
  Init_date     DATETIME,
  Running1_date DATETIME,
  Running2_date DATETIME,
  Finished_date DATETIME,
  Status        INT NOT NULL,
  Comment       VARCHAR(255),
  PRIMARY KEY (ID)
);

CREATE TABLE batch_status (
  ID          INT NOT NULL AUTO_INCREMENT,
  Name        VARCHAR(255),
  Description VARCHAR(255),
  PRIMARY KEY (ID)
);

CREATE TABLE answer_enum (
  ID          INT          NOT NULL AUTO_INCREMENT,
  Name        VARCHAR(255) NOT NULL,
  Description VARCHAR(255),
  PRIMARY KEY (ID)
);

CREATE TABLE text_nl (
  ID      INT          NOT NULL AUTO_INCREMENT,
  Name    VARCHAR(255) NOT NULL,
  Text    TEXT         NOT NULL,
  Comment VARCHAR(255),
  PRIMARY KEY (ID)
);

CREATE TABLE candidate_poll (
  ID          INT NOT NULL AUTO_INCREMENT,
  Reviewer    INT NOT NULL,
  Reviewee    INT NOT NULL,
  Score       INT,
  Ok_reviewee INT,
  Ok_reviewer INT,
  Ok_overall  INT,
  PRIMARY KEY (ID)
);

ALTER TABLE user
ADD CONSTRAINT un_username UNIQUE (Username);

ALTER TABLE department
ADD CONSTRAINT fk_manager FOREIGN KEY (Manager)
REFERENCES user (ID);

ALTER TABLE admin
ADD CONSTRAINT un_admin UNIQUE (Username);

ALTER TABLE poll
ADD CONSTRAINT fk_reviewerpoll FOREIGN KEY (Reviewer)
REFERENCES user (ID),
ADD CONSTRAINT fk_revieweepoll FOREIGN KEY (Reviewee)
REFERENCES user (ID),
ADD CONSTRAINT fk_statuspoll FOREIGN KEY (Status)
REFERENCES poll_status (ID),
ADD CONSTRAINT fk_batchpoll FOREIGN KEY (Batch)
REFERENCES batch (ID),
ADD CONSTRAINT fk_uniquepoll UNIQUE (Reviewer, Reviewee, Batch);

ALTER TABLE question
ADD CONSTRAINT fk_category FOREIGN KEY (Category)
REFERENCES category (ID);

ALTER TABLE answer
ADD CONSTRAINT fk_poll FOREIGN KEY (Poll)
REFERENCES poll (ID),
ADD CONSTRAINT fk_question FOREIGN KEY (Question)
REFERENCES question (ID),
ADD CONSTRAINT fk_answer FOREIGN KEY (Answer)
REFERENCES answer_enum (ID),
ADD CONSTRAINT un_poll UNIQUE (Poll, Question);
/* this constraint is good and replaces (semantically) the check constraint on answer column in answer table */

ALTER TABLE preferred_poll
ADD CONSTRAINT fk_reviewerpreferred_poll FOREIGN KEY (Reviewer)
REFERENCES user (ID),
ADD CONSTRAINT fk_revieweepreferred_poll FOREIGN KEY (Reviewee)
REFERENCES user (ID),
ADD CONSTRAINT fk_revieweruserpreferred_poll FOREIGN KEY (User)
REFERENCES user (ID),
ADD CONSTRAINT fk_batchpreferred_poll FOREIGN KEY (Batch)
REFERENCES batch (ID),
ADD CONSTRAINT fk_uniquepoll UNIQUE (Reviewer, Reviewee, User, Batch);

ALTER TABLE poll_status
ADD CONSTRAINT un_status UNIQUE (Name);

ALTER TABLE parameter
ADD CONSTRAINT un_parameter UNIQUE (Short_name);

ALTER TABLE batch
ADD CONSTRAINT fk_batch FOREIGN KEY (Status)
REFERENCES batch_status (ID);

ALTER TABLE batch_status
ADD CONSTRAINT un_batch_status UNIQUE (Name);

ALTER TABLE answer_enum
ADD CONSTRAINT un_answer_enum UNIQUE (Name);

ALTER TABLE text_nl
ADD CONSTRAINT un_text UNIQUE (Name);

ALTER TABLE user_department
ADD CONSTRAINT fk_user_user_department FOREIGN KEY (User)
REFERENCES user (ID),
ADD CONSTRAINT fk_department_user_department FOREIGN KEY (Department)
REFERENCES department (ID);

ALTER TABLE candidate_poll
ADD CONSTRAINT fk_reviewer FOREIGN KEY (Reviewer)
REFERENCES user (ID),
ADD CONSTRAINT fk_reviewee FOREIGN KEY (Reviewee)
REFERENCES user (ID);