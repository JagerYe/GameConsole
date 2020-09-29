<?php
class BackIndexController extends Controller
{
    public function getIndexView()
    {
        $smarty = SmartyConfig::getSmarty();
        $isLogin = isset($_SESSION['userID']);
        $smarty->assign('isLogin', $isLogin);
        $smarty->assign('empID', ($isLogin) ? $_SESSION['empID'] : "");
        $smarty->assign('empName', ($isLogin) ? $_SESSION['empName'] : "");

        $smarty->display('pageBack/login.html');
    }
}
