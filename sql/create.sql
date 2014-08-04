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
	Status int NOT NULL,
	Time datetime,
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
	Time timestamp,
	PRIMARY KEY (ID)
);

CREATE TABLE preferred_poll(
	ID int NOT NULL AUTO_INCREMENT,
	Reviewer int NOT NULL,
	Reviewee int NOT NULL,
	PRIMARY KEY (ID)
);

ALTER TABLE user 
	ADD CONSTRAINT fk_department FOREIGN KEY (Department)
		REFERENCES department(ID);

ALTER TABLE department
	ADD CONSTRAINT fk_manager 	FOREIGN KEY (Manager)
		REFERENCES user(ID);

ALTER TABLE poll
	ADD CONSTRAINT fk_reviewerpoll FOREIGN KEY (Reviewer)
		REFERENCES user(ID),
	ADD CONSTRAINT fk_revieweepoll FOREIGN KEY (Reviewee)
		REFERENCES user(ID);

ALTER TABLE question
	ADD CONSTRAINT fk_category FOREIGN KEY (Category)
		REFERENCES category(ID);

ALTER TABLE answer
	ADD CONSTRAINT fk_poll	FOREIGN KEY (Poll)
		REFERENCES poll(ID),
	ADD CONSTRAINT fk_question FOREIGN KEY (Question)
		REFERENCES question(ID);

ALTER TABLE choice
	ADD CONSTRAINT fk_reviewerchoice FOREIGN KEY (Reviewer)
		REFERENCES user(ID),
	ADD CONSTRAINT fk_revieweechoice FOREIGN KEY (Reviewee)
		REFERENCES user(ID);