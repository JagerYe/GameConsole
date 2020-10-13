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
            $id = $dbh->lastInsertId();
            $dbh->commit();

            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            throw new Exception("新增發生錯誤\r\n" . $err->getMessage());
        }
        $dbh = null;
        return $id;
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
            throw new Exception("更新發生錯誤\r\n" . $err->getMessage());
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
            throw new Exception("更新密碼發生錯誤\r\n" . $err->getMessage());
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
            throw new Exception("取得資料發生錯誤\r\n" . $err->getMessage());
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
            throw new Exception("取得資料發生錯誤\r\n" . $err->getMessage());
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
            $request = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            $dbh = null;
            throw new Exception("取得資料發生錯誤\r\n" . $err->getMessage());
        }
        $dbh = null;
        return $request;
    }

    public function getSome($lastID = null)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `id`, `account`, `name`, `email`, `creationDatetime`, `changeDatetime`
                FROM `Employees`
                WHERE `id`>IFNULL(:lastID, 0) ORDER BY `id` LIMIT 5;");
            $sth->bindParam("lastID", $lastID);
            $sth->execute();
            $request = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            $dbh = null;
            throw new Exception("取得資料發生錯誤\r\n" . $err->getMessage());
        }
        $dbh = null;
        return $request;
    }

    public function getLastID()
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `id` FROM `Employees` ORDER BY `id` DESC LIMIT 1;");
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_NUM);
            $sth = null;
        } catch (PDOException $err) {
            $dbh = null;
            throw new Exception("取得資料發生錯誤\r\n" . $err->getMessage());
        }
        $dbh = null;
        return isset($request[0]) ? $request[0] : -1;
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
            throw new Exception("登入發生錯誤\r\n" . $err->getMessage());
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
            throw new Exception("確認密碼發生錯誤\r\n" . $err->getMessage());
        }
        return password_verify($password, $request['0']);
    }

    public function checkAccountExist($id)
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
            throw new Exception("確認帳號是否重複發生錯誤\r\n" . $err->getMessage());
        }
        return $request['0'] > 0;
    }
}
