CREATE DATABASE IF NOT EXISTS `Camagru`;
USE `Camagru`;

CREATE TABLE IF NOT EXISTS `user` (
    `user_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `username` VARCHAR(80) NOT NULL,
    `email` VARCHAR(80) NOT NULL,
    `password` VARCHAR(80) NOT NULL
);

CREATE TABLE IF NOT EXISTS `image`(
    `image_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `username` VARCHAR(80) NOT NULL,
    `date_img` DATETIME NOT NULL,
    `like` INT NOT NULL,
    `dislike` INT NOT NULL,
    `path` LONGBLOB NOT NULL,
    `private` ENUM('N', 'Y')
);

CREATE TABLE IF NOT EXISTS `commentary` (
    `commentary_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `username` VARCHAR(80) NOT NULL,
    `date_comm` DATETIME NOT NULL,
    `image_id` INT NOT NULL,
    `message` TEXT NOT NULL
);