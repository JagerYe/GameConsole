<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/member/MemberDAO.php";
class MemberService
{
    public static function getDAO()
    {
        return new MemberDAO();
    }
}
