<?php
class Order implements \JsonSerializable
{
    private $_orderID;
    private $_memberID;
    private $_address;
    private $_creationDate;
    private $_changeDate;

    public function getOrderID()
    {
        return $this->_orderID;
    }
    public function setOrderID($orderID)
    {
        if (!preg_match("/\d/", $orderID)) {
            throw new Exception("ORDER ID 格式錯誤");
        }
        $this->_orderID = $orderID;
        return true;
    }

    public function getMemberID()
    {
        return $this->_memberID;
    }
    public function setMemberID($memberID)
    {
        if (!preg_match("/\d/", $memberID)) {
            throw new Exception("會員ID格式錯誤");
        }
        $this->_memberID = $memberID;
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
