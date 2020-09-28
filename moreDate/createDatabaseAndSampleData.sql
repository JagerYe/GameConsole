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
    `address` TEXT,
    `status` BOOLEAN NOT NULL,
    `creationDate` DATETIME NOT NULL,
    `changeDate` DATETIME,
    PRIMARY KEY(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `MemberLoginStatus`;
CREATE TABLE `MemberLoginStatus`(
    `loginID` INT NOT NULL AUTO_INCREMENT,
    `memberID` INT NOT NULL,
    `cookieID` TEXT NOT NULL,
    `loginDate` DATETIME NOT NULL,
    `logoutDate` DATETIME,
    PRIMARY KEY(`loginID`),
    FOREIGN KEY(`memberID`) REFERENCES `Members`(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8mb4;

DROP TABLE IF EXISTS `Commodities`;
CREATE TABLE `Commodities`(
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` TEXT NOT NULL,
    `price` INT NOT NULL,
    `quantity` INT NOT NULL,
    `image` BLOB,
    `creationDate` DATETIME NOT NULL,
    `changeDate` DATETIME,
    PRIMARY KEY(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `Orders`;
CREATE TABLE `Orders`(
    `orderID` INT NOT NULL AUTO_INCREMENT,
    `memberID` INT NOT NULL,
    `address` TEXT NOT NULL,
    `creationDate` DATETIME NOT NULL,
    `changeDate` DATETIME,
    PRIMARY KEY(`orderID`),
    FOREIGN KEY(`memberID`) REFERENCES `Members`(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8mb4;

DROP TABLE IF EXISTS `OrderDetails`;
CREATE TABLE `OrderDetails`(
    `orderID` INT NOT NULL,
    `commodityID` INT NOT NULL,
    `address` TEXT NOT NULL,
    `price` INT NOT NULL,
    `quantity` INT NOT NULL,
    `creationDate` DATETIME NOT NULL,
    `changeDate` DATETIME,
    PRIMARY KEY(`orderID`),
    FOREIGN KEY(`commodityID`) REFERENCES `Commodities`(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8mb4;

DROP TABLE IF EXISTS `Employees`;
CREATE TABLE `Employees`(
    `id` INT NOT NULL AUTO_INCREMENT,
    `account` VARCHAR(20) NOT NULL,
    `password` TEXT NOT NULL,
    `name` VARCHAR(20) NOT NULL,
    `email` VARCHAR(50) NOT NULL,
    `creationDate` DATETIME NOT NULL,
    `changeDate` DATETIME,
    PRIMARY KEY(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `EmployeeLoginStatus`;
CREATE TABLE `EmployeeLoginStatus`(
    `loginID` INT NOT NULL AUTO_INCREMENT,
    `employeeID` INT NOT NULL,
    `cookieID` TEXT NOT NULL,
    `loginDate` DATETIME NOT NULL,
    `logoutDate` DATETIME,
    PRIMARY KEY(`loginID`),
    FOREIGN KEY(`employeeID`) REFERENCES `Employees`(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8mb4;

DROP TABLE IF EXISTS `Permissions`;
CREATE TABLE `Permissions`(
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(20) NOT NULL,
    `creationDate` DATETIME NOT NULL,
    `changeDate` DATETIME,
    PRIMARY KEY(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `PermissionControl`;
CREATE TABLE `PermissionControl`(
    `employeeID` INT NOT NULL,
    `permissionID` INT NOT NULL,
    `creationDate` DATETIME NOT NULL,
    PRIMARY KEY(`employeeID`,`permissionID`),
    FOREIGN KEY(`employeeID`) REFERENCES `Employees`(`id`),
    FOREIGN KEY(`permissionID`) REFERENCES `Permissions`(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8mb4;