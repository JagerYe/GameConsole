<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/permission/PermissionDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/config.php";
class PermissionDAO implements PermissionDAO_Interface
{

    public function getAll()
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT * FROM `Permissions`;");
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

}
