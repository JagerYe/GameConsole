<?php
interface OrderDAO_Interface
{
    public function insert($memberID, $address, $orderDetails);
    public function getSomeByMemberID($memberID, $orderID = null);
}
