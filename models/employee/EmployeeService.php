<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/employee/EmployeeDAO.php";
class EmployeeService
{
    public static function getDAO()
    {
        return new EmployeeDAO();
    }
}
