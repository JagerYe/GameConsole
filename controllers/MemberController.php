<?php

class MemberController extends Controller
{
    private $success = false;
    private $result = null;
    private $saveTime = 0;

    public function __construct()
    {
        $this->requireDAO("member");
        $this->requireDAO("memberLoginStatus");
        $this->requireDAO("permissionControl");
        $this->requireDAO('permission');
    }

    //確認身份
    public function checkIdentity()
    {
        $memLoginDAO = MemberLoginStatusService::getDAO();
        if (!isset($_COOKIE['memLoginID']) || !isset($_COOKIE['memCookieID']) || !isset($_COOKIE['memID'])) {
            return false;
        }
        try {
            $loginData = $memLoginDAO->getLoginData($_COOKIE['memLoginID']);
            if ($loginData === false || $_COOKIE['memID'] !== $loginData['memberID'] || !password_verify($_COOKIE['memCookieID'], $loginData['cookieID'])) {
                throw new Exception("登入錯誤");
            }
            if ($loginData['timeOut'] && !$loginData['isKeep']) {
                $this->logout(true);
                throw new Exception("超過時間，請重新登入");
            }

            $this->saveTime = time() + (($loginData['isKeep']) ? (60 * 60 * 24 * 365) : (60 * 30));
            setcookie('memID', $_COOKIE['memID'], $this->saveTime, "/");
            setcookie('memName', $_COOKIE['memName'], $this->saveTime, "/");
            setcookie('memLoginID', $_COOKIE['memLoginID'], $this->saveTime, "/");
            setcookie('memCookieID', $_COOKIE['memCookieID'], $this->saveTime, "/");

            return $memLoginDAO->updateUsingByID($_COOKIE['memLoginID']);
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

            $jsonObj = json_decode($str);
            $member = new Member();
            $member->setAccount($jsonObj->account);
            $member->setPassword($jsonObj->password);
            $member->setName($jsonObj->name);
            $member->setEmail($jsonObj->email);
            $member->setPhone($jsonObj->phone);

            if (!($this->result = MemberService::getDAO()->insert(
                $member->getAccount(),
                $member->getPassword(),
                $member->getName(),
                $member->getEmail(),
                $member->getPhone()
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

    //更新會員啟用狀態
    public function updateStatus($str, $requestMethod)
    {
        try {
            //驗證
            if ($requestMethod !== 'PUT') {
                throw new Exception("請求方式錯誤");
            }
            if (!$this->checkIsEmp()) {
                throw new Exception("確認身份發生錯誤");
            }
            if (!PermissionControlService::getDAO()->checkHavePermissionByEmpID($_COOKIE['empID'], 6)) {
                throw new Exception("無此權限");
            }

            $jsonObj = json_decode($str);
            $member = new Member();
            $member->setId($jsonObj->id);
            $member->setStatus($jsonObj->status);

            if (!($this->result = MemberService::getDAO()->updateStatus($jsonObj->id, $jsonObj->status))) {
                throw new Exception('更新發生錯誤');
            }

            MemberLoginStatusService::getDAO()->setLogoutByMemberID($jsonObj->id);

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

    // //更新自己資料
    // public function updateSelf($str, $requestMethod)
    // {
    //     try {
    //         //驗證
    //         if ($requestMethod !== 'PUT') {
    //             throw new Exception("請求方式錯誤");
    //         }
    //         if (!$this->checkIdentity()) {
    //             throw new Exception("確認身份發生錯誤");
    //         }

    //         $jsonObj = json_decode($str);
    //         $member = new Member();
    //         $member->setId($jsonObj->id);
    //         $member->setName($jsonObj->name);
    //         $member->setEmail($jsonObj->email);

    //         $memberDAO = MemberService::getDAO();
    //         if (!($this->result = $memberDAO->update(
    //             $member->getId(),
    //             $member->getName(),
    //             $member->getEmail()
    //         ))) {
    //             throw new Exception('更新發生錯誤');
    //         }
    //         setcookie('memName', $member->getName(), $this->saveTime, "/");
    //         $this->success = true;
    //     } catch (Exception $err) {
    //         $this->success = false;
    //     }

    //     return Result::getResultJson(
    //         $this->success,
    //         $this->result,
    //         isset($err) ? $err->getMessage() : null
    //     );
    // }

    // //更新密碼
    // public function updateSelfPassword($str, $requestMethod)
    // {
    //     $jsonObj = json_decode($str);
    //     $member = new Member();
    //     try {
    //         $member->setPassword($jsonObj->password);

    //         //驗證
    //         if ($requestMethod !== 'PUT') {
    //             throw new Exception("請求方式錯誤");
    //         }
    //         if (!$this->checkIdentity()) {
    //             throw new Exception("確認身份發生錯誤");
    //         }
    //         if ($member->getPassword() !== $jsonObj->passwordAgain) {
    //             throw new Exception("兩次密碼錯誤");
    //         }

    //         $memberDAO = MemberService::getDAO();
    //         if (!$memberDAO->checkPassword($_COOKIE['memID'], $jsonObj->oldPassword)) {
    //             throw new Exception('密碼錯誤');
    //         }
    //         if (!($this->result = $memberDAO->updatePassword(
    //             $_COOKIE['memID'],
    //             $member->getPassword()
    //         ))) {
    //             throw new Exception('更新失敗');
    //         }

    //         $this->success = true;
    //     } catch (Exception $err) {
    //         $this->success = false;
    //     }

    //     return Result::getResultJson(
    //         $this->success,
    //         $this->result,
    //         isset($err) ? $err->getMessage() : null
    //     );
    // }

    // public function getOneByID()
    // {
    // }

    public function login($str, $requestMethod)
    {
        $jsonObj = json_decode($str);
        $memberDAO = MemberService::getDAO();
        try {
            if ($requestMethod !== 'POST' || !($memberDAO->doLogin($jsonObj->account, $jsonObj->password))) {
                throw new Exception('帳密錯誤');
            }

            if (!isset($jsonObj->isKeep)) {
                $jsonObj->isKeep = false;
            }

            $member = $memberDAO->getOneMemberByAccount($jsonObj->account);
            $this->saveTime = time() + (($jsonObj->isKeep) ? (60 * 60 * 24 * 365) : (60 * 30));

            MemberLoginStatusService::getDAO()->insert($member['id'], $this->saveTime, $jsonObj->isKeep);


            setcookie('memID', $member['id'], $this->saveTime, "/");
            setcookie('memName', $member['name'], $this->saveTime, "/");


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
            if (!isset($_COOKIE['memLoginID'])) {
                throw new Exception('並未登入');
            }

            if ($this->result = MemberLoginStatusService::getDAO()->setLogoutByID($_COOKIE['memLoginID'])) {
                $this->success = true;
            }
        } catch (Exception $err) {
            $this->success = false;
        }

        setcookie('memID', null, -1, "/");
        setcookie('memName', null, -1, "/");
        setcookie('memCookieID', null, -1, "/");
        setcookie('memLoginID', null, -1, "/");

        if (!$isTimeOut) {
            return Result::getResultJson(
                $this->success,
                $this->result,
                isset($err) ? $err->getMessage() : null
            );
        }
    }

    // public function logoutOneMemberAll($id)
    // {
    //     try {
    //         $this->result = MemberLoginStatusService::getDAO()->setLogoutByMemID($id);
    //         $this->success = true;
    //     } catch (Exception $err) {
    //         $this->success = false;
    //     }

    //     return Result::getResultJson(
    //         $this->success,
    //         $this->result,
    //         isset($err) ? $err->getMessage() : null
    //     );
    // }

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

    // //確認帳號是否存在
    public function checkAccountExist($account)
    {
        try {
            $this->result = MemberService::getDAO()->checkAccountExist($account);
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
        $smarty->display('pageFront/login.html');
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
            $permissions = PermissionControlService::getDAO()->getOneByID($_COOKIE['memID']);
            $this->smartyAssignPermission($permissions, $smarty);

            $smarty->assign('mem', MemberService::getDAO()->getOneMemberByID($_COOKIE['memID']));
            $smarty->assign('name', $_COOKIE['memName']);
        }
        $smarty->assign('isLogin', $isLogin);
        $smarty->assign('isUpdate', true);
        $smarty->display('pageFront/updateSelfData.html');
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
            $permissions = PermissionControlService::getDAO()->getOneByID($_COOKIE['memID']);
            $this->smartyAssignPermission($permissions, $smarty);

            $smarty->assign('mem', MemberService::getDAO()->getOneMemberByID($_COOKIE['memID']));
            $smarty->assign('name', $_COOKIE['memName']);
        }
        $smarty->assign('isLogin', $isLogin);
        $smarty->assign('isUpdate', true);

        $smarty->display('pageFront/updateSelfPassword.html');
    }

    //取得註冊頁面
    public function getCreateView()
    {
        $smarty = SmartyConfig::getSmarty();
        $smarty->display('pageFront/registered.html');
    }

    //員工會員管理頁面
    public function getMemberListView()
    {
        $smarty = SmartyConfig::getSmarty();

        try {
            $isLogin = $this->checkIsEmp();
        } catch (Exception $err) {
            $isLogin = false;
        }

        if ($isLogin) {

            //權限處理
            $permissions = PermissionControlService::getDAO()->getOneByID($_COOKIE['empID']);
            $memSee = $this->smartyAssignPermission($permissions, $smarty, 5);

            //
            if ($memSee) {
                $smarty->assign('name', $_COOKIE['empName']);
                $smarty->assign('isLogin', $isLogin);
                $smarty->assign('members', MemberService::getDAO()->getAll());
                $smarty->display('pageBack/memberList.html');
                return;
            }
        }

        $this->getUpdateSelfView();
    }





    // public function getUpdateView()
    // {
    //     $smarty = SmartyConfig::getSmarty();
    //     if ($isLogin = isset($_COOKIE['userID'])) {
    //         $member = MemberService::getDAO()->getOneMemberByID($_COOKIE['userID']);
    //         $smarty->assign('member', $member);
    //         $smarty->assign('userName', $_COOKIE['userName']);
    //         $smarty->assign('userID', $_COOKIE['userID']);
    //     }

    //     $smarty->assign('isLogin', $isLogin);
    //     $smarty->assign('isUpdate', true);

    //     $smarty->display('updateMemberData.html');
    // }


}
