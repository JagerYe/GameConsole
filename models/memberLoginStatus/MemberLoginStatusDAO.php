<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/memberLoginStatus/MemberLoginStatusDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/config.php";
class MemberLoginStatusDAO implements MemberLoginStatusDAO_Interface
{
    //登入
    public function insert($memberID, $saveTime, $isKeep)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare(
                "INSERT INTO `MemberLoginStatus`(`memberID`,`isKeep`,`loginDatetime`,`usageDatetime`)
                VALUES (:memberID,:isKeep,NOW(),NOW());"
            );

            $sth->bindParam("memberID", $memberID);
            $sth->bindParam("isKeep", $isKeep, PDO::PARAM_BOOL);
            $sth->execute();
            $id = $dbh->lastInsertId();

            $cookieID = hash('sha256', $id); //給使用者
            $updateCookieID = password_hash($cookieID, PASSWORD_DEFAULT); //存放DB

            $sth = $dbh->prepare("UPDATE `MemberLoginStatus` SET `cookieID`=:cookieID WHERE `loginID`=:loginID;");
            $sth->bindParam("loginID", $id);
            $sth->bindParam("cookieID", $updateCookieID);
            $sth->execute();
            $dbh->commit();
            setcookie('memCookieID', $cookieID, $saveTime, "/");
            setcookie('memLoginID', $id, $saveTime, "/");

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
            $sth = $dbh->prepare("UPDATE `MemberLoginStatus` SET `logoutDatetime`=NOW() WHERE `loginID`=:loginID;");
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
    public function setLogoutByMemberID($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("UPDATE `MemberLoginStatus` SET `logoutDatetime`=NOW() WHERE `memberID`=:memberID;");
            $sth->bindParam("memberID", $id);
            $sth->execute();
            $dbh->commit();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            throw new Exception("登出所有發生錯誤\r\n" . $err->getMessage());
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
            $sth = $dbh->prepare("UPDATE `MemberLoginStatus` SET `usageDatetime`=NOW() WHERE `loginID`=:loginID;");
            $sth->bindParam("loginID", $id);
            $sth->execute();
            $dbh->commit();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            throw new Exception("更新最後使用時間發生錯誤\r\n" . $err->getMessage());
        }
        $dbh = null;
        return true;
    }

    //登入狀態
    public function getLoginData($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `loginID`, `memberID`, `cookieID`,
                    `loginDatetime`, `usageDatetime`, `logoutDatetime`, `isKeep`,
                    (DATE_ADD(`usageDatetime`,INTERVAL 30 MINUTE) <= NOW()) AS `timeOut`
                FROM `MemberLoginStatus` WHERE
                `loginID`=:loginID && IF(`logoutDatetime`,FALSE,TRUE);");
            $sth->bindParam("loginID", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            $dbh = null;
            throw new Exception("確認登入狀態發生錯誤\r\n" . $err->getMessage());
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
        $dbh = null;
        return $request;
    }
}
