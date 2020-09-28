DROP DATABASE IF EXISTS `GameConsole`;
CREATE DATABASE IF NOT EXISTS `GameConsole` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE `GameConsole`;

DROP TABLE IF EXISTS `Members`;
CREATE TABLE `Members`(
    `id` INT NOT NULL AUTO_INCREMENT,
    `account` VARCHAR(20) NOT NULL,-- 帳號
    `password` TEXT NOT NULL,-- 密碼
    `name` VARCHAR(20) NOT NULL,-- 姓名
    `email` VARCHAR(50) NOT NULL,-- 信箱
    `phone` VARCHAR(20) NOT NULL,-- 電話
    `address` TEXT,-- 地址
    `status` BOOLEAN NOT NULL,-- 停權狀態 True可使用，False不可使用
    `creationDatetime` DATETIME NOT NULL,-- 創立時間
    `changeDatetime` DATETIME,-- 更動資料時間
    PRIMARY KEY(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `MemberLoginStatus`;
CREATE TABLE `MemberLoginStatus`(
    `loginID` INT NOT NULL AUTO_INCREMENT,
    `memberID` INT NOT NULL,
    `cookieID` TEXT NOT NULL,
    `keepLoggedIn` BOOLEAN NOT NULL,-- 是否要保持登入
    `loginDatetime` DATETIME NOT NULL,
    `usageDatetime` DATETIME,
    `logoutDatetime` DATETIME,
    PRIMARY KEY(`loginID`),
    FOREIGN KEY(`memberID`) REFERENCES `Members`(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `Commodities`;
CREATE TABLE `Commodities`(
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` TEXT NOT NULL,
    `price` INT NOT NULL,
    `quantity` INT NOT NULL,
    `status` BOOLEAN NOT NULL,
    `text` TEXT,
    `image` BLOB,
    `creationDatetime` DATETIME NOT NULL,
    `changeDatetime` DATETIME,
    PRIMARY KEY(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `Orders`;
CREATE TABLE `Orders`(
    `orderID` INT NOT NULL AUTO_INCREMENT,
    `memberID` INT NOT NULL,
    `address` TEXT NOT NULL,
    `creationDatetime` DATETIME NOT NULL,
    `changeDatetime` DATETIME,
    PRIMARY KEY(`orderID`),
    FOREIGN KEY(`memberID`) REFERENCES `Members`(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `OrderDetails`;
CREATE TABLE `OrderDetails`(
    `orderID` INT NOT NULL,
    `commodityID` INT NOT NULL,
    `price` INT NOT NULL,
    `quantity` INT NOT NULL,
    `creationDatetime` DATETIME NOT NULL,
    `changeDatetime` DATETIME,
    PRIMARY KEY(`orderID`,`commodityID`),
    FOREIGN KEY(`orderID`) REFERENCES `Orders`(`orderID`),
    FOREIGN KEY(`commodityID`) REFERENCES `Commodities`(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8;
ALTER TABLE `GameConsole`.`OrderDetails` ADD INDEX `orderID` (`orderID`);

DROP TABLE IF EXISTS `Employees`;
CREATE TABLE `Employees`(
    `id` INT NOT NULL AUTO_INCREMENT,
    `account` VARCHAR(20) NOT NULL,
    `password` TEXT NOT NULL,
    `name` VARCHAR(20) NOT NULL,
    `email` VARCHAR(50) NOT NULL,
    `creationDatetime` DATETIME NOT NULL,
    `changeDatetime` DATETIME,
    PRIMARY KEY(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `EmployeeLoginStatus`;
CREATE TABLE `EmployeeLoginStatus`(
    `loginID` INT NOT NULL AUTO_INCREMENT,
    `employeeID` INT NOT NULL,
    `cookieID` TEXT NOT NULL,
    `keepLoggedIn` BOOLEAN NOT NULL,
    `loginDatetime` DATETIME NOT NULL,
    `usageDatetime` DATETIME,
    `logoutDatetime` DATETIME,
    PRIMARY KEY(`loginID`),
    FOREIGN KEY(`employeeID`) REFERENCES `Employees`(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `Permissions`;
CREATE TABLE `Permissions`(
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(20) NOT NULL,
    `creationDatetime` DATETIME NOT NULL,
    `changeDatetime` DATETIME,
    PRIMARY KEY(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `PermissionControl`;
CREATE TABLE `PermissionControl`(
    `employeeID` INT NOT NULL,
    `permissionID` INT NOT NULL,
    `creationDatetime` DATETIME NOT NULL,
    PRIMARY KEY(`employeeID`,`permissionID`),
    FOREIGN KEY(`employeeID`) REFERENCES `Employees`(`id`),
    FOREIGN KEY(`permissionID`) REFERENCES `Permissions`(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8;

INSERT INTO `Members`(`account`, `password`, `name`, `email`, `phone`, `address`, `status`, `creationDatetime`) VALUES
('m01','123456','a','a@s.s','1234567890','aca',true,NOW()),
('m02','123456','a','a@s.s','1234567890','aca',true,NOW()),
('m03','123456','a','a@s.s','1234567890','aca',true,NOW());

INSERT INTO `MemberLoginStatus`(`memberID`, `cookieID`, `keepLoggedIn`, `loginDatetime`) VALUES (1,'11235',false,NOW());

INSERT INTO `Commodities`(`name`, `price`, `quantity`, `status`, `creationDatetime`) VALUES
('aa',100,100,TRUE,NOW()),
('aa',100,100,TRUE,NOW()),
('aa',100,100,TRUE,NOW()),
('aa',100,100,TRUE,NOW()),
('aa',100,100,TRUE,NOW());

INSERT INTO `Orders`(`memberID`, `address`, `creationDatetime`) VALUES (1,'add',NOW());

INSERT INTO `OrderDetails`(`orderID`, `commodityID`, `price`, `quantity`, `creationDatetime`) VALUES
(1,1,100,10,NOW()),
(1,2,100,10,NOW()),
(1,3,100,10,NOW());