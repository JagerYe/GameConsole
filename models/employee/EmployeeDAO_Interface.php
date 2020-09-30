<?php
interface EmployeeDAO_Interface
{
    public function insert($account, $password, $name, $email);
    public function update($id, $name, $email);
    public function updatePassword($id, $password);
    public function getOneEmployeeByAccount($account);
    public function getOneEmployeeByID($id);
    public function getAll();
    public function doLogin($account, $password);
    public function checkAccountExist($id);
}
