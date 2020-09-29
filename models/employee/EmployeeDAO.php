<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/employee/EmployeeDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/config.php";
class EmployeeDAO implements EmployeeDAO_Interface
{
    //新增會員
    public function insert($account, $password, $name, $email)
    {
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
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            return false;
        }
        $dbh = null;
        return true;
    }

    //更新會員
    public function update($id, $name, $email)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("UPDATE `Employees` SET
                    `name`=:name,
                    `email`=:email,
                    `changeDatetime`=NOW()
                WHERE `id`=:id;");
            $sth->bindParam("id", $id);
            $sth->bindParam("name", $name);
            $sth->bindParam("email", $email);
            $sth->execute();
            $dbh->commit();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            return false;
        }
        $dbh = null;
        return true;
    }

    //更新密碼
    public function updatePassword($id, $password)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("UPDATE `Employees` SET `password`=:password,`changeDatetime`=NOW()
                                    WHERE `id`=:id;");
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sth->bindParam("id", $id);
            $sth->bindParam("password", $password);
            $sth->execute();
            $dbh->commit();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            return false;
        }
        $dbh = null;
        return true;
    }

    public function getOneEmployeeByAccount($account)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `id`, `account`, `name`, `email`, `creationDatetime`, `changeDatetime` FROM `Employees` WHERE `account`=:account;");
            $sth->bindParam("account", $account);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            $dbh = null;
            return null;
        }
        $dbh = null;
        return $request;
    }

    public function getOneEmployeeByID($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `id`, `account`, `name`, `email`, `creationDatetime`, `changeDatetime` FROM `Employees` WHERE `id`=:id;");
            $sth->bindParam("id", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            $dbh = null;
            return null;
        }
        $dbh = null;
        return $request;
    }

    public function getAll()
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `id`, `account`, `name`, `email`, `creationDatetime`, `changeDatetime` FROM `Employees`;");
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            $dbh = null;
            return null;
        }
        $dbh = null;
        return $request;
    }

    public function doLogin($account, $password)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT COUNT(`id`) AS `check`, `id` FROM `employees` WHERE `account`=:account;");
            $sth->bindParam("account", $account);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_ASSOC);
            if ($request['check'] != 1) {
                throw new Exception("帳號密碼錯誤");
            }

            $check = $this->checkPassword($request['id'], $password, $dbh);
            $sth = null;
        } catch (Exception $err) {
            if ($dbh !== null) {
                $dbh = null;
            }
            return false;
        }
        $dbh = null;
        return $check;
    }

    public function checkPassword($id, $password, $dbh = null)
    {
        try {
            if ($dbh === null) {
                $dbh = Config::getDBConnect();
            }
            $sth = $dbh->prepare("SELECT `password` FROM `employees` WHERE `id`=:id");
            $sth->bindParam("id", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_NUM);
            $sth = null;
        } catch (Exception $err) {
            $dbh = null;
            return false;
        }
        return password_verify($password, $request['0']);
    }

    public function checkEmployeeExist($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("SELECT COUNT(*) FROM `Employees` WHERE `account` = :account;");
            $sth->bindParam("account", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_NUM);
        } catch (Exception $err) {
            $dbh = null;
            return false;
        }
        return $request['0'] > 0;
    }
}
