<?php
class OrderDetail implements \JsonSerializable
{
    private $_orderID;
    private $_commodityID;
    private $_price;
    private $_quantity;
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

    public function getCommodityID()
    {
        return $this->_commodityID;
    }
    public function setCommodityID($commodityID)
    {
        if (!preg_match("/\d/", $commodityID)) {
            throw new Exception("商品ID格式錯誤");
        }
        $this->_commodityID = $commodityID;
        return true;
    }

    public function getPrice()
    {
        return $this->_price;
    }
    public function setPrice($price)
    {
        if (!preg_match("/\d/", $price) || $price < 0) {
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
        if (!preg_match("/\d/", $quantity) || $quantity <= 0) {
            throw new Exception("數量格式錯誤");
        }
        $this->_quantity = $quantity;
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
