<?php
interface MemberLoginStatusDAO_Interface
{
    public function insert($memberID, $isKeep = 1);
    public function setLogoutByID($id, $dbh = null);
    public function setLogoutByMemberID($id);
    public function updateUsingByID($id);
    public function checkIsLogin($id, $cookieID);
}
