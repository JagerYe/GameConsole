<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/permissionControl/PermissionControlDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/config.php";
class PermissionControlDAO implements PermissionControlDAO_Interface
{
    //新增單一員工權限
    public function insertOneEmployeePermissions($employeeID, $permissionIDArr)
    {
        $sqlStr = "INSERT INTO `PermissionControl`(`employeeID`, `permissionID`, `creationDatetime`) VALUES ";
        foreach ($permissionIDArr as $key => $permissionID) {
            $sqlStr .= "(:employeeID,:permissionID{$key},NOW()),";
        }
        substr_replace($sqlStr, ';', -1, 1);
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare($sqlStr);
            $sth->bindParam("employeeID", $employeeID);
            foreach ($permissionIDArr as $key => $permissionID) {
                $sth->bindParam("permissionID{$key}", $permissionID);
            }
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

    // //新增多位員工權限
    // public function insertSomeEmployeePermissions($employeeIDArr, $permissionIDArr)
    // {
    //     $sqlStr = "INSERT INTO `PermissionControl`(`employeeID`, `permissionID`, `creationDatetime`) VALUES ";
    //     foreach ($employeeIDArr as $key1 => $employeeID) {
    //         foreach ($permissionIDArr as $key2 => $permissionID) {
    //             $sqlStr .= "(:employeeID{$key1},:permissionID{$key1}_{$key2},NOW()),";
    //         }
    //     }
    //     substr_replace($sqlStr, ';', -1, 1);
    //     try {
    //         $dbh = Config::getDBConnect();
    //         $dbh->beginTransaction();
    //         $sth = $dbh->prepare($sqlStr);
    //         foreach ($employeeIDArr as $key1 => $employeeID) {
    //             $sth->bindParam("employeeID{$key1}", $employeeID);
    //             foreach ($permissionIDArr as $key2 => $permissionID) {
    //                 $sth->bindParam("permissionID{$key1}_{$key2}", $permissionID);
    //             }
    //         }

    //         $sth->execute();
    //         $dbh->commit();
    //         $sth = null;
    //     } catch (PDOException $err) {
    //         $dbh->rollBack();
    //         $dbh = null;
    //         return false;
    //     }
    //     $dbh = null;
    //     return true;
    // }

    //刪除
    public function delete($employeeID, $permissionID)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("DELETE FROM `PermissionControl` WHERE `employeeID`=:employeeID && `permissionID`=:permissionID;"
            );
            $sth->bindParam("employeeID", $employeeID);
            $sth->bindParam("permissionID", $permissionID);
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

    //刪除
    public function deleteByEmployeeID($employeeID)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("DELETE FROM `PermissionControl` WHERE `employeeID`=:employeeID;"
            );
            $sth->bindParam("employeeID", $employeeID);
            $sth->bindParam("permissionID", $permissionID);
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

    //取得5位員工權限清單，startID為上次最後讀取到的employeeID
    public function getSome($startID = null)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `employeeID`, `permissionID`, pc.`creationDatetime`, `name` AS 'permissionName'
                FROM `PermissionControl` AS pc
                INNER JOIN `Permissions` AS p ON p.id=pc.permissionID
                WHERE `employeeID`>IFNULL(:employeeID, -1) ORDER BY `employeeID` LIMIT 5;"
            );
            $sth->bindParam("employeeID", $startID);
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

    //取得一位員工權限清單
    public function getOneByID($employeeID)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `employeeID`, `permissionID`, pc.`creationDatetime`, `name` AS 'permissionName'
                FROM `PermissionControl` AS pc
                INNER JOIN `Permissions` AS p ON p.id=pc.permissionID
                WHERE `employeeID`=:employeeID;"
            );
            $sth->bindParam("employeeID", $employeeID);
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
}
