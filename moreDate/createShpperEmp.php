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

    $sth = $dbh->prepare("SELECT `id`, (SELECT COUNT(*) FROM `Permissions`) AS 'permissionsSize'
        FROM `Employees` WHERE `account`=:account;");
    $sth->bindParam("account", $account);
    $sth->execute();
    $request = $sth->fetch(PDO::FETCH_ASSOC);

    $sqlStr = "INSERT INTO `PermissionControl`(`empID`, `permissionID`, `creationDatetime`) VALUES";
    for ($i = 1; $i <= $request['permissionsSize']; $i++) {
        $sqlStr .= "(:id,$i,NOW()),";
    }
    $sqlStr = substr_replace($sqlStr, ';', -1, 1);
    $sth = $dbh->prepare($sqlStr);
    $sth->bindParam("id", $request['id']);
    $sth->execute();
    $dbh->commit();
} catch (PDOException $err) {
    $dbh->rollBack();
    $dbh = null;
    echo $err->getMessage();
}

echo '成功實行';
