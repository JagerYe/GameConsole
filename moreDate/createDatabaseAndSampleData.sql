DROP DATABASE IF EXISTS `GameConsole`;
CREATE DATABASE IF NOT EXISTS `GameConsole` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

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
    `status` INT NOT NULL COMMENT '停用為1，啟用為2',
    `creationDatetime` DATETIME NOT NULL,
    `changeDatetime` DATETIME,
    PRIMARY KEY(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8 COMMENT '會員';

DROP TABLE IF EXISTS `MemberLoginStatus`;
CREATE TABLE `MemberLoginStatus`(
    `loginID` INT NOT NULL AUTO_INCREMENT,
    `memberID` INT NOT NULL,
    `isKeep` BOOLEAN NOT NULL COMMENT '不保持登入為0，保持登入為1',
    `cookieID` TEXT,
    `loginDatetime` DATETIME NOT NULL COMMENT '登入時間',
    `usageDatetime` DATETIME COMMENT '最後一次使用時間',
    `logoutDatetime` DATETIME COMMENT '登出時間',
    PRIMARY KEY(`loginID`),
    FOREIGN KEY(`memberID`) REFERENCES `Members`(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8 COMMENT '會員登入紀錄';

DROP TABLE IF EXISTS `Commodities`;
CREATE TABLE `Commodities`(
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` TEXT NOT NULL COMMENT '商品名稱',
    `price` INT NOT NULL,
    `quantity` INT NOT NULL COMMENT '商品庫存',
    `status` INT NOT NULL COMMENT '商品上下架狀態，下架為0，上架為1',
    `text` TEXT COMMENT '商品介紹內文',
    `image` LONGBLOB,
    `creationDatetime` DATETIME NOT NULL,
    `changeDatetime` DATETIME,
    PRIMARY KEY(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8 COMMENT '商品';

DROP TABLE IF EXISTS `Orders`;
CREATE TABLE `Orders`(
    `orderID` INT NOT NULL AUTO_INCREMENT,
    `memberID` INT NOT NULL,
    `address` TEXT NOT NULL COMMENT '當次寄送的地址',
    `creationDatetime` DATETIME NOT NULL,
    `changeDatetime` DATETIME,
    PRIMARY KEY(`orderID`),
    FOREIGN KEY(`memberID`) REFERENCES `Members`(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8 COMMENT '訂單';

DROP TABLE IF EXISTS `OrderDetails`;
CREATE TABLE `OrderDetails`(
    `orderID` INT NOT NULL,
    `commodityID` INT NOT NULL,
    `price` INT NOT NULL COMMENT '當時價格',
    `quantity` INT NOT NULL COMMENT '購買數量',
    `creationDatetime` DATETIME NOT NULL,
    `changeDatetime` DATETIME,
    PRIMARY KEY(`orderID`,`commodityID`),
    FOREIGN KEY(`orderID`) REFERENCES `Orders`(`orderID`),
    FOREIGN KEY(`commodityID`) REFERENCES `Commodities`(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8 COMMENT '訂單明細';

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
) ENGINE = INNODB DEFAULT CHARSET = utf8 COMMENT '員工';

DROP TABLE IF EXISTS `EmployeeLoginStatus`;
CREATE TABLE `EmployeeLoginStatus`(
    `loginID` INT NOT NULL AUTO_INCREMENT,
    `empID` INT NOT NULL,
    `isKeep` BOOLEAN NOT NULL COMMENT '不保持登入為0，保持登入為1',
    `cookieID` TEXT,
    `loginDatetime` DATETIME NOT NULL COMMENT '登入時間',
    `usageDatetime` DATETIME COMMENT '最後使用時間',
    `logoutDatetime` DATETIME COMMENT '登出時間',
    PRIMARY KEY(`loginID`),
    FOREIGN KEY(`empID`) REFERENCES `Employees`(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8 COMMENT '員工登入紀錄';

DROP TABLE IF EXISTS `Permissions`;
CREATE TABLE `Permissions`(
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(20) NOT NULL,
    `creationDatetime` DATETIME NOT NULL,
    `changeDatetime` DATETIME,
    PRIMARY KEY(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8 COMMENT = '權限';

DROP TABLE IF EXISTS `PermissionControl`;
CREATE TABLE `PermissionControl`(
    `empID` INT NOT NULL,
    `permissionID` INT NOT NULL,
    `creationDatetime` DATETIME NOT NULL,
    PRIMARY KEY(`empID`,`permissionID`),
    FOREIGN KEY(`empID`) REFERENCES `Employees`(`id`),
    FOREIGN KEY(`permissionID`) REFERENCES `Permissions`(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8 COMMENT '權限及員工對照表';

INSERT INTO `Members`(`account`, `password`, `name`, `email`, `phone`, `address`, `status`, `creationDatetime`) VALUES
('m01','123456','a','a@s.s','1234567890','aca',true,NOW()),
('m02','123456','a','a@s.s','1234567890','aca',true,NOW()),
('m03','123456','a','a@s.s','1234567890','aca',true,NOW());

INSERT INTO `MemberLoginStatus`(`memberID`, `isKeep`, `cookieID`, `loginDatetime`) VALUES (1,TRUE,'11235',NOW());

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

INSERT INTO `Permissions`(`name`, `creationDatetime`) VALUES
('員工檢視',NOW()),
('員工管理',NOW()),
('商品檢視',NOW()),
('商品管理',NOW()),
('會員檢視',NOW()),
('會員管理',NOW());