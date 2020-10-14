<?php

class CommodityController extends Controller
{
    public function __construct()
    {
        $this->requireDAO("commodity");
    }

    //新增
    public function insert($str, $requestMethod)
    {
        try {
            //驗證
            if ($requestMethod !== 'POST') {
                throw new Exception("請求方式錯誤");
            }
            if (!$this->checkIsEmp()) {
                throw new Exception("確認身份發生錯誤");
            }
            if (!PermissionControlService::getDAO()->checkHavePermissionByEmpID($_COOKIE['empID'], 4)) {
                throw new Exception("無此權限");
            }

            $jsonObj = json_decode($str);
            $rule = new Rule;
            if (!$rule->checkName($jsonObj->name)) {
                throw new Exception('名稱格式錯誤');
            }
            if (!$rule->checkPrice($jsonObj->price)) {
                throw new Exception('價格格式錯誤');
            }
            if (!$rule->checkStockQuantity($jsonObj->quantity)) {
                throw new Exception('庫存數量錯誤');
            }
            if (!$rule->checkCommodityStatus($jsonObj->status)) {
                throw new Exception('商品狀態格式錯誤');
            }


            if (($result['id'] = CommodityService::getDAO()->insert(
                $jsonObj->name,
                $jsonObj->price,
                $jsonObj->quantity,
                $jsonObj->status
            )) <= 0) {
                throw new Exception('新增發生錯誤');
            }

            $result['result'] = true;
            $success = true;
        } catch (Exception $err) {
            $success = false;
        }

        return Result::getResultJson(
            $success,
            isset($result) ? $result : null,
            isset($err) ? $err->getMessage() : null
        );
    }

    //更新
    public function update($str, $requestMethod)
    {
        try {
            //驗證
            if ($requestMethod !== 'PUT') {
                throw new Exception("請求方式錯誤");
            }
            if (!$this->checkIsEmp()) {
                throw new Exception("確認身份發生錯誤");
            }
            if (!PermissionControlService::getDAO()->checkHavePermissionByEmpID($_COOKIE['empID'], 4)) {
                throw new Exception("無此權限");
            }

            $jsonObj = json_decode($str);

            $rule = new Rule;
            if (!$rule->checkID($jsonObj->id)) {
                throw new Exception('ID格式錯誤');
            }
            if (!$rule->checkName($jsonObj->name)) {
                throw new Exception('名稱格式錯誤');
            }
            if (!$rule->checkPrice($jsonObj->price)) {
                throw new Exception('價格格式錯誤');
            }
            if (!$rule->checkStockQuantity($jsonObj->quantity)) {
                throw new Exception('庫存數量錯誤');
            }
            if (!$rule->checkCommodityStatus($jsonObj->status)) {
                throw new Exception('商品狀態格式錯誤');
            }

            if (!($result = CommodityService::getDAO()->update(
                $jsonObj->id,
                $jsonObj->name,
                $jsonObj->price,
                $jsonObj->quantity,
                $jsonObj->status
            ))) {
                throw new Exception('更新發生錯誤');
            }
            $success = true;
        } catch (Exception $err) {
            $success = false;
        }

        return Result::getResultJson(
            $success,
            isset($result) ? $result : null,
            isset($err) ? $err->getMessage() : null
        );
    }

    //更新圖片，新增商品的圖片必須先新增完後再更新圖片
    public function updateImg($id, $image, $imageType, $requestMethod)
    {
        try {
            //驗證
            if ($requestMethod !== 'POST') {
                throw new Exception("請求方式錯誤");
            }
            if (!$this->checkIsEmp()) {
                throw new Exception("確認身份發生錯誤");
            }
            if (!PermissionControlService::getDAO()->checkHavePermissionByEmpID($_COOKIE['empID'], 4)) {
                throw new Exception("無此權限");
            }

            //格式驗證
            $rule = new Rule;
            if (!$rule->checkID($id)) {
                throw new Exception('ID格式錯誤');
            }
            if (!$rule->checkImageType($imageType)) {
                throw new Exception('上傳圖片格式錯誤');
            }

            if (!($result = (CommodityService::getDAO()->updateImage($id, $image) && unlink($image)))) {
                throw new Exception('更新圖片錯誤');
            }

            $success = true;
        } catch (Exception $err) {
            $success = false;
        }

        return Result::getResultJson(
            $success,
            isset($result) ? $result : null,
            isset($err) ? $err->getMessage() : null
        );
    }

