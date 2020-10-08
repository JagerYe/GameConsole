<?php

class EmployeeController extends Controller
{
    private $success = false;
    private $result = null;
    private $saveTime = 0;

    public function __construct()
    {
        $this->requireDAO("employee");
        $this->requireDAO("employeeLoginStatus");
        $this->requireDAO("permissionControl");
        $this->requireDAO('permission');
    }

    //取得初始隨機密碼
    private function getInitPassword()
    {
        $randomStr = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomSize = strlen($randomStr);
        $returnStr = "";
        for ($i = 0; $i < 8; $i++) {
            $returnStr .= $randomStr[rand(0, $randomSize - 1)];
        }
        return $returnStr;
    }

    //確認身份
    public function checkIdentity()
    {
        $empLoginDAO = EmployeeLoginStatusService::getDAO();
        if (!isset($_COOKIE['empLoginID']) || !isset($_COOKIE['empCookieID']) || !isset($_COOKIE['empID'])) {
            return false;
        }
        try {
            $loginData = $empLoginDAO->getLoginData($_COOKIE['empLoginID']);
            if ($loginData === false || $_COOKIE['empID'] !== $loginData['empID'] || !password_verify($_COOKIE['empCookieID'], $loginData['cookieID'])) {
                throw new Exception("登入錯誤");
            }
            if ($loginData['timeOut'] && !$loginData['isKeep']) {
                $this->logout(true);
                throw new Exception("超過時間，請重新登入");
            }

            $this->saveTime = time() + (($loginData['isKeep']) ? (60 * 60 * 24 * 365) : (60 * 30));
            setcookie('empID', $_COOKIE['empID'], $this->saveTime, "/");
            setcookie('empName', $_COOKIE['empName'], $this->saveTime, "/");
            setcookie('empLoginID', $_COOKIE['empLoginID'], $this->saveTime, "/");
            setcookie('empCookieID', $_COOKIE['empCookieID'], $this->saveTime, "/");

            return $empLoginDAO->updateUsingByID($_COOKIE['empLoginID']);
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
        return false;
    }

    //新增
    public function insert($str, $requestMethod)
    {
        try {
            //驗證
            if ($requestMethod !== 'POST') {
                throw new Exception("請求方式錯誤");
            }
            if (!$this->checkIdentity()) {
                throw new Exception("確認身份發生錯誤");
            }
            if (!PermissionControlService::getDAO()->checkHavePermissionByEmpID($_COOKIE['empID'], 2)) {
                throw new Exception("無此權限");
            }

            $jsonObj = json_decode($str);
            $employee = new Employee();
            $employee->setAccount($jsonObj->account);
            if (isset($jsonObj->password)) {
                $employee->setPassword($jsonObj->password);
            } else {
                $employee->setPassword($this->getInitPassword());
            }
            $employee->setName($jsonObj->name);
            $employee->setEmail($jsonObj->email);

            if (($this->result['id'] = EmployeeService::getDAO()->insert(
                $employee->getAccount(),
                $employee->getPassword(),
                $employee->getName(),
                $employee->getEmail()
            )) <= 0) {
                throw new Exception('新增發生錯誤');
            }

            $to = $employee->getEmail();
            $subject = '註冊成功';
            $message =  "帳號：{$employee->getAccount()}\r\n" . "密碼：{$employee->getPassword()}";
            $headers = "From:ggInInDer@mail.chungyo.net";
            mail($to, $subject, $message, $headers);



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
            if (!$this->checkIdentity()) {
                throw new Exception("確認身份發生錯誤");
            }

            $jsonObj = json_decode($str);
            $employee = new Employee();
            $employee->setId($jsonObj->id);
            $employee->setName($jsonObj->name);
            $employee->setEmail($jsonObj->email);

            $employeeDAO = EmployeeService::getDAO();
            if (!($this->result = $employeeDAO->update(
                $employee->getId(),
                $employee->getName(),
                $employee->getEmail()
            ))) {
                throw new Exception('更新發生錯誤');
            }
            setcookie('empName', $employee->getName(), $this->saveTime, "/");
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

    //更新密碼
    public function updateSelfPassword($str, $requestMethod)
    {
        $jsonObj = json_decode($str);
        $employee = new Employee();
        try {
            $employee->setPassword($jsonObj->password);

            //驗證
            if ($requestMethod !== 'PUT') {
                throw new Exception("請求方式錯誤");
            }
            if (!$this->checkIdentity()) {
                throw new Exception("確認身份發生錯誤");
            }
            if ($employee->getPassword() !== $jsonObj->passwordAgain) {
                throw new Exception("兩次密碼錯誤");
            }

            $employeeDAO = EmployeeService::getDAO();
            if (!$employeeDAO->checkPassword($_COOKIE['empID'], $jsonObj->oldPassword)) {
                throw new Exception('密碼錯誤');
            }
            if (!($this->result = $employeeDAO->updatePassword(
                $_COOKIE['empID'],
                $employee->getPassword()
            ))) {
                throw new Exception('更新失敗');
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

    public function getOneByID()
    {
    }

    public function login($str, $requestMethod)
    {
        $jsonObj = json_decode($str);
        $employeeDAO = EmployeeService::getDAO();
        try {
            if ($requestMethod !== 'POST' || !($employeeDAO->doLogin($jsonObj->account, $jsonObj->password))) {
                throw new Exception('帳密錯誤');
            }

            if (!isset($jsonObj->isKeep)) {
                $jsonObj->isKeep = false;
            }

            $employee = $employeeDAO->getOneEmployeeByAccount($jsonObj->account);
            $this->saveTime = time() + (($jsonObj->isKeep) ? (60 * 60 * 24 * 365) : (60 * 30));

            EmployeeLoginStatusService::getDAO()->insert($employee['id'], $this->saveTime, $jsonObj->isKeep);


            setcookie('empID', $employee['id'], $this->saveTime, "/");
            setcookie('empName', $employee['name'], $this->saveTime, "/");


            $this->success = true;
            $this->result = true;
        } catch (Exception $err) {
            $this->success = false;
        }

        return Result::getResultJson(
            $this->success,
            $this->result,
            isset($err) ? $err->getMessage() : null
        );
    }

    public function logout($isTimeOut = false)
    {
        try {
            if (!isset($_COOKIE['empLoginID'])) {
                throw new Exception('並未登入');
            }

            if ($this->result = EmployeeLoginStatusService::getDAO()->setLogoutByID($_COOKIE['empLoginID'])) {
                $this->success = true;
            }
        } catch (Exception $err) {
            $this->success = false;
        }
        setcookie('empID', null, -1, "/");
        setcookie('empName', null, -1, "/");
        setcookie('empCookieID', null, -1, "/");
        setcookie('empLoginID', null, -1, "/");

        if (!$isTimeOut) {
            return Result::getResultJson(
                $this->success,
                $this->result,
                isset($err) ? $err->getMessage() : null
            );
        }
    }

    public function logoutOneEmployeeAll($id)
    {
        try {
            $this->result = EmployeeLoginStatusService::getDAO()->setLogoutByEmpID($id);
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

    //前端取得是否登入用
    public function checkIsLogin()
    {
        try {
            $this->result = $this->checkIdentity();
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

    //確認帳號是否存在
    public function checkAccountExist($account)
    {
        try {
            $this->result = EmployeeService::getDAO()->checkAccountExist($account);
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

    //登入頁面
    public function getLoginView()
    {
        $smarty = SmartyConfig::getSmarty();
        $smarty->display('pageBack/login.html');
    }

    //更新自己資料頁面
    public function getUpdateSelfView()
    {
        $smarty = SmartyConfig::getSmarty();

        try {
            $isLogin = $this->checkIdentity();
        } catch (Exception $err) {
            $isLogin = false;
        }
        if ($isLogin) {

            //權限處理
            $permissions = PermissionControlService::getDAO()->getOneByID($_COOKIE['empID']);
            $this->smartyAssignPermission($permissions, $smarty);

            $smarty->assign('emp', EmployeeService::getDAO()->getOneEmployeeByID($_COOKIE['empID']));
            $smarty->assign('name', $_COOKIE['empName']);
        }
        $smarty->assign('isLogin', $isLogin);
        $smarty->assign('isUpdate', true);
        $smarty->display('pageBack/updateSelfData.html');
    }

    //取得更新自己密碼頁面
    public function getUpdateSelfPasswordView()
    {
        $smarty = SmartyConfig::getSmarty();

        try {
            $isLogin = $this->checkIdentity();
        } catch (Exception $err) {
            $isLogin = false;
        }
        if ($isLogin) {

            //權限處理
            $permissions = PermissionControlService::getDAO()->getOneByID($_COOKIE['empID']);
            $this->smartyAssignPermission($permissions, $smarty);

            $smarty->assign('emp', EmployeeService::getDAO()->getOneEmployeeByID($_COOKIE['empID']));
            $smarty->assign('name', $_COOKIE['empName']);
        }
        $smarty->assign('isLogin', $isLogin);
        $smarty->assign('isUpdate', true);

        $smarty->display('pageBack/updateSelfPassword.html');
    }

    public function getEmployeeListView()
    {
        $smarty = SmartyConfig::getSmarty();

        try {
            $isLogin = $this->checkIdentity();
        } catch (Exception $err) {
            $isLogin = false;
        }

        if ($isLogin) {

            //權限處理
            $permissions = PermissionControlService::getDAO()->getOneByID($_COOKIE['empID']);
            $empSee = $this->smartyAssignPermission($permissions, $smarty, 1);

            //
            if ($empSee) {
                $smarty->assign('emp', EmployeeService::getDAO()->getOneEmployeeByID($_COOKIE['empID']));
                $smarty->assign('name', $_COOKIE['empName']);
                $smarty->assign('isLogin', $isLogin);
                $smarty->assign('employees', EmployeeService::getDAO()->getAll());
                $smarty->assign('permissions', PermissionService::getDAO()->getAll());
                $smarty->display('pageBack/employeeList.html');
                return;
            }
        }

        $this->getUpdateSelfView();
    }





    // public function getCreateView()
    // {
    //     $smarty = SmartyConfig::getSmarty();
    //     $smarty->display('registered.html');
    // }



    // public function getUpdateView()
    // {
    //     $smarty = SmartyConfig::getSmarty();
    //     if ($isLogin = isset($_COOKIE['userID'])) {
    //         $employee = EmployeeService::getDAO()->getOneEmployeeByID($_COOKIE['userID']);
    //         $smarty->assign('employee', $employee);
    //         $smarty->assign('userName', $_COOKIE['userName']);
    //         $smarty->assign('userID', $_COOKIE['userID']);
    //     }

    //     $smarty->assign('isLogin', $isLogin);
    //     $smarty->assign('isUpdate', true);

    //     $smarty->display('updateEmployeeData.html');
    // }


}
