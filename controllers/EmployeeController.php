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

    //確認身份
    private function checkIdentity()
    {
        $empLoginDAO = EmployeeLoginStatusService::getDAO();
        if (!isset($_COOKIE['loginID']) || !isset($_COOKIE['cookieID'])) {
            return false;
        }
        try {
            if ($empLoginDAO->checkIsLogin($_COOKIE['loginID'], $_COOKIE['cookieID'])) {
                return $empLoginDAO->updateUsingByID($_COOKIE['loginID']);
            }
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
        return false;
    }

    //新增
    public function insert($str, $requestMethod)
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

            $to = $employee->getEmail();
            $subject = '註冊成功';
            $message = "註冊成功\r\n" . ((!$passwordIsset) ? "密碼：{$employee->getPassword()}" : "");
            $headers = "From:ggInInDer@mail.chungyo.net\r\n";
            mail($to, $subject, $message, $headers);

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
        // if (!isset($_COOKIE['empID']) || $requestMethod !== 'PUT' || $_COOKIE['userID'] !== $jsonObj->userID) {
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
            $_COOKIE['empName'] = $employee->getName();
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
            // if ((!isset($_COOKIE['userID'])) || ($requestMethod !== 'PUT') || ($employee->getUserPassword() !== $jsonObj->userPasswordAgain)) {
            //     return false;
            // }

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
            $saveTime = time() + (($jsonObj->isKeep) ? (60 * 60 * 24 * 365) : (60 * 30));

            EmployeeLoginStatusService::getDAO()->insert($employee['id'], $saveTime, $jsonObj->isKeep);


            setcookie('empID', $employee['id'], $saveTime, "/");
            setcookie('empName', $employee['name'], $saveTime, "/");


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

    public function logout()
    {

        try {
            if (!isset($_COOKIE['loginID'])) {
                throw new Exception('並未登入');
            }

            if ($this->result = EmployeeLoginStatusService::getDAO()->setLogoutByID($_COOKIE['loginID'])) {
                setcookie('empID', null, -1, "/");
                setcookie('empName', null, -1, "/");
                setcookie('cookieID', null, -1, "/");
                setcookie('loginID', null, -1, "/");
                $this->success = true;
            }
        } catch (Exception $err) {
            $this->success = false;
        }

        return Result::getResultJson(
            $this->success,
            $this->result,
            isset($err) ? $err->getMessage() : null
        );
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

    public function getLoginView()
    {
        $smarty = SmartyConfig::getSmarty();
        $smarty->display('pageBack/login.html');
    }

    public function getUpdateSelfView()
    {
        $smarty = SmartyConfig::getSmarty();
        $isLogin = $this->checkIdentity();
        if ($isLogin) {
            $smarty->assign('emp', EmployeeService::getDAO()->getOneEmployeeByID($_COOKIE['empID']));
        }
        $smarty->assign('isLogin', $isLogin);
        $smarty->assign('name', $_COOKIE['empName']);
        $smarty->assign('isUpdate', true);
        $smarty->display('pageBack/updateSelfData.html');
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

    // public function getUpdatePasswordView()
    // {
    //     $smarty = SmartyConfig::getSmarty();

    //     if ($isLogin = isset($_COOKIE['userID'])) {
    //         $smarty->assign('userID', $_COOKIE['userID']);
    //         $smarty->assign('userName', $_COOKIE['userName']);
    //     }

    //     $smarty->assign('isLogin', $isLogin);
    //     $smarty->assign('isUpdate', true);

    //     $smarty->display('updateEmployeePassword.html');
    // }
}