    //取得商品圖片
    public function getOneImg($id)
    {
        return CommodityService::getDAO()->getOneImgByID($id);
    }

    //取得一個商品資訊
    public function getOneData($id)
    {
        try {
            if (!(new Rule)->checkID($id)) {
                throw new Exception('ID格式錯誤');
            }

            if (!($result = CommodityService::getDAO()->getOneByID($id))) {
                throw new Exception('取得發生錯誤');
            }

            $success = true;
        } catch (Exception $err) {
            $success = false;
        }

        return Result::getResultJson(
            $success,
            isset($result) ? $result : null,
            isset($err) ? $err->getMessage() : null
        );
    }

    //取得部份資料
    public function getSomeData($lastID)
    {
        try {
            if (!(new Rule)->checkID($lastID)) {
                throw new Exception('ID格式錯誤');
            }

            if (!($result = CommodityService::getDAO()->getSome($lastID))) {
                throw new Exception('取得發生錯誤');
            }

            $success = true;
        } catch (Exception $err) {
            $success = false;
        }

        return Result::getResultJson(
            $success,
            isset($result) ? $result : null,
            isset($err) ? $err->getMessage() : null
        );
    }

    //取得部份能購買的商品資料
    public function getSomeCanBuyDate($str)
    {
        try {
            $jsonObj = json_decode($str);

            $rule = new Rule;
            if (!$rule->checkOffset($jsonObj->offset)) {
                throw new Exception('分頁位子格式錯誤');
            }
            if (!$rule->checkCondition($jsonObj->condition)) {
                throw new Exception('條件格式錯誤');
            }

            $commodityDAO = CommodityService::getDAO();
            if ((count($result['data'] = $commodityDAO->getSomeCanBuy(
                    $jsonObj->offset,
                    $jsonObj->condition
                )) === 0)
                ||
                (($result['stopSet'] = $commodityDAO->getSeletSize(array('%'))) === -1)
            ) {
                throw new Exception('取得發生錯誤');
            }

            $success = true;
        } catch (Exception $err) {
            $success = false;
        }

        return Result::getResultJson(
            $success,
            isset($result) ? $result : null,
            isset($err) ? $err->getMessage() : null
        );
    }

    //取得關鍵字搜尋
    public function getSomeByName($str)
    {
        try {
            $jsonObj = json_decode($str);

            $names = trim($jsonObj->names);
            if (!(new Rule)->checkName($names)) {
                throw new Exception('搜尋名稱格式錯誤');
            }

            $names = explode(' ', $names);
            for ($i = 0; $i < count($names); $i++) {
                $names[$i] = '%' . $names[$i] . '%';
            }

            $commodityDAO = CommodityService::getDAO();
            if (
                (count($result['data'] = $commodityDAO->getSomeByName(
                    $names,
                    $jsonObj->offset,
                    $jsonObj->condition
                )) === 0)
                ||
                (($result['stopSet'] = $commodityDAO->getSeletSize($names)) === -1)
            ) {
                throw new Exception('找無相關商品');
            }

            $success = true;
        } catch (Exception $err) {
            $success = false;
        }

        return Result::getResultJson(
            $success,
            isset($result) ? $result : null,
            isset($err) ? $err->getMessage() : null
        );
    }

    //新增至購物車
    public function addInShoppingCart($str, $requestMethod)
    {
        try {
            if ($requestMethod !== 'POST') {
                throw new Exception("請求方式錯誤");
            }

            $jsonObj = json_decode($str);

            $rule = new Rule;
            if (!$rule->checkBuyQuantity($jsonObj->quantity)) {
                throw new Exception('購買數量錯誤');
            }
            if (!$rule->checkID($jsonObj->id)) {
                throw new Exception('商品ID格式錯誤');
            }
            if (!(CommodityService::getDAO()->getOneByID($jsonObj->id))) {
                throw new Exception('無此商品');
            }
            if (isset($_COOKIE['shoppingCart'])) {
                $shoppingCart = json_decode($_COOKIE['shoppingCart']);
            } else {
                $shoppingCart = array();
            }

            //檢查購物車是否有重複的商品，如果有就增加該商品數量
            $isRepeat = false;
            for ($i = 0; $i < count($shoppingCart); $i++) {
                if ($shoppingCart[$i]->id === $jsonObj->id) {
                    $shoppingCart[$i]->quantity += $jsonObj->quantity;
                    $isRepeat = true;
                    break;
                }
            }

            //當沒重複商品時新增項目
            if (!$isRepeat) {
                $shoppingCart[] = $jsonObj;
            }
            $a = json_encode($shoppingCart);
            setcookie("shoppingCart", json_encode($shoppingCart), (time() + 31536000), "/");
            $result = true;
            $success = true;
        } catch (Exception $err) {
            $success = false;
            $result = null;
        }

        return Result::getResultJson(
            $success,
            isset($result) ? $result : null,
            isset($err) ? $err->getMessage() : null
        );
    }

