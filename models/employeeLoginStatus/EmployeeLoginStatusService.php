<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/employeeLoginStatus/EmployeeLoginStatusDAO.php";
class EmployeeLoginStatusService
{
    public static function getDAO()
    {
        return new EmployeeLoginStatusDAO();
    }
}
