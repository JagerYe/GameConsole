<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/memberLoginStatus/MemberLoginStatusDAO_PDO.php";
class MemberLoginStatusService
{
    public static function getDAO()
    {
        return new MemberLoginStatusDAO_PDO();
    }
}
