/* Creatie van Database en tabellen */
DROP DATABASE IF EXISTS threesixtyweb;
CREATE DATABASE threesixtyweb;
USE threesixtyweb;

CREATE TABLE user(
	ID int NOT NULL AUTO_INCREMENT,
	Name varchar(255) NOT NULL,
	Username varchar(255),
	Password varchar(255),
	Email varchar(255),
	Department int NOT NULL,
	PRIMARY KEY (ID)
);

CREATE TABLE department(
	ID int NOT NULL AUTO_INCREMENT,
	Name varchar(255) NOT NULL,
	Manager int,
	PRIMARY KEY (ID)
);

CREATE TABLE poll(
	ID int NOT NULL AUTO_INCREMENT,
	Reviewer int NOT NULL,
	Reviewee int NOT NULL,
	Comment text,
	Status int,
	Time_Created datetime,
	Last_Update datetime,
	Batch int /* NOT NULL */,
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
	Question text NOT NULL,
	Comment text,
	PRIMARY KEY (ID)
);

CREATE TABLE answer(
	ID int NOT NULL AUTO_INCREMENT,
	Poll int NOT NULL,
	Question int NOT NULL,
	Answer text NOT NULL,
	Time_Created datetime,
	Last_Update datetime,
	PRIMARY KEY (ID)
);

CREATE TABLE preferred_poll(
	ID int NOT NULL AUTO_INCREMENT,
	Reviewer int NOT NULL,
	Reviewee int NOT NULL,
	User int NOT NULL,
	Batch int NOT NULL,
	PRIMARY KEY (ID)
);

CREATE TABLE status(
	ID int NOT NULL AUTO_INCREMENT,
	Name text NOT NULL,
	PRIMARY KEY (ID)
);

CREATE TABLE parameter(
	ID int NOT NULL AUTO_INCREMENT,
	Name text NOT NULL,
	PRIMARY KEY (ID)
);

CREATE TABLE batch_status(
	ID int NOT NULL AUTO_INCREMENT,
	Init_date datetime, 
	Running_date datetime,
	Finished_date datetime,
	Comment text,
	PRIMARY KEY (ID)
);

ALTER TABLE user 
	ADD CONSTRAINT fk_department FOREIGN KEY (Department)
		REFERENCES department(ID),
	ADD CONSTRAINT un_username UNIQUE (Username);

ALTER TABLE department
	ADD CONSTRAINT fk_manager 	FOREIGN KEY (Manager)
		REFERENCES user(ID);

ALTER TABLE poll
	ADD CONSTRAINT fk_reviewerpoll FOREIGN KEY (Reviewer)
		REFERENCES user(ID),
	ADD CONSTRAINT fk_revieweepoll FOREIGN KEY (Reviewee)
		REFERENCES user(ID),
	ADD CONSTRAINT fk_batchpoll FOREIGN KEY (Batch)
		REFERENCES batch_status(ID),
	ADD CONSTRAINT fk_uniquepoll UNIQUE (Reviewer, Reviewee, Batch);

ALTER TABLE question
	ADD CONSTRAINT fk_category FOREIGN KEY (Category)
		REFERENCES category(ID);

ALTER TABLE answer
	ADD CONSTRAINT fk_poll	FOREIGN KEY (Poll)
		REFERENCES poll(ID),
	ADD CONSTRAINT fk_question FOREIGN KEY (Question)
		REFERENCES question(ID),
	ADD CONSTRAINT ch_value CHECK (Answer < 6),
	ADD CONSTRAINT un_poll UNIQUE (Poll, Question);

ALTER TABLE preferred_poll
	ADD CONSTRAINT fk_reviewerpreferred_poll FOREIGN KEY (Reviewer)
		REFERENCES user(ID),
	ADD CONSTRAINT fk_revieweepreferred_poll FOREIGN KEY (Reviewee)
		REFERENCES user(ID),
	ADD CONSTRAINT fk_revieweruserpreferred_poll FOREIGN KEY (User)
		REFERENCES user(ID),
	ADD CONSTRAINT fk_batchpreferred_poll FOREIGN KEY (Batch)
		REFERENCES batch_status(ID),
	ADD CONSTRAINT fk_uniquepoll UNIQUE (Reviewer, Reviewee, Batch);