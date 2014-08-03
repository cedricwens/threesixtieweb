/* Creatie van Database en tabellen */
CREATE DATABASE IF NOT EXISTS threesixtyweb;

DROP TABLE IF EXISTS answer;
DROP TABLE IF EXISTS question;
DROP TABLE IF EXISTS category;
DROP TABLE IF EXISTS poll;
DROP TABLE IF EXISTS user_department;
DROP TABLE IF EXISTS department;
DROP TABLE IF EXISTS user;

CREATE TABLE user(
	ID int NOT NULL AUTO_INCREMENT,
	Name varchar(255) NOT NULL,
	Username varchar(255) NOT NULL,
	Password varchar(255) NOT NULL,
	Email varchar(255) NOT NULL,
	PRIMARY KEY (ID)
);

CREATE TABLE department(
	ID int NOT NULL AUTO_INCREMENT,
	Name varchar(255) NOT NULL,
	Manager int NOT NULL,
	PRIMARY KEY (ID),
	FOREIGN KEY (Manager)
		REFERENCES user(ID)
);

CREATE TABLE user_department(
	ID int NOT NULL AUTO_INCREMENT,
	UserID int NOT NULL,
	DepartmentID int NOT NULL,
	PRIMARY KEY (ID),
	FOREIGN KEY (UserID)
		REFERENCES user(ID),
	FOREIGN KEY (DepartmentID)
		REFERENCES department(ID)
);

CREATE TABLE poll(
	ID int NOT NULL AUTO_INCREMENT,
	Reviewer int NOT NULL,
	Reviewee int NOT NULL,
	Comment text,
	Status int NOT NULL,
	Time timestamp,
	PRIMARY KEY (ID),
	FOREIGN KEY (Reviewer)
		REFERENCES user(ID),
	FOREIGN KEY (Reviewee)
		REFERENCES user(ID)
);

CREATE TABLE category(
	ID int NOT NULL AUTO_INCREMENT,
	Name varchar(255) NOT NULL,
	PRIMARY KEY (ID)
);

CREATE TABLE question(
	ID int NOT NULL AUTO_INCREMENT,
	CategoryID int NOT NULL,
	Question text NOT NULL,
	Comment text,
	PRIMARY KEY (ID),
	FOREIGN KEY (CategoryID)
		REFERENCES category(ID)
);

CREATE TABLE answer(
	ID int NOT NULL AUTO_INCREMENT,
	PollID int NOT NULL,
	QuestionID int NOT NULL,
	Answer text NOT NULL,
	Time timestamp,
	PRIMARY KEY (ID),
	FOREIGN KEY (PollID)
		REFERENCES poll(ID),
	FOREIGN KEY (QuestionID)
		REFERENCES question(ID)
);