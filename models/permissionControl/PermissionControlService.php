<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/permissionControl/PermissionControlDAO.php";
class PermissionControlService
{
    public static function getDAO()
    {
        return new PermissionControlDAO();
    }
}
