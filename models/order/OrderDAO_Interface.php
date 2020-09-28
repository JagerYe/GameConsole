<?php
interface OrderDAO
{
    public function insert($memberID, $address, $orderDetails);
    public function getSomeByMemberID($memberID, $orderID = null);
}
