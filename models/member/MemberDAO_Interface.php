<?php
interface MemberDAO
{
    public function insert($account, $password, $name, $email, $phone, $address = null);
    public function update($id, $name, $email, $phone, $status, $address = null);
    public function updatePassword($id, $password);
    public function getOneMemberByAccount($account);
    public function getOneMemberByID($id);
    public function getALL();
    public function doLogin($account, $password);
    public function checkMemberExist($id);
}
