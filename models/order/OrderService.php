<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/order/OrderDAO_PDO.php";
class OrderService
{
    public static function getDAO()
    {
        return new OrderDAO_PDO();
    }
}
