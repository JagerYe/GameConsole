<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/employeeLoginStatus/EmployeeLoginStatusDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/config.php";
class EmployeeLoginStatusDAO implements EmployeeLoginStatusDAO_Interface
{
    //登入
    public function insert($empID, $saveTime, $isKeep)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("INSERT INTO `EmployeeLoginStatus`(`empID`, `isKeep`, `loginDatetime`, `usageDatetime`) VALUES (:empID,:isKeep,NOW(),NOW());");

            $sth->bindParam("empID", $empID);
            $sth->bindParam("isKeep", $isKeep, PDO::PARAM_BOOL);
            $sth->execute();
            $id = $dbh->lastInsertId();

            $cookieID = hash('sha256', $id); //給使用者
            $updateCookieID = password_hash($cookieID, PASSWORD_DEFAULT); //存放DB

            $sth = $dbh->prepare("UPDATE `EmployeeLoginStatus` SET `cookieID`=:cookieID WHERE `loginID`=:loginID;");
            $sth->bindParam("loginID", $id);
            $sth->bindParam("cookieID", $updateCookieID);
            $sth->execute();
            $dbh->commit();
            setcookie('cookieID', $cookieID, $saveTime, "/");
            setcookie('loginID', $id, $saveTime, "/");

            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            throw new Exception("登入發生錯誤\r\n" . $err->getMessage());
        }
        $dbh = null;
        return true;
    }

    //登出
    public function setLogoutByID($id, $dbh = null)
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
            throw new Exception("登出發生錯誤\r\n" . $err->getMessage());
        }
        $dbh = null;
        return true;
    }

    //登出使用者所有裝置
    public function setLogoutByEmpID($id)
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
            throw new Exception("登出發生錯誤\r\n" . $err->getMessage());
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
            $sth = $dbh->prepare("UPDATE `EmployeeLoginStatus` SET `usageDatetime`=NOW() WHERE `loginID`=:loginID;");
            $sth->bindParam("loginID", $id);
            $sth->execute();
            $dbh->commit();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            throw new Exception("更新時間發生錯誤\r\n" . $err->getMessage());
        }
        $dbh = null;
        return true;
    }

    //登入狀態
    public function checkIsLogin($id, $cookieID)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `loginID`, `empID`, `cookieID`,
                `loginDatetime`, `usageDatetime`, `logoutDatetime`,
                (DATE_ADD(`usageDatetime`,INTERVAL 30 MINUTE) <= NOW()) AS `timeOut`
                FROM `EmployeeLoginStatus` WHERE
                `loginID`=:loginID && IF(`logoutDatetime`,FALSE,TRUE);");
            $sth->bindParam("loginID", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_ASSOC);
            if($request===false){
                throw new Exception("尚未登入");
            }
            if ($request['timeOut']) {
                $this->setLogoutByID($id, $dbh);
                throw new Exception("超過時間");
            }
            $sth = null;
        } catch (PDOException $err) {
            $dbh = null;
            throw new Exception("確認狀態發生錯誤\r\n" . $err->getMessage());
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
        $dbh = null;
        return password_verify($cookieID, $request['cookieID']);
    }
}
