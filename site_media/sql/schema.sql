CREATE DATABASE IF NOT EXISTS `mvc_example`;
USE `mvc_example`;

CREATE TABLE IF NOT EXISTS `Users`(
	`id` INT(5) AUTO_INCREMENT NOT NULL,
	`name` VARCHAR(20) NOT NULL,
	`last_name` VARCHAR(10) NOT NULL,
	`email` VARCHAR(40) NOT NULL, 
	`password` VARCHAR(30) NOT NULL,
	PRIMARY KEY(id)
) ENGINE=MyISAM CHARSET=UTF8;