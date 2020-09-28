<?php
interface MemberLoginStatusDAO
{
    public function doLogin($memberID, $cookieID, $keepLoggedIn = false);
    public function doLogoutByID($id, $dbh = null);
    public function doLogoutByMemberID($id);
    public function updateUsingByID($id);
    public function checkIsLogin($id, $cookieID);
}
