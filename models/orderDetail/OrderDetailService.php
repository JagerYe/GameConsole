<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/orderdetail/OrderDetailDAO.php";
class OrderDetailService
{
    public static function getDAO()
    {
        return new OrderDetailDAO();
    }
}