    //更新購物車
    public function updateInShoppingCart($str, $requestMethod)
    {
        try {
            if ($requestMethod !== 'PUT') {
                throw new Exception("請求方式錯誤");
            }

            $jsonObj = json_decode($str);
            if (!(CommodityService::getDAO()->getOneByID($jsonObj->id))) {
                throw new Exception('無此商品');
            }
            if (!(new Rule())->checkBuyQuantity($jsonObj->quantity)) {
                throw new Exception('購買數量錯誤');
            }
            if (isset($_COOKIE['shoppingCart'])) {
                $shoppingCart = json_decode($_COOKIE['shoppingCart']);
            } else {
                $shoppingCart = array();
            }

            foreach ($shoppingCart as $item) {
                if ($item->id === $jsonObj->id) {
                    $item->quantity = $jsonObj->quantity;
                    setcookie('shoppingCart', json_encode($shoppingCart), (time() + 31536000), "/");
                    $result = true;
                    break;
                }
            }

            $success = true;
        } catch (Exception $err) {
            $success = false;
        }

        return Result::getResultJson(
            $success,
            isset($result) ? $result : null,
            isset($err) ? $err->getMessage() : null
        );
    }

    //刪除購物車
    public function deleteInShoppingCart($str, $requestMethod)
    {
        try {
            if ($requestMethod !== 'DELETE') {
                throw new Exception("請求方式錯誤");
            }

            $jsonObj = json_decode($str);

            if (!(new Rule())->checkID($jsonObj->id)) {
                throw new Exception('商品ID錯誤');
            }

            if (isset($_COOKIE['shoppingCart'])) {
                $shoppingCart = json_decode($_COOKIE['shoppingCart']);
            } else {
                throw new Exception('本來就是空，還想惹塵埃');
            }

            $result = false;
            foreach ($shoppingCart as $key => $item) {
                if ($item->id === $jsonObj->id) {
                    array_splice($shoppingCart, $key, 1);
                    setcookie('shoppingCart', json_encode($shoppingCart), (time() + 31536000), "/");
                    $result = true;
                    break;
                }
            }

            if (!$result) {
                throw new Exception('沒有該商品，業障非常重');
            }

            $success = true;
        } catch (Exception $err) {
            $success = false;
        }

        return Result::getResultJson(
            $success,
            isset($result) ? $result : null,
            isset($err) ? $err->getMessage() : null
        );
    }

    //取得購物車資料
    public function getSomeShppingCartItem($lastID)
    {
        try {
            if (isset($_COOKIE['shoppingCart'])) {
                $shoppingCart = json_decode($_COOKIE['shoppingCart']);
            } else {
                throw new Exception('空的！跟錢包一樣');
            }

            $commodityDAO = CommodityService::getDAO();
            $lastID++;

            for ($i = $lastID; $i < (count($shoppingCart) - $lastID <= 5 ? count($shoppingCart) : $lastID + 5); $i++) {

                //檢查是否有該商品，如沒有就剔除
                if (
                    !($commodity = $commodityDAO->getOneByID($shoppingCart[$i]->id)) ||
                    $commodity['status'] !== '1'
                ) {
                    array_splice($shoppingCart, $i, 1);
                    setcookie('shoppingCart', json_encode($shoppingCart), (time() + 31536000), "/");
                    $i--;
                    continue;
                }
                $commodity['maxQuantity'] = $commodity['quantity'];
                $commodity['quantity'] = $shoppingCart[$i]->quantity;
                $item[] = $commodity;
                $lastID = $i;
            }


            $result['data'] = $item;
            $result['lastID'] = $lastID;
            $result['cartSize'] = count($shoppingCart);
            $success = true;
        } catch (Exception $err) {
            $success = false;
        }

        return Result::getResultJson(
            $success,
            isset($result) ? $result : null,
            isset($err) ? $err->getMessage() : null
        );
    }

