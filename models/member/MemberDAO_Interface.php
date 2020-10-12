<?php
interface MemberDAO_Interface
{
    public function insert($account, $password, $name, $email, $phone, $address = null);
    public function update($id, $name, $email, $phone, $address = null);
    public function updatePassword($id, $password);
    public function getOneMemberByAccount($account);
    public function getOneMemberByID($id);
    public function getALL();
    public function doLogin($account, $password);
    public function checkAccountExist($id);
}
