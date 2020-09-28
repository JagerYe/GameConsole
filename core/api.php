<?php

class Api
{
    public function __construct()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $url = rtrim($_GET["url"], "/");
        $url = explode("/", $url);
        $controllerName = "{$url[0]}Controller";
        if (!file_exists("{$_SERVER['DOCUMENT_ROOT']}/GameConsole/controllers/$controllerName.php")) {
            $controllerName = 'IndexController';
            $url[1] = 'getIndexView';
        }
        require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/controllers/$controllerName.php";
        $controller = new $controllerName;
        $methodName = isset($url[1]) ? $url[1] : "getIndexView";
        if (!method_exists($controller, $methodName)) {
            return;
        }
        switch ($requestMethod) {
            case 'GET':
                $values = array_values($_GET);
                unset($values[0]);
                break;
            case 'POST':
                $values = array_values($_POST);
                break;
            case 'PUT':
            case 'DELETE':
                parse_str(file_get_contents('php://input'), $values);
                break;
        }
        $values[] = $requestMethod;

        if (isset($_FILES['img'])) {
            $filePath = $_FILES['img']['tmp_name'];
            $fileNewPath = substr($filePath, 0, strrpos($filePath, '/') + 1) . $_FILES['img']['name'];
            move_uploaded_file($filePath, $fileNewPath);
            $values[] = $fileNewPath;
            $values[] = $_FILES['img']['type'];
        }

        echo call_user_func_array(array($controller, $methodName), $values);
    }
}
