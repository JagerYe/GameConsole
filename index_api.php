<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/core/api.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/core/Controller.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/core/smartyConfig.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/core/Result.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/core/Rule.php";

try {
    $api = new Api();
} catch (Exception $err) {
    echo $err->getMessage();
}
