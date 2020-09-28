<?php
class Employee implements \JsonSerializable
{
    private $_id;
    private $_account;
    private $_password;
    private $_name;
    private $_email;
    private $_creationDate;
    private $_changeDate;
    private $_emailRule = "/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/";

    public function getId()
    {
        return $this->_id;
    }
    public function setId($id)
    {
        if (!preg_match("/\d/", $id)) {
            throw new Exception("ID格式錯誤");
        }
        $this->_id = $id;
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
