DROP DATABASE IF EXISTS typegame_db;

-- Schema typegame_db
CREATE SCHEMA IF NOT EXISTS `typegame_db` DEFAULT CHARACTER SET utf8;
USE `typegame_db` ;

-- Procedure of tables generator (1 0f 3)
DELIMITER //
CREATE PROCEDURE createAllTables()
BEGIN	
	-- Table `typegame_db`.`user_gender`
	CREATE TABLE IF NOT EXISTS `typegame_db`.`user_gender` (
	  `gender_id` INT NOT NULL AUTO_INCREMENT,
	  `gender_name` VARCHAR(45) NOT NULL DEFAULT 'Undefined',
	  PRIMARY KEY (`gender_id`))
	ENGINE = InnoDB;

	-- Table `typegame_db`.`user_server`
	CREATE TABLE IF NOT EXISTS `typegame_db`.`user_server` (
	  `server_id` INT NOT NULL AUTO_INCREMENT,
	  `server_name` VARCHAR(45) NOT NULL DEFAULT 'Undefined',
	  PRIMARY KEY (`server_id`))
	ENGINE = InnoDB;

	-- Table `typegame_db`.`user_data`
	CREATE TABLE IF NOT EXISTS `typegame_db`.`user_data` (
	  `user_id` INT NOT NULL AUTO_INCREMENT,
	  `username` VARCHAR(45) NULL DEFAULT 'Undefined',
	  `password` VARCHAR(45) NOT NULL,
	  `gender_id` INT NOT NULL DEFAULT 1,
	  `server_id` INT NOT NULL DEFAULT 1,
	  PRIMARY KEY (`user_id`, `gender_id`, `server_id`),
	  INDEX `fk_user_data_user_gender_idx` (`gender_id` ASC),
	  INDEX `fk_user_data_user_server1_idx` (`server_id` ASC),
	  CONSTRAINT `fk_user_data_user_gender`
		FOREIGN KEY (`gender_id`)
		REFERENCES `typegame_db`.`user_gender` (`gender_id`)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	  CONSTRAINT `fk_user_data_user_server1`
		FOREIGN KEY (`server_id`)
		REFERENCES `typegame_db`.`user_server` (`server_id`)
		ON DELETE CASCADE
		ON UPDATE CASCADE)
	ENGINE = InnoDB;

	-- Table `typegame_db`.`valuation_grade`
	CREATE TABLE IF NOT EXISTS `typegame_db`.`valuation_grade` (
	  `grade_id` INT NOT NULL AUTO_INCREMENT,
	  `grade_name` VARCHAR(45) NULL DEFAULT 'None',
	  PRIMARY KEY (`grade_id`))
	ENGINE = InnoDB;

	-- Table `typegame_db`.`valuation_user`
	CREATE TABLE IF NOT EXISTS `typegame_db`.`valuation_user` (
	  `valuation_id` INT NOT NULL AUTO_INCREMENT,
	  `valuation_rate` FLOAT NULL DEFAULT 0,
	  `valuation_score` INT NULL DEFAULT 0,
	  `grade_id` INT NOT NULL DEFAULT 1,
	  `user_id` INT NOT NULL,
	  `gender_id` INT NOT NULL,
	  `server_id` INT NOT NULL,
	  PRIMARY KEY (`valuation_id`, `grade_id`, `user_id`, `gender_id`, `server_id`),
	  INDEX `fk_valuation_user_valuation_grade1_idx` (`grade_id` ASC),
	  INDEX `fk_valuation_user_user_data1_idx` (`user_id` ASC, `gender_id` ASC, `server_id` ASC),
	  CONSTRAINT `fk_valuation_user_valuation_grade1`
		FOREIGN KEY (`grade_id`)
		REFERENCES `typegame_db`.`valuation_grade` (`grade_id`)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	  CONSTRAINT `fk_valuation_user_user_data1`
		FOREIGN KEY (`user_id` , `gender_id` , `server_id`)
		REFERENCES `typegame_db`.`user_data` (`user_id` , `gender_id` , `server_id`)
		ON DELETE CASCADE
		ON UPDATE CASCADE)
	ENGINE = InnoDB;
END
// DELIMITER

