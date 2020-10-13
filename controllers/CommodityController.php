<?php

class CommodityController extends Controller
{
    private $success = false;
    private $result = null;

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
            $commodity = new Commodity();
            $commodity->setName($jsonObj->name);
            $commodity->setPrice($jsonObj->price);
            $commodity->setQuantity($jsonObj->quantity);
            $commodity->setStatus($jsonObj->status);


            if (($this->result['id'] = CommodityService::getDAO()->insert(
                $commodity->getName(),
                $commodity->getPrice(),
                $commodity->getQuantity(),
                $commodity->getStatus()
            )) <= 0) {
                throw new Exception('新增發生錯誤');
            }

            $this->result['result'] = true;
            $this->success = true;
        } catch (Exception $err) {
            $this->success = false;
        }

        return Result::getResultJson(
            $this->success,
            $this->result,
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
            $commodity = new Commodity();
            $commodity->setId($jsonObj->id);
            $commodity->setName($jsonObj->name);
            $commodity->setPrice($jsonObj->price);
            $commodity->setQuantity($jsonObj->quantity);
            $commodity->setStatus($jsonObj->status);

            if (!($this->result = CommodityService::getDAO()->update(
                $commodity->getId(),
                $commodity->getName(),
                $commodity->getPrice(),
                $commodity->getQuantity(),
                $commodity->getStatus()
            ))) {
                throw new Exception('更新發生錯誤');
            }
            $this->success = true;
        } catch (Exception $err) {
            $this->success = false;
        }

        return Result::getResultJson(
            $this->success,
            $this->result,
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
            $commodity = new Commodity();
            $commodity->setId($id);
            $commodity->setImageType($imageType);

            if (!($this->result = (CommodityService::getDAO()->updateImage($id, $image) && unlink($image)))) {
                throw new Exception('更新圖片錯誤');
            }

            $this->success = true;
        } catch (Exception $err) {
            $this->success = false;
        }

        return Result::getResultJson(
            $this->success,
            $this->result,
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

            $commodity = new Commodity();
            $commodity->setId($id);

            if (!($this->result = CommodityService::getDAO()->getOneByID($commodity->getId()))) {
                throw new Exception('取得發生錯誤');
            }

            $this->success = true;
        } catch (Exception $err) {
            $this->success = false;
        }

        return Result::getResultJson(
            $this->success,
            $this->result,
            isset($err) ? $err->getMessage() : null
        );
    }

    //取得部份資料
    public function getSomeData($lastID)
    {
        try {

            $commodity = new Commodity();
            $commodity->setId($lastID);

            if (!($this->result = CommodityService::getDAO()->getSome($commodity->getId()))) {
                throw new Exception('取得發生錯誤');
            }

            $this->success = true;
        } catch (Exception $err) {
            $this->success = false;
        }

        return Result::getResultJson(
            $this->success,
            $this->result,
            isset($err) ? $err->getMessage() : null
        );
    }

    //取得部份能購買的商品資料
    public function getSomeCanBuyDate($str)
    {
        try {
            $jsonObj = json_decode($str);

            $commodityDAO = CommodityService::getDAO();
            if ((count($this->result['data'] = $commodityDAO->getSomeCanBuy(
                    $jsonObj->offset,
                    $jsonObj->condition
                )) === 0)
                ||
                (($this->result['stopSet'] = $commodityDAO->getSeletSize(array('%'))) === -1)
            ) {
                throw new Exception('取得發生錯誤');
            }

            $this->success = true;
        } catch (Exception $err) {
            $this->success = false;
        }

        return Result::getResultJson(
            $this->success,
            $this->result,
            isset($err) ? $err->getMessage() : null
        );
    }

    //取得關鍵字搜尋
    public function getSomeByName($str)
    {
        try {
            $jsonObj = json_decode($str);

            $names = trim($jsonObj->names);

            $names = explode(' ', $names);
            for ($i = 0; $i < count($names); $i++) {
                $names[$i] = '%' . $names[$i] . '%';
            }

            $commodityDAO = CommodityService::getDAO();
            if (
                (count($this->result['data'] = $commodityDAO->getSomeByName(
                    $names,
                    $jsonObj->offset,
                    $jsonObj->condition
                )) === 0)
                ||
                (($this->result['stopSet'] = $commodityDAO->getSeletSize($names)) === -1)
            ) {
                throw new Exception('找無相關商品');
            }

            $this->success = true;
        } catch (Exception $err) {
            $this->success = false;
        }

        return Result::getResultJson(
            $this->success,
            $this->result,
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
            if (!(CommodityService::getDAO()->getOneByID($jsonObj->id))) {
                throw new Exception('無此商品');
            }
            if (isset($_COOKIE['shoppingCart'])) {
                $shoppingCart = json_decode($_COOKIE['shoppingCart']);
            } else {
                $shoppingCart = array();
            }
            $commodity = new Commodity();
            $commodity->setQuantity($jsonObj->quantity);

            foreach ($shoppingCart as $item) {
                if ($item->id === $jsonObj->id) {
                    $item->quantity += $jsonObj->quantity;
                    setcookie('shoppingCart', json_encode($shoppingCart), (time() + 31536000), "/");
                    return Result::getResultJson(
                        true,
                        true,
                        null
                    );
                }
            }

            $shoppingCart[] = $jsonObj;
            setcookie("shoppingCart", json_encode($shoppingCart), (time() + 31536000), "/");
            $this->result = true;
            $this->success = true;
        } catch (Exception $err) {
            $this->success = false;
        }

        return Result::getResultJson(
            $this->success,
            $this->result,
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
            if (isset($_COOKIE['shoppingCart'])) {
                $shoppingCart = json_decode($_COOKIE['shoppingCart']);
            } else {
                $shoppingCart = array();
            }
            $commodity = new Commodity();
            $commodity->setQuantity($jsonObj->quantity);

            foreach ($shoppingCart as $item) {
                if ($item->id === $jsonObj->id) {
                    $item->quantity = $jsonObj->quantity;
                    setcookie('shoppingCart', json_encode($shoppingCart), (time() + 31536000), "/");
                    $this->result = true;
                    break;
                }
            }

            $this->success = true;
        } catch (Exception $err) {
            $this->success = false;
        }

        return Result::getResultJson(
            $this->success,
            $this->result,
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

            if (isset($_COOKIE['shoppingCart'])) {
                $shoppingCart = json_decode($_COOKIE['shoppingCart']);
            } else {
                $shoppingCart = array();
            }

            foreach ($shoppingCart as $key => $item) {
                if ($item->id === $jsonObj->id) {
                    array_splice($shoppingCart, $key, 1);
                    setcookie('shoppingCart', json_encode($shoppingCart), (time() + 31536000), "/");
                    $this->result = true;
                    break;
                }
            }

            $this->success = true;
        } catch (Exception $err) {
            $this->success = false;
        }

        return Result::getResultJson(
            $this->success,
            $this->result,
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

            $commodityDAO = CommodityService::getDAO();
            $total = 0;
            foreach ($shoppingCart as $item) {
                $commodity = $commodityDAO->getOneByID($item->id);
                $total += $item->quantity * $commodity['price'];
            }

            $this->result = $total;
            $this->success = true;
        } catch (Exception $err) {
            $this->success = false;
        }

        return Result::getResultJson(
            $this->success,
            $this->result,
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
        $cartSize = count($shoppingCart);
        foreach ($shoppingCart as $key => $item) {
            if (!($commodity = $commodityDAO->getOneByID($item->id)) || !$commodity['status']) {
                unset($shoppingCart[$key]);
                continue;
            }
            $shoppingCart[$key]->name = $commodity['name'];
            $shoppingCart[$key]->price = $commodity['price'];
            $shoppingCart[$key]->maxQuantity = $commodity['quantity'];
            $total += $item->quantity * $commodity['price'];
            $lastID = $key;
        }

        $smarty->assign('lastID', $lastID);
        $smarty->assign('cartSize', $cartSize);
        $smarty->assign('shoppingCart', $shoppingCart);
        $smarty->assign('total', $total);
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
