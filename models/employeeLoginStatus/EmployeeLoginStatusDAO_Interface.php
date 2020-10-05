<?php
interface EmployeeLoginStatusDAO_Interface
{
    public function insert($empID, $saveTime, $isKeep);
    public function setLogoutByID($id, $dbh = null);
    public function setLogoutByEmpID($id);
    public function updateUsingByID($id);
    public function getLoginData($id);
}
