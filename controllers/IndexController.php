<?php
class IndexController extends Controller
{
    public function getIndexView()
    {
        $smarty = SmartyConfig::getSmarty();
        $isLogin = isset($_SESSION['userID']);
        $smarty->assign('isLogin', $isLogin);
        $smarty->assign('userID', ($isLogin) ? $_SESSION['userID'] : "");
        $smarty->assign('userName', ($isLogin) ? $_SESSION['userName'] : "");

        $smarty->display('index_.html');
    }
}
