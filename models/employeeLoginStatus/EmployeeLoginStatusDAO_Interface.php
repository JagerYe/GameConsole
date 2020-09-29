<?php
interface EmployeeLoginStatusDAO_Interface
{
    public function insert($empID);
    public function deleteByID($id, $dbh = null);
    public function deleteByEmpID($id);
    public function updateUsingByID($id);
    public function checkIsLogin($id, $cookieID);
}
