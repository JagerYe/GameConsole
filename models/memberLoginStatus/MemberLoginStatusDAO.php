<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/memberLoginStatus/MemberLoginStatusDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/config.php";
class MemberLoginStatusDAO implements MemberLoginStatusDAO_Interface
{
    //登入
    public function doLogin($memberID, $cookieID)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("INSERT INTO `MemberLoginStatus`(`memberID`, `cookieID`, `loginDate`, `usageTime`) VALUES (:memberID,:cookieID,NOW(),NOW());");
            $sth->bindParam("memberID", $memberID);
            $cookieID = password_hash($cookieID, PASSWORD_DEFAULT);
            $sth->bindParam("cookieID", $cookieID);
            $sth->execute();
            $dbh->commit();
            $id = $dbh->lastInsertId();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            return 0;
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
            $sth = $dbh->prepare("UPDATE `MemberLoginStatus` SET `logoutDate`=NOW() WHERE `loginID`=:loginID;");
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
    public function doLogoutByMemberID($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("UPDATE `MemberLoginStatus` SET `logoutDate`=NOW() WHERE `memberID`=:memberID;");
            $sth->bindParam("memberID", $id);
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
            $sth = $dbh->prepare("UPDATE `MemberLoginStatus` SET `usageTime`=NOW() WHERE `loginID`=:loginID;");
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
            $sth = $dbh->prepare("SELECT `loginID`, `memberID`, `cookieID`,
                    `loginDate`, `usageTime`, `logoutDate`,
                    (DATE_ADD(`usageTime`,INTERVAL 30 MINUTE) <= NOW()) AS `timeOut`
                FROM `MemberLoginStatus` WHERE
                `loginID`=:loginID && IF(`logoutDate`,FALSE,TRUE);");
            $sth->bindParam("loginID", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_ASSOC);
            if ($request['timeOut']) {
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
