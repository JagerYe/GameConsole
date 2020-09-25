DROP DATABASE IF EXISTS `GameConsole`;
CREATE DATABASE IF NOT EXISTS `GameConsole` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `GameConsole`;

DROP TABLE IF EXISTS `Members`;
CREATE TABLE `Members`(
    `id` INT NOT NULL AUTO_INCREMENT,
    `account` VARCHAR(20) NOT NULL,
    `password` TEXT NOT NULL,
    `name` VARCHAR(20) NOT NULL,
    `email` VARCHAR(50) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `address` TEXT NOT NULL,
    `status` BOOLEAN NOT NULL,
    `creationDate` DATETIME NOT NULL,
    `changeDate` DATETIME NOT NULL,
    PRIMARY KEY(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `Commodities`;
CREATE TABLE `Commodities`(
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` TEXT NOT NULL,
    `price` INT NOT NULL,
    `quantity` INT NOT NULL,
    `image` BLOB,
    `creationDate` DATETIME NOT NULL,
    `changeDate` DATETIME NOT NULL,
    PRIMARY KEY(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `Employees`;
CREATE TABLE `Employees`(
    `id` INT NOT NULL AUTO_INCREMENT,
    `account` VARCHAR(20) NOT NULL,
    `password` TEXT NOT NULL,
    `name` VARCHAR(20) NOT NULL,
    `email` VARCHAR(50) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `address` TEXT NOT NULL,
    `creationDate` DATETIME NOT NULL,
    `changeDate` DATETIME NOT NULL,
    PRIMARY KEY(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `Permissions`;
CREATE TABLE `Permissions`(
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(20) NOT NULL,
    `creationDate` DATETIME NOT NULL,
    `changeDate` DATETIME NOT NULL,
    PRIMARY KEY(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8;