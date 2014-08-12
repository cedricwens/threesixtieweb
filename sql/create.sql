/* Creatie van Database en tabellen */
DROP DATABASE IF EXISTS threesixtyweb;
CREATE DATABASE threesixtyweb;
USE threesixtyweb;

CREATE TABLE user(
	ID int NOT NULL AUTO_INCREMENT,
	Firstname varchar(255) NOT NULL,
	Lastname varchar(255) NOT NULL,
	Username varchar(255),
	Password varchar(255) NOT NULL,
	Email varchar(255),
	Job_Title varchar(255),
	PRIMARY KEY (ID)
);

CREATE TABLE department(
	ID int NOT NULL AUTO_INCREMENT,
	Name varchar(255) NOT NULL,
	Manager int,
	/*consider - non mandatory -  moving the manager value to usertable this will mitigate the circular dependency in an initial state */
	PRIMARY KEY (ID)
);

CREATE TABLE user_department(
	ID int NOT NULL AUTO_INCREMENT,
	User int NOT NULL,
	Department int NOT NULL,
	PRIMARY KEY (ID)
);

CREATE TABLE admin(
	ID int NOT NULL AUTO_INCREMENT,
	Username varchar(255),
	Password varchar(255),
	PRIMARY KEY (ID)
);

CREATE TABLE poll(
	ID int NOT NULL AUTO_INCREMENT,
	Reviewer int NOT NULL,
	Reviewee int NOT NULL,
	Comment varchar(255),
	Status int NOT NULL,
	Time_Created datetime,
	Last_Update datetime,
	Batch int,
	PRIMARY KEY (ID)
);

CREATE TABLE category(
	ID int NOT NULL AUTO_INCREMENT,
	Name varchar(255) NOT NULL,
	PRIMARY KEY (ID)
);

CREATE TABLE question(
	ID int NOT NULL AUTO_INCREMENT,
	Category int NOT NULL,
	Question varchar(255) NOT NULL,
	Comment varchar(255),
	Batch int NOT NULL,
	PRIMARY KEY (ID)
	/* future improvement - non mandatory - add a column referring to BATCH*/
);

CREATE TABLE answer(
	ID int NOT NULL AUTO_INCREMENT,
	Poll int NOT NULL,
	Question int NOT NULL,
	Answer int NOT NULL,
	Time_Created datetime,
	Last_Update datetime,
	PRIMARY KEY (ID)
);

CREATE TABLE preferred_poll(
	ID int NOT NULL AUTO_INCREMENT,
	Reviewer int NOT NULL,
	Reviewee int NOT NULL,
	User int NOT NULL,
	Batch int,
	PRIMARY KEY (ID)
);

CREATE TABLE poll_status(
	ID int NOT NULL AUTO_INCREMENT,
	Name varchar(255) NOT NULL,
	PRIMARY KEY (ID)
);

CREATE TABLE parameter(
	ID int NOT NULL AUTO_INCREMENT,
	Name varchar(255) NOT NULL,
	Value int NOT NULL,
	Comment varchar(255),
	PRIMARY KEY (ID)
);

CREATE TABLE batch(
	ID int NOT NULL AUTO_INCREMENT,
	Init_date datetime, 
	Running1_date datetime,
	Running2_date datetime,
	Finished_date datetime,
	Status int NOT NULL,
	Comment varchar(255),
	PRIMARY KEY (ID)
);

CREATE TABLE batch_status(
	ID int NOT NULL AUTO_INCREMENT,
	Name varchar(255),
	Description varchar(255),
	PRIMARY KEY (ID)
);

CREATE TABLE answer_enum(
	ID int NOT NULL AUTO_INCREMENT,
	Name varchar(255) NOT NULL,
	Description varchar(255),
	PRIMARY KEY (ID)
);

CREATE TABLE text_nl(
	ID int NOT NULL AUTO_INCREMENT,
	Name varchar(255) NOT NULL,
	Text text NOT NULL,
	Comment varchar(255),
	PRIMARY KEY (ID)
);

ALTER TABLE user 
	ADD CONSTRAINT un_username UNIQUE (Username);

ALTER TABLE department
	ADD CONSTRAINT fk_manager FOREIGN KEY (Manager)
		REFERENCES user(ID);

ALTER TABLE admin
	ADD CONSTRAINT un_admin UNIQUE (Username);

ALTER TABLE poll
	ADD CONSTRAINT fk_reviewerpoll FOREIGN KEY (Reviewer)
		REFERENCES user(ID),
	ADD CONSTRAINT fk_revieweepoll FOREIGN KEY (Reviewee)
		REFERENCES user(ID),
	ADD CONSTRAINT fk_statuspoll FOREIGN KEY (Status)
		REFERENCES poll_status(ID),
	ADD CONSTRAINT fk_batchpoll FOREIGN KEY (Batch)
		REFERENCES batch(ID),
	ADD CONSTRAINT fk_uniquepoll UNIQUE (Reviewer, Reviewee, Batch);

ALTER TABLE question
	ADD CONSTRAINT fk_category FOREIGN KEY (Category)
		REFERENCES category(ID),
	ADD CONSTRAINT un_questionbatch UNIQUE (Question, Batch);

ALTER TABLE answer
	ADD CONSTRAINT fk_poll	FOREIGN KEY (Poll)
		REFERENCES poll(ID),
	ADD CONSTRAINT fk_question FOREIGN KEY (Question)
		REFERENCES question(ID),
	ADD CONSTRAINT fk_answer FOREIGN KEY (Answer)
		REFERENCES answer_enum(ID),
	ADD CONSTRAINT un_poll UNIQUE (Poll, Question);
	/* this constraint is good and replaces (semantically) the check constraint on answer column in answer table */

ALTER TABLE preferred_poll
	ADD CONSTRAINT fk_reviewerpreferred_poll FOREIGN KEY (Reviewer)
		REFERENCES user(ID),
	ADD CONSTRAINT fk_revieweepreferred_poll FOREIGN KEY (Reviewee)
		REFERENCES user(ID),
	ADD CONSTRAINT fk_revieweruserpreferred_poll FOREIGN KEY (User)
		REFERENCES user(ID),
	ADD CONSTRAINT fk_batchpreferred_poll FOREIGN KEY (Batch)
		REFERENCES batch(ID),
	ADD CONSTRAINT fk_uniquepoll UNIQUE (Reviewer, Reviewee, Batch);

ALTER TABLE poll_status
	ADD CONSTRAINT un_status UNIQUE(Name);

ALTER TABLE parameter
	ADD CONSTRAINT un_parameter UNIQUE(Name);

ALTER TABLE batch
	ADD CONSTRAINT fk_batch FOREIGN KEY (Status)
		REFERENCES batch_status(ID);

ALTER TABLE batch_status
	ADD CONSTRAINT un_batch_status UNIQUE (Name);

ALTER TABLE answer_enum
	ADD CONSTRAINT un_answer_enum UNIQUE(Name);

ALTER TABLE text_nl
	ADD CONSTRAINT un_text UNIQUE (Name);

ALTER TABLE user_department
	ADD CONSTRAINT fk_user_user_department FOREIGN KEY (User)
		REFERENCES user(ID),
	ADD CONSTRAINT fk_department_user_department FOREIGN KEY (Department)
		REFERENCES department(ID);