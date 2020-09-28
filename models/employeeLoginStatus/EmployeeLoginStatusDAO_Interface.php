<?php
interface EmployeeLoginStatusDAO_Interface
{
    public function doLogin($employeeID , $cookieID, $keepLoggedIn = false);
    public function doLogoutByID($id, $dbh = null);
    public function doLogoutByEmployeeID ($id);
    public function updateUsingByID($id);
    public function checkIsLogin($id, $cookieID);
}
