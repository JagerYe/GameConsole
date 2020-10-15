<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/controllers/EmployeeController.php";
class PermissionController extends Controller
{
    private $success = false;
    private $result = null;

    public function __construct()
    {
        $this->requireDAO("permission");
        $this->requireDAO("permissionControl");
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
            $permissionControlDAO = PermissionControlService::getDAO();
            if (!$permissionControlDAO->checkHavePermissionByEmpID($_COOKIE['empID'], 2)) {
                throw new Exception("無此權限");
            }

            $jsonObj = json_decode($str);
            $permission = new PermissionControl();
            $permission->setEmpID($jsonObj->empID);
            foreach ($jsonObj->permissions as $value) {
                $permission->setPermissionID($value);
            }

            if (!($this->result = $permissionControlDAO->insertOneEmployeePermissions(
                $jsonObj->empID,
                $jsonObj->permissions
            ))) {
                throw new Exception('新增發生錯誤');
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

    //修改
    public function updateEmpPermission($str, $requestMethod)
    {
        try {
            //驗證
            if ($requestMethod !== 'PUT') {
                throw new Exception("請求方式錯誤");
            }
            if (!$this->checkIsEmp()) {
                throw new Exception("確認身份發生錯誤");
            }
            $permissionControlDAO = PermissionControlService::getDAO();
            if (!$permissionControlDAO->checkHavePermissionByEmpID($_COOKIE['empID'], 2)) {
                throw new Exception("無此權限");
            }

            $jsonObj = json_decode($str);

            //格式檢查
            $permission = new PermissionControl();
            $permission->setEmpID($jsonObj->empID);
            if ($_COOKIE['empID'] === $jsonObj->empID) {
                throw new Exception('自殺，造成不能挽回的遺憾、留給親友極大的傷痛，對個人、家庭、社會都造成極大的損失，
                    撥打衛生福利部安心專線(0800-788-995，請幫幫救救我)
                    或撥打生命線1995及張老師1980');
            }
            foreach ($jsonObj->permissions as $value) {
                $permission->setPermissionID($value);
            }

            $oldPermission = $permissionControlDAO->getOneByID($jsonObj->empID);

            foreach ($oldPermission as $itemOld) {
                for ($i = 0; $i < count($jsonObj->permissions); $i++) {
                    if (isset($jsonObj->permissions[$i]) && $itemOld['permissionID'] === $jsonObj->permissions[$i]) {
                        //如果有就不動作
                        array_splice($jsonObj->permissions, $i, 1);
                        continue 2;
                    }
                }

                //找完新清單還保留的就刪除
                $deleteID[] = $itemOld['permissionID'];
            }

            $deleteID = isset($deleteID) ? $deleteID : array();
            $insertID = isset($jsonObj->permissions) ? $jsonObj->permissions : array();
            if (!($this->result = $permissionControlDAO->update($jsonObj->empID, $deleteID, $insertID))) {
                throw new Exception('更新失敗');
            }

            // if (isset($deleteID)) {
            //     if (!$permissionControlDAO->delete($jsonObj->empID, $deleteID)) {
            //         throw new Exception('更新失敗');
            //     }
            // }

            // if (!$permissionControlDAO->insertOneEmployeePermissions(
            //     $jsonObj->empID,
            //     $jsonObj->permissions
            // )) {
            //     throw new Exception('新增發生錯誤');
            // }
            // $this->result = true;
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

    //查一位
    public function getOneEmpPermissionList($id)
    {
        try {
            //驗證
            if (!$this->checkIsEmp()) {
                throw new Exception("確認身份發生錯誤");
            }
            $permissionControlDAO = PermissionControlService::getDAO();
            if (!$permissionControlDAO->checkHavePermissionByEmpID($_COOKIE['empID'], 1)) {
                throw new Exception("無此權限");
            }

            $this->result['data'] = $permissionControlDAO->getOneByID($id);

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
}
