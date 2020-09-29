<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/permission/PermissionDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/config.php";
class PermissionDAO implements PermissionDAO_Interface
{

    public function getALL()
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT * FROM `Permissions`;");
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
