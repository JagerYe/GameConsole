<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/commodities/CommoditiesDAO_PDO.php";
class CommoditiesService
{
    public static function getDAO()
    {
        return new CommoditiesDAO_PDO();
    }
}
