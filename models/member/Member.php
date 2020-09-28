<?php
class Member implements \JsonSerializable
{
    private $_memberID;
    private $_account;
    private $_password;
    private $_name;
    private $_email;
    private $_phone;
    private $_address;
    private $_creationDate;
    private $_changeDate;
    private $_emailRule = "/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/";

    public function getMemberID()
    {
        return $this->_memberID;
    }
    public function setMemberID($memberID)
    {
        if (!preg_match("/\d/", $memberID)) {
            throw new Exception("ID格式錯誤");
        }
        $this->_memberID = $memberID;
        return true;
    }

    public function getAccount()
    {
        return $this->_account;
    }
    public function setAccount($account)
    {
        if (!preg_match("/\w{6,20}/", $account)) {
            throw new Exception("帳號格式錯誤");
        }
        $this->_account = $account;
        return true;
    }

    public function getPassword()
    {
        return $this->_password;
    }
    public function setPassword($password)
    {
        if (!preg_match("/\w{6,20}/", $password)) {
            throw new Exception("密碼格式錯誤");
        }
        $this->_password = $password;
        return true;
    }

    public function getName()
    {
        return $this->_name;
    }
    public function setName($name)
    {
        if (strlen(trim($name)) <= 0) {
            throw new Exception("名字格式錯誤");
        }
        $this->_name = $name;
        return true;
    }

    public function getEmail()
    {
        return $this->_email;
    }
    public function setEmail($email)
    {

        if (!preg_match($this->_emailRule, $email)) {
            throw new Exception("email格式錯誤");
        }
        $this->_email = $email;
        return true;
    }

    public function getPhone()
    {
        return $this->_phone;
    }
    public function setPhone($phone)
    {
        if (!preg_match("/\d{10}/", $phone)) {
            throw new Exception("電話錯誤");
        }
        $this->_phone = $phone;
        return true;
    }

    public function getAddress()
    {
        return $this->_address;
    }
    public function setAddress($address)
    {
        if (strlen(trim($address)) <= 0) {
            throw new Exception("地址格式錯誤");
        }
        $this->_address = $address;
        return true;
    }

    public function getCreationDate()
    {
        return $this->_creationDate;
    }
    public function setCreationDate($creationDate)
    {
        $this->_creationDate = $creationDate;
        return true;
    }

    public function getChangeDate()
    {
        return $this->_changeDate;
    }
    public function setChangeDate($changeDate)
    {
        $this->_changeDate = $changeDate;
        return true;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}
