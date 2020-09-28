<?php
class Commodity implements \JsonSerializable
{
    private $_id;
    private $_price;
    private $_quantity;
    private $_name;
    private $_status;
    private $_creationDatetime;
    private $_changeDatetime;

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

    public function getPrice()
    {
        return $this->_price;
    }
    public function setPrice($price)
    {
        if (!preg_match("/\d/", $price)) {
            throw new Exception("價格格式錯誤");
        }
        $this->_price = $price;
        return true;
    }

    public function getQuantity()
    {
        return $this->_quantity;
    }
    public function setQuantity($quantity)
    {
        if (!preg_match("/\d/", $quantity)) {
            throw new Exception("數量格式錯誤");
        }
        $this->_quantity = $quantity;
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

    public function getStatus()
    {
        return $this->_status;
    }
    public function setStatus($status)
    {
        if (!is_bool($status)) {
            throw new Exception("狀態格式錯誤");
        }
        $this->_status = $status;
        return true;
    }

    public function getCreationDatetime()
    {
        return $this->_creationDatetime;
    }
    public function setCreationDatetime($creationDatetime)
    {
        $this->_creationDatetime = $creationDatetime;
        return true;
    }

    public function getChangeDatetime()
    {
        return $this->_changeDatetime;
    }
    public function setChangeDatetime($changeDatetime)
    {
        $this->_changeDatetime = $changeDatetime;
        return true;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}
