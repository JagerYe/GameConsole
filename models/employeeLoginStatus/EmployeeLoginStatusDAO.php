<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/employeeLoginStatus/EmployeeLoginStatusDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/config.php";
class EmployeeLoginStatusDAO implements EmployeeLoginStatusDAO_Interface
{
    //登入
    public function insert($empID)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("INSERT INTO `EmployeeLoginStatus`(`empID`, `loginDatetime`, `usageDatetime`)
                VALUES (:empID,NOW(),NOW())");

            $sth->bindParam("empID ", $empID);
            $sth->execute();
            $id = $dbh->lastInsertId();

            $cookieID = hash('sha256', $id); //給使用者
            $updateCookieID = password_hash($cookieID, PASSWORD_DEFAULT); //存放DB

            $sth = $dbh->prepare("UPDATE `EmployeeLoginStatus` SET `cookieID`=:cookieID WHERE `loginID`=:loginID;");
            $sth->bindParam("loginID", $id);
            $sth->bindParam("cookieID", $updateCookieID);
            $sth->execute();
            $dbh->commit();
            $id = $dbh->lastInsertId();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            return "";
        }
        $dbh = null;
        return $cookieID;
    }

    //登出
    public function deleteByID($id, $dbh = null)
    {
        try {
            if ($dbh === null) {
                $dbh = Config::getDBConnect();
            }
            $dbh->beginTransaction();
            $sth = $dbh->prepare("UPDATE `EmployeeLoginStatus` SET `logoutDatetime`=NOW() WHERE `loginID`=:loginID;");
            $sth->bindParam("loginID", $id);
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

    //登出使用者所有裝置
    public function deleteByEmpID($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("UPDATE `EmployeeLoginStatus` SET `logoutDatetime`=NOW() WHERE `empID `=:empID;");
            $sth->bindParam("empID", $id);
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

    //更新最後使用時間
    public function updateUsingByID($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("UPDATE `EmployeeLoginStatus` SET `usageTime`=NOW() WHERE `loginID`=:loginID;");
            $sth->bindParam("loginID", $id);
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

    //登入狀態
    public function checkIsLogin($id, $cookieID)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `loginID`, `empID `, `cookieID`,
                    `loginDatetime`, `usageTime`, `logoutDatetime`,
                    (DATE_ADD(`usageTime`,INTERVAL 30 MINUTE) <= NOW()) AS `timeOut`
                FROM `EmployeeLoginStatus` WHERE
                `loginID`=:loginID && IF(`logoutDatetime`,FALSE,TRUE);");
            $sth->bindParam("loginID", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_ASSOC);
            if ($request['timeOut']) {
                $this->deleteByID($id, $dbh);
                throw new Exception("超過時間");
            }
            $sth = null;
        } catch (PDOException $err) {
            $dbh = null;
            return false;
        } catch (Exception $err) {
            return false;
        }
        $dbh = null;
        return password_verify($cookieID, $request['cookieID']);
    }
}
