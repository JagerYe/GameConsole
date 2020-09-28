<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/employeeLoginStatus/EmployeeLoginStatusDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/config.php";
class EmployeeLoginStatusDAO_PDO implements EmployeeLoginStatusDAO
{
    //登入
    public function doLogin($employeeID , $cookieID, $keepLoggedIn = false)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("INSERT INTO `EmployeeLoginStatus`(`employeeID `, `cookieID`, `keepLoggedIn`, `loginDate`, `usageTime`) VALUES (:employeeID ,:cookieID,:keepLoggedIn,NOW(),NOW());");
            $sth->bindParam("employeeID ", $employeeID );
            $cookieID = password_hash($cookieID, PASSWORD_DEFAULT);
            $sth->bindParam("cookieID", $cookieID);
            $sth->bindParam("keepLoggedIn", $keepLoggedIn);
            $sth->execute();
            $dbh->commit();
            $id = $dbh->lastInsertId();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            return -1;
        }
        $dbh = null;
        return $id;
    }

    //登出
    public function doLogoutByID($id, $dbh = null)
    {
        try {
            if ($dbh === null) {
                $dbh = Config::getDBConnect();
            }
            $dbh->beginTransaction();
            $sth = $dbh->prepare("UPDATE `EmployeeLoginStatus` SET `logoutDate`=NOW() WHERE `loginID`=:loginID;"
            );
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
    public function doLogoutByEmployeeID ($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("UPDATE `EmployeeLoginStatus` SET `logoutDate`=NOW() WHERE `employeeID `=:employeeID;"
            );
            $sth->bindParam("employeeID", $id);
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
            $sth = $dbh->prepare("SELECT `loginID`, `employeeID `, `cookieID`,
                    `keepLoggedIn`, `loginDate`, `usageTime`,
                    `logoutDate`, (DATE_ADD(`usageTime`,INTERVAL 30 MINUTE) <= NOW()) AS `timeOut`
                FROM `EmployeeLoginStatus` WHERE
                `loginID`=:loginID && IF(`logoutDate`,FALSE,TRUE);"
            );
            $sth->bindParam("loginID", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_ASSOC);
            if (!$request['keepLoggedIn'] && $request['timeOut']) {
                $this->doLogoutByID($id, $dbh);
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
