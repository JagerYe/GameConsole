<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/config.php";

//初始設定
$account = 'superEmp';
$password = '123456';
$email = 'Jager@gmail.net';
$name = 'SuperEmp';

try {
    $dbh = Config::getDBConnect();
    $dbh->beginTransaction();
    $sth = $dbh->prepare("INSERT INTO `Employees`(`account`, `password`, `name`, `email`, `creationDatetime`)
        VALUES(
            (SELECT :account WHERE (SELECT COUNT(`account`) FROM `Employees` AS m WHERE `account`=:account) = 0),
            :password, :name, :email, NOW());");
    $sth->bindParam("account", $account);
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sth->bindParam("password", $password);
    $sth->bindParam("name", $name);
    $sth->bindParam("email", $email);
    $sth->execute();
    $dbh->commit();
    $row = $sth->rowCount();
} catch (PDOException $err) {
    $dbh->rollBack();
    $dbh = null;
    echo $err->getMessage();
}

echo '成功實行' . $row . '筆';
