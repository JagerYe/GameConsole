<?php
class EmployeeLoginStatus implements \JsonSerializable
{
    private $_loginid;
    private $_employeeid;
    private $_cookieid;
    private $_keepLoggedIn;
    private $_loginDate;
    private $_usageTime;
    private $_logoutDate;

    public function getLoginID()
    {
        return $this->_loginid;
    }
    public function setLoginID($loginid)
    {
        if (!preg_match("/\d/", $loginid)) {
            throw new Exception("LOGINID格式錯誤");
        }
        $this->_loginid = $loginid;
        return true;
    }

    public function getEmployeeID()
    {
        return $this->_employeeid;
    }
    public function setEmployeeID($employeeid)
    {
        if (!preg_match("/\d/", $employeeid)) {
            throw new Exception("會員ID格式錯誤");
        }
        $this->_employeeid = $employeeid;
        return true;
    }

    public function getCookieID()
    {
        return $this->_cookieid;
    }
    public function setCookieID($cookieid)
    {
        if (!preg_match("/\w+/", $cookieid)) {
            throw new Exception("CookieID格式錯誤");
        }
        $this->_cookieid = $cookieid;
        return true;
    }

    public function getKeepLoggedIn()
    {
        return $this->_keepLoggedIn;
    }
    public function setKeepLoggedIn($keepLoggedIn)
    {
        if (!is_bool($keepLoggedIn)) {
            throw new Exception("保持登入格式錯誤");
        }
        $this->_keepLoggedIn = $keepLoggedIn;
        return true;
    }

    public function getLoginDate()
    {
        return $this->_loginDate;
    }
    public function setLoginDate($loginDate)
    {
        $this->_loginDate = $loginDate;
        return true;
    }

    public function getUsageTime()
    {
        return $this->_usageTime;
    }
    public function setUsageTime($usageTime)
    {
        $this->_usageTime = $usageTime;
        return true;
    }

    public function getLogoutDate()
    {
        return $this->_logoutDate;
    }
    public function setLogoutDate($logoutDate)
    {
        $this->_logoutDate = $logoutDate;
        return true;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}