-- Procedure of main tables data insert (2 of 3)
DELIMITER //
CREATE PROCEDURE dataInsertDefault()
BEGIN
    INSERT INTO typegame_db.user_gender (gender_id, gender_name) VALUES
    (NULL, 'None'),
    (NULL, 'Male'),
    (NULL, 'Female');

    INSERT INTO typegame_db.user_server (server_id, server_name) VALUES
    (NULL, 'None'),
    (NULL, 'Asia'),
    (NULL, 'America'),
    (NULL, 'Europe'),
    (NULL, 'Africa');

    INSERT INTO typegame_db.valuation_grade (grade_id, grade_name) VALUES
    (NULL, 'None'),
    (NULL, 'Rookie'),
    (NULL, 'Experienced'),
    (NULL, 'Master');
        
    INSERT INTO typegame_db.user_data (user_id, username, password) VALUES
    (NULL, 'Admin', 'fufufu');
END 
// DELIMITER ;

-- Procedure of user generator (3 of 3)
DELIMITER //
CREATE PROCEDURE addUser(
IN uname VARCHAR(50), 
IN upass VARCHAR(50), 
IN genderId INT, 
IN serverId INT)
BEGIN
    INSERT INTO user_data 
        (user_id, username, password, gender_id, server_id) VALUES 
        (NULL, uname, upass, genderId, serverId);
END 
// DELIMITER ;

CALL createAllTables();

-- Trigger for auto user insert
DELIMITER //
CREATE OR REPLACE TRIGGER userInit
AFTER INSERT ON typegame_db.user_data
FOR EACH ROW
BEGIN	
    INSERT INTO typegame_db.valuation_user (user_id, gender_id, server_id) 
    VALUES (NEW.user_id, NEW.gender_id, NEW.server_id);
END
// DELIMITER ;

-- Trigger for auto user delete
DELIMITER //
CREATE OR REPLACE TRIGGER userDeleteInit
AFTER DELETE ON typegame_db.user_data
FOR EACH ROW
BEGIN	
	DELETE FROM typegame_db.valuation_user
    WHERE user_id = OLD.user_id;
END
// DELIMITER ;

-- View
DELIMITER //
CREATE PROCEDURE dbViews()
BEGIN

	CREATE VIEW user_display AS
	SELECT valuation_user.user_id, user_data.username, 
	AVG(valuation_user.valuation_rate) AS rate, SUM(valuation_user.valuation_score) AS score,
	valuation_grade.grade_name AS grade
	FROM valuation_user 
	JOIN user_data ON user_data.user_id = valuation_user.user_id
	JOIN valuation_grade ON valuation_grade.grade_id = valuation_user.grade_id
	GROUP BY user_id
	ORDER BY score DESC;

	-- View (2)
	CREATE VIEW user_detail AS
	SELECT user_data.*, valuation_user.valuation_rate, valuation_user.valuation_score
	FROM user_data
	JOIN valuation_user ON user_data.user_id = valuation_user.user_id;
    
END
// DELIMITER ;

-- Generate database default data + view
CALL dbViews();
CALL dataInsertDefault();

-- Privileges (1 of 2)
DROP USER IF EXISTS 'typegame_admin'@'localhost';
CREATE USER 'typegame_admin'@'localhost' IDENTIFIED BY 'admin';
GRANT ALL PRIVILEGES ON `typegame_db`.* TO 'typegame_admin'@'localhost' WITH GRANT OPTION;

-- Limited privilege (2 of 2)
DROP USER IF EXISTS 'typegame_user'@'localhost';
CREATE USER 'typegame_user'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `typegame_db`.* TO 'typegame_user'@'localhost';

-- Make an user
CALL addUser("Moshi", "wolvie", 2, 3);
CALL addUser("Woo!", "wolie", 1, 1);
CALL addUser("pompozl", "a", 1, 1);
CALL addUser("a", "a", 1, 1);

-- Procedure of grade update
DELIMITER //
CREATE PROCEDURE gradeUpdate(IN userAvg INT, IN userVal INT, IN userId INT)
BEGIN
	
    -- Master
	IF userAvg > 90 AND userVal > 500 THEN
		UPDATE valuation_user SET grade_id = 4 WHERE user_id = userId;
        
	-- Experienced
	ELSEIF userVal > 500 THEN
		UPDATE valuation_user SET grade_id = 3 WHERE user_id = userId;	
        
	-- Rookie
	ELSEIF userVal > 50 THEN
		UPDATE valuation_user SET grade_id = 2 WHERE user_id = userId;
    END IF;

END
// DELIMITER ;

-- Read user data
SELECT * FROM user_display;

-- SELECT user_data.*, valuation_user.grade_id FROM user_data
-- JOIN valuation_user ON valuation_user.user_id = user_data.user_id
-- WHERE username = 'a' AND password = 'a';

/* 

Take this below into the php:

1.	get value from the view of userDisplay
2.	set that value into gradeUpdate procedure

*/

