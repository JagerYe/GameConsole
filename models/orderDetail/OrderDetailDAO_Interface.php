<?php
interface OrderDetailDAO_Interface
{
    public function insert($orderID, $orderDetails, $dbh);
    public function getSomeByOrderID($orderID, $commodityID);
}
