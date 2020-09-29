<?php

class Controller
{

    public function requireDAO($dao)
    {
        require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/$dao/{$dao}Service.php";
        require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/$dao/$dao.php";
    }
}
