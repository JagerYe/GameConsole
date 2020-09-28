<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/member/MemberDAO_PDO.php";
class MemberService
{
    public static function getDAO()
    {
        return new MemberDAO_PDO();
    }
}
