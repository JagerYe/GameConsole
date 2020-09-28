<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/commodity/CommodityDAO_PDO.php";
class CommodityService
{
    public static function getDAO()
    {
        return new CommodityDAO_PDO();
    }
}
