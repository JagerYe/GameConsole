<?php

class CommodityController extends Controller
{
    private $success = false;
    private $result = null;

    public function __construct()
    {
        $this->requireDAO("commodity");
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
