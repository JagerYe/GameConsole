<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/libs/Smarty.class.php";
class SmartyConfig
{
    public static function getSmarty()
    {
        $smarty = new Smarty();

        $smarty->setTemplateDir("{$_SERVER['DOCUMENT_ROOT']}/GameConsole/views/");
        $smarty->setCompileDir("{$_SERVER['DOCUMENT_ROOT']}/GameConsole/views/templates_c/");
        $smarty->setConfigDir("{$_SERVER['DOCUMENT_ROOT']}/GameConsole/views/configs/");
        $smarty->setCacheDir("{$_SERVER['DOCUMENT_ROOT']}/GameConsole/views/cache/");

        return $smarty;
    }
}
