<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/employeeLoginStatus/EmployeeLoginStatusDAO_PDO.php";
class EmployeeLoginStatusService
{
    public static function getDAO()
    {
        return new EmployeeLoginStatusDAO_PDO();
    }
}
