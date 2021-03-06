<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/member/MemberDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/config.php";
class MemberDAO implements MemberDAO_Interface
{
    //新增會員
    public function insert($account, $password, $name, $email, $phone, $address = null)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("INSERT INTO `Members`(`account`, `password`, `name`, `email`, `phone`, `address`, `status`, `creationDatetime`)
                VALUES(
                    (SELECT :account WHERE (SELECT COUNT(`account`) FROM `Members` AS m WHERE `account`=:account) = 0),
                    :password, :name, :email, :phone, :address, true, NOW()
            );");
            $sth->bindParam("account", $account);
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sth->bindParam("password", $password);
            $sth->bindParam("name", $name);
            $sth->bindParam("email", $email);
            $sth->bindParam("phone", $phone);
            $sth->bindParam("address", $address);
            $sth->execute();
            $dbh->commit();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            throw new Exception("新增發生錯誤\r\n" . $err->getMessage());
        }
        $dbh = null;
        return true;
    }

    //更新會員
    public function update($id, $name, $email, $phone, $address = null)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("UPDATE `Members` SET
                    `name`=:name,
                    `email`=:email,
                    `phone`=:phone,
                    `address`=:address,
                    `changeDatetime`=NOW()
                WHERE `id`=:id;");
            $sth->bindParam("id", $id);
            $sth->bindParam("name", $name);
            $sth->bindParam("email", $email);
            $sth->bindParam("phone", $phone);
            $sth->bindParam("address", $address);
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
            $sth = $dbh->prepare("UPDATE `Members` SET `password`=:password,`changeDatetime`=NOW()
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

    //更新狀態
    public function updateStatus($id, $status)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("UPDATE `Members` SET `status`=:status,`changeDatetime`=NOW()
                                   WHERE `id`=:id;");
            $sth->bindParam("id", $id);
            $sth->bindParam("status", $status, PDO::PARAM_BOOL);
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

    public function getOneMemberByAccount($account)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `id`, `account`, `name`, `email`, `phone`, `address`, `status`, `creationDatetime`, `changeDatetime` FROM `Members` WHERE `account`=:account;");
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

    public function getOneMemberByID($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `id`, `account`, `name`, `email`, `phone`, `address`, `status`, `creationDatetime`, `changeDatetime` FROM `Members` WHERE `id`=:id;");
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

    public function getALL()
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `id`, `account`, `name`, `email`, `phone`, `address`, `status`, `creationDatetime`, `changeDatetime` FROM `Members`;");
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
            $sth = $dbh->prepare("SELECT `id`, `account`, `name`, `email`,
            `phone`, `address`, `status`, `creationDatetime`, `changeDatetime`
            FROM `Members`
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
            $sth = $dbh->prepare("SELECT `id` FROM `Members` ORDER BY `id` DESC LIMIT 1;");
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
            $sth = $dbh->prepare("SELECT COUNT(`id`) AS `check`, `id` FROM `members` WHERE `account`=:account && `status`=TRUE;");
            $sth->bindParam("account", $account);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_ASSOC);
            if ($request['check'] != 1) {
                throw new Exception("帳號密碼錯誤");
            }

            $sth = $dbh->prepare("SELECT `password` FROM `members` WHERE `id`=:id");
            $sth->bindParam("id", $request['id']);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_NUM);
            $sth = null;
        } catch (Exception $err) {
            $dbh = null;
            throw new Exception("登入發生錯誤\r\n" . $err->getMessage());
        }
        $dbh = null;
        return password_verify($password, $request['0']);
    }

    public function checkAccountExist($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("SELECT COUNT(*) FROM `Members` WHERE `account` = :account;");
            $sth->bindParam("account", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_NUM);
        } catch (Exception $err) {
            $dbh = null;
            throw new Exception("確認帳號是否存在發生錯誤\r\n" . $err->getMessage());
        }
        return $request['0'] > 0;
    }
}
