<?php

class EmployeeController extends Controller
{
    private $success = false;
    private $result = null;

    public function __construct()
    {
        $this->requireDAO("employee");
        $this->requireDAO("employeeLoginStatus");
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

    //新增
    public function insertByObj($str, $requestMethod)
    {
        if ($requestMethod !== 'POST') {
            return false;
        }

        $jsonObj = json_decode($str);
        $employee = new Employee();
        try {
            $employee->setAccount($jsonObj->account);
            $passwordIsset = isset($jsonObj->password);
            if ($passwordIsset) {
                $employee->setPassword($jsonObj->password);
            } else {
                $employee->setPassword($this->getInitPassword());
            }
            $employee->setName($jsonObj->name);
            $employee->setEmail($jsonObj->email);

            if (!($this->result = EmployeeService::getDAO()->insert(
                $employee->getAccount(),
                $employee->getPassword(),
                $employee->getName(),
                $employee->getEmail()
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

    //更新
    public function update($str, $requestMethod)
    {
        //驗證
        $jsonObj = json_decode($str);
        // if (!isset($_SESSION['empID']) || $requestMethod !== 'PUT' || $_SESSION['userID'] !== $jsonObj->userID) {
        //     return false;
        // }

        $employee = new Employee();
        try {
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
            $_SESSION['userName'] = $employee->getName();
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
            // if ((!isset($_SESSION['userID'])) || ($requestMethod !== 'PUT') || ($employee->getUserPassword() !== $jsonObj->userPasswordAgain)) {
            //     return false;
            // }

            $employeeDAO = EmployeeService::getDAO();
            if (!$employeeDAO->checkPassword($_SESSION['empID'], $jsonObj->oldPassword)) {
                throw new Exception('密碼錯誤');
            }
            if (!($this->result = $employeeDAO->updatePassword(
                $_SESSION['empID'],
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

    public function login($str, $requestMethod)
    {
        $jsonObj = json_decode($str);
        try {
            if ($requestMethod !== 'POST' || !(EmployeeService::getDAO()->doLogin($jsonObj->account, $jsonObj->password))) {
                throw new Exception('帳密錯誤');
            }

            $employee = EmployeeService::getDAO()->getOneEmployeeByAccount($jsonObj->account);

            if (($cookieID = EmployeeLoginStatusService::getDAO()->insert(
                $employee['id'],
                isset($jsonObj->keepLoggedIn) ? $jsonObj->keepLoggedIn : false
            )) === "") {
                throw new Exception('登入錯誤');
            }

            $saveTime = time() + (($jsonObj->keepLoggedIn) ? (60 * 60 * 24 * 365) : (60 * 30));
            setcookie('empID', $employee['id'], $saveTime);
            setcookie('empName', $employee['name'], $saveTime);
            setcookie('cookieID', $cookieID);

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

    // public function getSessionUserName()
    // {
    //     if (isset($_SESSION['userName'])) {
    //         return $_SESSION['userName'];
    //     }
    //     return 'false';
    // }

    // public function getSessionUserID()
    // {
    //     if (isset($_SESSION['userID'])) {
    //         return $_SESSION['userID'];
    //     }
    //     return 'false';
    // }

    // public function logout()
    // {
    //     unset($_SESSION['userAccount']);
    //     unset($_SESSION['userName']);
    //     unset($_SESSION['userID']);
    // }

    // public function checkEmployeeExist($id)
    // {
    //     return EmployeeService::getDAO()->checkEmployeeExist($id);
    // }

    // public function getEmployeeSelfData()
    // {
    //     return json_encode(EmployeeService::getDAO()->getOneEmployeeByID($_SESSION['userID']));
    // }

    // public function getUserImg($id)
    // {
    //     return EmployeeService::getDAO()->getImgByID($id);
    // }

    // public function getCreateView()
    // {
    //     $smarty = SmartyConfig::getSmarty();
    //     $smarty->display('registered.html');
    // }

    // public function getLoginView()
    // {
    //     $smarty = SmartyConfig::getSmarty();
    //     $smarty->display('login.html');
    // }

    // public function getUpdateView()
    // {
    //     $smarty = SmartyConfig::getSmarty();
    //     if ($isLogin = isset($_SESSION['userID'])) {
    //         $employee = EmployeeService::getDAO()->getOneEmployeeByID($_SESSION['userID']);
    //         $smarty->assign('employee', $employee);
    //         $smarty->assign('userName', $_SESSION['userName']);
    //         $smarty->assign('userID', $_SESSION['userID']);
    //     }

    //     $smarty->assign('isLogin', $isLogin);
    //     $smarty->assign('isUpdate', true);

    //     $smarty->display('updateEmployeeData.html');
    // }

    // public function getUpdatePasswordView()
    // {
    //     $smarty = SmartyConfig::getSmarty();

    //     if ($isLogin = isset($_SESSION['userID'])) {
    //         $smarty->assign('userID', $_SESSION['userID']);
    //         $smarty->assign('userName', $_SESSION['userName']);
    //     }

    //     $smarty->assign('isLogin', $isLogin);
    //     $smarty->assign('isUpdate', true);

    //     $smarty->display('updateEmployeePassword.html');
    // }
}
