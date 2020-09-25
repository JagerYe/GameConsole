<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/libs/Smarty.class.php";
class SmartyConfig
{
    public static function getSmarty()
    {
        $smarty = new Smarty();

        $smarty->setTemplateDir("{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/views/pageFront/");
        $smarty->setCompileDir("{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/views/templates_c/");
        $smarty->setConfigDir("{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/views/configs/");
        $smarty->setCacheDir("{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/views/cache/");

        return $smarty;
    }
}