    //取得購物車總金額
    public function getShoppingCartTotal()
    {
        try {
            if (isset($_COOKIE['shoppingCart'])) {
                $shoppingCart = json_decode($_COOKIE['shoppingCart']);
            } else {
                $shoppingCart = array();
            }

            $total = 0;
            foreach ($shoppingCart as $item) {
                $commodity = CommodityService::getDAO()->getOneByID($item->id);
                $total += $item->quantity * $commodity['price'];
            }

            $result = $total;
            $success = true;
        } catch (Exception $err) {
            $success = false;
        }

        return Result::getResultJson(
            $success,
            $result,
            isset($err) ? $err->getMessage() : null
        );
    }

    //取得購物車頁面
    public function getShoppingCartView()
    {
        require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/controllers/MemberController.php";
        $smarty = SmartyConfig::getSmarty();

        try {
            $isLogin = (new MemberController)->checkIdentity();
        } catch (Exception $err) {
            $isLogin = false;
        }
        $smarty->assign('isLogin', $isLogin);
        if ($isLogin) {
            $smarty->assign('name',  $_COOKIE['memName']);
            $smarty->assign('memID',  $_COOKIE['memID']);
        }
        $shoppingCart = isset($_COOKIE['shoppingCart']) ? json_decode($_COOKIE['shoppingCart']) : array();

        $total = 0;
        $commodityDAO = CommodityService::getDAO();
        $lastID = -1;

        $item = array();
        for ($i = 0; $i < (count($shoppingCart) > 5 ? 5 : count($shoppingCart)); $i++) {

            //檢查是否為商城內的商品，如果不是就踢出購物車
            if (!($commodity = $commodityDAO->getOneByID($shoppingCart[$i]->id)) || !$commodity['status']) {
                array_splice($shoppingCart, $i, 1);
                $i--;
                setcookie('shoppingCart', json_encode($shoppingCart), (time() + 31536000), "/");
                continue;
            }
            $shoppingCart[$i]->name = $commodity['name'];
            $shoppingCart[$i]->price = $commodity['price'];
            $shoppingCart[$i]->maxQuantity = $commodity['quantity'];
            $total += $shoppingCart[$i]->quantity * $commodity['price'];
            $item[] = $shoppingCart[$i];
            $lastID = $i;
        }
        $cartSize = count($shoppingCart);

        $smarty->assign('lastID', $lastID);
        $smarty->assign('cartSize', $cartSize);
        $smarty->assign('shoppingCart', $item);
        $smarty->display('pageFront/shoppingCart.html');
    }

    //取得單一頁面
    public function getOneView($id)
    {
        require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/controllers/MemberController.php";
        $smarty = SmartyConfig::getSmarty();

        try {
            $isLogin = (new MemberController)->checkIdentity();
        } catch (Exception $err) {
            $isLogin = false;
        }
        $smarty->assign('isLogin', $isLogin);
        if ($isLogin) {
            $smarty->assign('name',  $_COOKIE['memName']);
            $smarty->assign('memID',  $_COOKIE['memID']);
        }

        $smarty->assign('commodity', CommodityService::getDAO()->getOneByID($id));
        $smarty->display('pageFront/oneCommodity.html');
    }

    //取得管理者商品清單
    public function getEmpCommodityListView()
    {
        $smarty = SmartyConfig::getSmarty();

        $isLogin = $this->checkIsEmp();

        if ($isLogin) {

            //權限處理
            $permissions = PermissionControlService::getDAO()->getOneByID($_COOKIE['empID']);
            $this->smartyAssignPermission($permissions, $smarty);

            $commoditys = CommodityService::getDAO()->getSome();
            $lastID = $commoditys[count($commoditys) - 1]['id'];

            $smarty->assign('emp', EmployeeService::getDAO()->getOneEmployeeByID($_COOKIE['empID']));
            $smarty->assign('name', $_COOKIE['empName']);
            $smarty->assign('isLogin', $isLogin);
            $smarty->assign('commoditys', $commoditys);
            $smarty->assign('lastID', $lastID);
            $smarty->assign('permissions', PermissionService::getDAO()->getAll());
        }
        $smarty->display('pageBack/commodityList.html');
    }
}
