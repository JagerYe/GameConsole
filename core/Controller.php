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

    //確認管理者身份
    public function checkIsEmp()
    {
        require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/controllers/EmployeeController.php";
        $this->requireDAO("permissionControl");
        $this->requireDAO("employee");
        try {
            return (new EmployeeController())->checkIdentity();
        } catch (Exception $err) {
            return false;
        }
    }

    //確認會員身份
    public function checkIsMem()
    {
        require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/controllers/MemberController.php";
        try {
            return (new MemberController())->checkIdentity();
        } catch (Exception $err) {
            return false;
        }
    }
}
