<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/order/OrderDAO.php";
class OrderService
{
    public static function getDAO()
    {
        return new OrderDAO();
    }
}
