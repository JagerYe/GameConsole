<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/permissionControl/PermissionControlDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/config.php";
class PermissionControlDAO implements PermissionControlDAO_Interface
{
    //新增單一員工權限
    public function insertOneEmployeePermissions($empID, $permissionIDArr)
    {
        $sqlStr = "INSERT INTO `PermissionControl`(`empID`, `permissionID`, `creationDatetime`) VALUES ";
        // foreach ($permissionIDArr as $key => $permissionID) {
        //     $sqlStr .= "(:empID,:permission{$key},NOW()),";
        // }
        for ($i = 0; $i < count($permissionIDArr); $i++) {
            $sqlStr .= "(:empID,:permission{$i},NOW()),";
        }
        $sqlStr = substr_replace($sqlStr, ';', -1, 1);
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare($sqlStr);

            $sth->bindParam("empID", $empID);
            // foreach ($permissionIDArr as $key1 => $value) {

            //     $sth->bindParam("permission{$key1}", $value);
            // }



            for ($i = 0; $i < count($permissionIDArr); $i++) {

                $sth->bindParam("permission{$i}", $permissionIDArr[$i]);
            }

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

    // //新增多位員工權限
    // public function insertSomeEmployeePermissions($empIDArr, $permissionIDArr)
    // {
    //     $sqlStr = "INSERT INTO `PermissionControl`(`empID`, `permissionID`, `creationDatetime`) VALUES ";
    //     foreach ($empIDArr as $key1 => $empID) {
    //         foreach ($permissionIDArr as $key2 => $permissionID) {
    //             $sqlStr .= "(:empID{$key1},:permissionID{$key1}_{$key2},NOW()),";
    //         }
    //     }
    //     substr_replace($sqlStr, ';', -1, 1);
    //     try {
    //         $dbh = Config::getDBConnect();
    //         $dbh->beginTransaction();
    //         $sth = $dbh->prepare($sqlStr);
    //         foreach ($empIDArr as $key1 => $empID) {
    //             $sth->bindParam("empID{$key1}", $empID);
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

    //刪除單位使用者部份功能
    public function delete($empID, $permissionID)
    {
        $sqlStr = "DELETE FROM `PermissionControl` WHERE `empID`=:empID && (";
        for ($i = 0; $i < count($permissionID); $i++) {
            $sqlStr .= " `permissionID`=:permissionID{$i} ||";
        }
        $sqlStr = substr_replace($sqlStr, ');', -2, 2);
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare($sqlStr);
            $sth->bindParam("empID", $empID);
            for ($i = 0; $i < count($permissionID); $i++) {
                $sth->bindParam("permissionID{$i}", $permissionID[$i]);
            }
            $sth->execute();
            $dbh->commit();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            throw new Exception("移除發生錯誤\r\n" . $err->getMessage());
        }
        $dbh = null;
        return true;
    }

    //刪除單一使用者所有權限，離職時使用
    public function deleteByEmpID($empID)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("DELETE FROM `PermissionControl` WHERE `empID`=:empID;");
            $sth->bindParam("empID", $empID);
            $sth->bindParam("permissionID", $permissionID);
            $sth->execute();
            $dbh->commit();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            throw new Exception("移除發生錯誤\r\n" . $err->getMessage());
        }
        $dbh = null;
        return true;
    }

    //取得5位員工權限清單，startID為上次最後讀取到的empID
    public function getSome($startID = null)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `empID`, `permissionID`, pc.`creationDatetime`, `name` AS 'permissionName'
                FROM `PermissionControl` AS pc
                INNER JOIN `Permissions` AS p ON p.id=pc.permissionID
                WHERE `empID`>IFNULL(:empID, -1) ORDER BY `empID` LIMIT 5;");
            $sth->bindParam("empID", $startID);
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

    //取得一位員工權限清單
    public function getOneByID($empID)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `empID`, `permissionID`, pc.`creationDatetime`,
                `name` AS 'permissionName', `funtionName`
                FROM `PermissionControl` AS pc
                INNER JOIN `Permissions` AS p ON p.id=pc.permissionID
                WHERE `empID`=:empID;");
            $sth->bindParam("empID", $empID);
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

    //確認權限
    public function checkHavePermissionByEmpID($empID, $permissionID)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT COUNT(*) FROM `PermissionControl`
                WHERE `empID`=:empID && `permissionID`=:permissionID;");
            $sth->bindParam("empID", $empID);
            $sth->bindParam("permissionID", $permissionID);
            $sth->execute();
            $request = $sth->fetchAll(PDO::FETCH_NUM);
            $sth = null;
        } catch (PDOException $err) {
            $dbh = null;
            throw new Exception("取得資料發生錯誤\r\n" . $err->getMessage());
        }
        $dbh = null;
        return $request !== false && (int)$request['0'] === 1;
    }
}
