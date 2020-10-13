<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/permissionControl/PermissionControlDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/config.php";
class PermissionControlDAO implements PermissionControlDAO_Interface
{
    //新增單一員工權限
    public function insertOneEmployeePermissions($empID, $insertList, $dbh = null)
    {
        $sqlStr = "INSERT INTO `PermissionControl`(`empID`, `permissionID`, `creationDatetime`) VALUES ";
        foreach ($insertList as $key => $permissionID) {
            $sqlStr .= "(:empID,:permissionID{$key},NOW()),";
        }
        unset($permissionID);
        // for ($i = 0; $i < count($insertList); $i++) {
        //     $sqlStr .= "(:empID,:permissionID{$i},NOW()),";
        // }
        $sqlStr = substr_replace($sqlStr, ';', -1, 1);
        try {
            $haveDbh = true;
            if ($dbh === null) {
                $haveDbh = false;
                $dbh = Config::getDBConnect();
                $dbh->beginTransaction();
            }

            $sth = $dbh->prepare($sqlStr);

            $sth->bindParam("empID", $empID);

            //那個該死的&才能正確指向值 
            foreach ($insertList as $key1 => &$value) {
                $sth->bindParam("permissionID{$key1}", $value);
            }
            unset($value);



            // for ($i = 0; $i < count($insertList); $i++) {

            //     $sth->bindParam("permissionID{$i}", $insertList[$i]);
            // }

            $sth->execute();
            $sth = null;
            if ($haveDbh === false) {
                $dbh->commit();
                $dbh = null;
            }
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            throw new Exception("新增發生錯誤\r\n" . $err->getMessage());
        }

        return true;
    }

    // //新增多位員工權限
    // public function insertSomeEmployeePermissions($empIDArr, $insertList)
    // {
    //     $sqlStr = "INSERT INTO `PermissionControl`(`empID`, `permissionID`, `creationDatetime`) VALUES ";
    //     foreach ($empIDArr as $key1 => $empID) {
    //         foreach ($insertList as $key2 => $permissionID) {
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
    //             foreach ($insertList as $key2 => $permissionID) {
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

    //更新
    public function update($empID, $deleteList, $insertList)
    {
        $sqlStr = "DELETE FROM `PermissionControl` WHERE `empID`=:empID && `empID`!=1 && (";
        $countRow = count($deleteList);
        for ($i = 0; $i < $countRow; $i++) {
            $sqlStr .= " `permissionID`=:permissionID{$i} ||";
        }
        $sqlStr = substr_replace($sqlStr, ');', -2, 2);
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();

            if ($countRow >= 1) {
                $sth = $dbh->prepare($sqlStr);
                $sth->bindParam("empID", $empID);
                for ($i = 0; $i < $countRow; $i++) {
                    $sth->bindParam("permissionID{$i}", $deleteList[$i]);
                }
                $sth->execute();
            }

            if (count($insertList) >= 1) {
                $this->insertOneEmployeePermissions($empID, $insertList, $dbh);
            }

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

    //刪除單位使用者部份功能
    public function delete($empID, $permissionID)
    {
        $sqlStr = "DELETE FROM `PermissionControl` WHERE `empID`=:empID && `empID`!=1 && (";
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
            $row = $sth->rowCount();
            $dbh->commit();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            throw new Exception("移除發生錯誤\r\n" . $err->getMessage());
        }
        $dbh = null;
        return $row >= 1;
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
            $sth = $dbh->prepare("SELECT `empID`, `permissionID`, pc.`creationDatetime`, `name` AS 'permissionName'
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
            $request = $sth->fetch(PDO::FETCH_NUM);
            $sth = null;
        } catch (PDOException $err) {
            $dbh = null;
            throw new Exception("取得資料發生錯誤\r\n" . $err->getMessage());
        }
        $dbh = null;
        $a = $request !== false;
        $b = $request[0] === '1';
        return $request !== false && $request[0] === '1';
    }
}
