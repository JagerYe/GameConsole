<?php
class EmployeeLoginStatus implements \JsonSerializable
{
    private $_loginID;
    private $_empID;
    private $_cookieID;
    private $_loginDate;
    private $_usageTime;
    private $_logoutDate;

    public function getLoginID()
    {
        return $this->_loginID;
    }
    public function setLoginID($loginID)
    {
        if (!preg_match("/\d/", $loginID)) {
            throw new Exception("LOGINID格式錯誤");
        }
        $this->_loginID = $loginID;
        return true;
    }

    public function getEmpID()
    {
        return $this->_empID;
    }
    public function setEmpID($empID)
    {
        if (!preg_match("/\d/", $empID)) {
            throw new Exception("會員ID格式錯誤");
        }
        $this->_empID = $empID;
        return true;
    }

    public function getCookieID()
    {
        return $this->_cookieID;
    }
    public function setCookieID($cookieID)
    {
        if (!preg_match("/\w+/", $cookieID)) {
            throw new Exception("CookieID格式錯誤");
        }
        $this->_cookieID = $cookieID;
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
