<?php
class IndexController extends Controller
{
    public function getIndexView()
    {
        require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/controllers/MemberController.php";
        require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/commodity/CommodityService.php";
        $smarty = SmartyConfig::getSmarty();
        try {
            $isLogin = (new MemberController)->checkIdentity();
        } catch (Exception $err) {
            $isLogin = false;
        }

        $smarty->assign('isLogin', $isLogin);
        if ($isLogin) {
            $smarty->assign('name', $_COOKIE['memName']);
            $smarty->assign('memID', $_COOKIE['memID']);
        }

        $commodityDAO = CommodityService::getDAO();
        $commoditys = $commodityDAO->getSomeCanBuy();
        $smarty->assign('commoditys', $commoditys);
        $smarty->assign('offset', count($commoditys));
        $smarty->assign('stopSet', $commodityDAO->getSeletSize(array('%'), ''));

        $smarty->display('pageFront/index.html');
    }

    public function getBackIndexView()
    {
        $smarty = SmartyConfig::getSmarty();
        $smarty->display('pageBack/login.html');
    }
}
