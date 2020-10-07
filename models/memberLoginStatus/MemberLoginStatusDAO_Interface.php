<?php
interface MemberLoginStatusDAO_Interface
{
    public function insert($memberID, $saveTime, $isKeep);
    public function setLogoutByID($id, $dbh = null);
    public function setLogoutByMemberID($id);
    public function updateUsingByID($id);
    public function getLoginData($id);
}
