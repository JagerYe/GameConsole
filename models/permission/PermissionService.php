<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/permission/PermissionDAO.php";
class PermissionService
{
    public static function getDAO()
    {
        return new PermissionDAO();
    }
}
