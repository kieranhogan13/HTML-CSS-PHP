DROP DATABASE dit;
CREATE DATABASE dit;
USE stuff;
CREATE TABLE `users` (
	name VARCHAR(25),
	surname	VARCHAR(25),
	email VARCHAR(50),
	password VARCHAR(40),
	id INT NOT NULL AUTO_INCREMENT, 
	PRIMARY KEY ( id )) ENGINE = INNODB;

CREATE TABLE `teams` (
	name VARCHAR(50),
	city VARCHAR(50),
	country VARCHAR(50),
	info	VARCHAR(150),
	id INT NOT NULL AUTO_INCREMENT, 
	PRIMARY KEY ( id )) ENGINE = INNODB;
    
CREATE TABLE `players` (
	name VARCHAR(50),
	surname VARCHAR(50),
	age INT(11),
	nationality	VARCHAR(50),
    team INT(11),
    id INT NOT NULL AUTO_INCREMENT, 
	PRIMARY KEY ( id )) ENGINE = INNODB;

INSERT INTO users (name, surname, email, password) VALUES ("test_first", "test-last", "test@test.com", "1234");
INSERT INTO teams (name, city, country, info) VALUES ("test_team", "test-city", "test_country", "This is the test info");
INSERT INTO players (name, surname, age, nationality, team) VALUES ("test_first", "test-last", 24, "Irish", 1);

