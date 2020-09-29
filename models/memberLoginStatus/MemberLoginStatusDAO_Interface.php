<?php
interface MemberLoginStatusDAO_Interface
{
    public function doLogin($memberID, $cookieID);
    public function doLogoutByID($id, $dbh = null);
    public function doLogoutByMemberID($id);
    public function updateUsingByID($id);
    public function checkIsLogin($id, $cookieID);
}
