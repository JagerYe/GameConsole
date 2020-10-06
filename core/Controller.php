<?php

class Controller
{

    public function requireDAO($dao)
    {
        require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/$dao/{$dao}Service.php";
        require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/$dao/$dao.php";
    }

    public function smartyAssignPermission($permissions, $smarty, $seeFuntion = null)
    {
        $reply = false;
        foreach ($permissions as $permission) {
            switch ($permission['permissionID']) {
                case '1':
                    $smarty->assign('empSee', true);
                    if ($seeFuntion === 1) {
                        $reply = true;
                    }
                    break;
                case '2':
                    $smarty->assign('empUse', true);
                    break;
                case '3':
                    $smarty->assign('comSee', true);
                    if ($seeFuntion === 3) {
                        $reply = true;
                    }
                    break;
                case '4':
                    $smarty->assign('comUse', true);
                    break;
                case '5':
                    $smarty->assign('memSee', true);
                    if ($seeFuntion === 5) {
                        $reply = true;
                    }
                    break;
                case '6':
                    $smarty->assign('memUse', true);
                    break;
            }
        }

        return $reply;
    }
}
