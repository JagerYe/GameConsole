<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/memberLoginStatus/MemberLoginStatusDAO.php";
class MemberLoginStatusService
{
    public static function getDAO()
    {
        return new MemberLoginStatusDAO();
    }
}
