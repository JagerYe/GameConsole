<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/orderdetail/OrderDetail.php";

class OrderController extends Controller
{
    private $success = false;
    private $result = null;

    public function __construct()
    {
        $this->requireDAO('order');
        $this->requireDAO('commodity');
    }

    //新增
    public function insert($requestMethod)
    {
        try {

            //驗證
            if ($requestMethod !== 'POST') {
                throw new Exception('請求方式錯誤');
            }
            if (!$this->checkIsMem()) {
                throw new Exception('確認身份發生錯誤');
            }
            if (!isset($_COOKIE['shoppingCart'])) {
                throw new Exception('購物車為空，跟你的錢包一樣');
            }

            $orderDetail = new OrderDetail();
            $commodityDAO = CommodityService::getDAO();

            $shoppingCart = json_decode($_COOKIE['shoppingCart']);
            $orderDetails = array();
            foreach ($shoppingCart as $key => $item) {
                $commodity = $commodityDAO->getOneByID($item->id);

                $orderDetail->setQuantity($item->quantity);
                if ($commodity['status'] === '0') {
                    array_splice($shoppingCart, $key, 1);
                    setcookie('shoppingCart', json_encode($shoppingCart), (time() + 31536000), "/");
                    throw new Exception("{$commodity['name']}已下架，請再確認購買商品");
                }
                if ($item->quantity > $commodity['quantity']) {
                    $shoppingCart[$key]->quantity = $commodity['quantity'];
                    setcookie('shoppingCart', json_encode($shoppingCart), (time() + 31536000), "/");
                    throw new Exception('購買數量超過庫存，數量將修改，請再確認購買數量');
                }
                if ($item->quantity <= 0) {
                    continue;
                }

                $commodity['quantity'] = $item->quantity;
                $orderDetails[] = $commodity;
                array_splice($shoppingCart, $key, 1);
            }


            if (!($this->result = OrderService::getDAO()->insert(
                $_COOKIE['memID'],
                'test',
                $orderDetails
            ))) {
                throw new Exception('新增發生錯誤');
            }

            setcookie('shoppingCart', json_encode($shoppingCart), (time() + 31536000), "/");

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

    //抓取訂單
    public function getMemberSelfOrder($lastShowOrderID, $requestMethod)
    {
        try {
            //驗證
            if ($requestMethod !== 'GET') {
                throw new Exception('請求方式錯誤');
            }
            if (!$this->checkIsMem()) {
                throw new Exception('確認身份發生錯誤');
            }

            if (count($this->result = OrderService::getDAO()->getSomeByMemberID(
                $_COOKIE['memID'],
                $lastShowOrderID
            )) === 0) {
                throw new Exception('沒有明細');
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

    //取得明細
    public function getMemSelfOrderDetail($str, $requestMethod)
    {
        try {
            //驗證
            if ($requestMethod !== 'GET') {
                throw new Exception('請求方式錯誤');
            }

            if (!$this->checkIsMem()) {
                throw new Exception('確認身份發生錯誤');
            }

            $jsonObj = json_decode($str);

            if (count($this->result = OrderDetailService::getDAO()->getSomeByOrderID(
                $jsonObj->orderID,
                $jsonObj->commodityID
            )) === 0) {
                throw new Exception('沒有明細');
            }

            //檢查是否為自己的
            if ($this->result[0]['memberID'] !== $_COOKIE['memID']) {
                $this->result = null;
                throw new Exception('資料抓取錯誤');
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

    //取得單一頁面
    public function getMemOrderListView()
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

            if (count($orders = OrderService::getDAO()->getSomeByMemberID($_COOKIE['memID'])) !== 0) {
                $smarty->assign('orders',  $orders);
                $smarty->assign('lastOrderID',  $orders[0]['lastOrderID']);
                $smarty->assign('lastShowOrderID',  $orders[count($orders) - 1]['orderID']);
            }
        }

        $smarty->display('pageFront/orderList.html');
    }

    // //取得管理者商品清單
    // public function getEmpOrderListView()
    // {
    //     $smarty = SmartyConfig::getSmarty();

    //     $isLogin = $this->checkIsEmp();

    //     if ($isLogin) {

    //         //權限處理
    //         $permissions = PermissionControlService::getDAO()->getOneByID($_COOKIE['empID']);
    //         $this->smartyAssignPermission($permissions, $smarty);

    //         $orders = OrderService::getDAO()->getSome();
    //         $lastID = $orders[count($orders) - 1]['id'];

    //         $smarty->assign('emp', EmployeeService::getDAO()->getOneEmployeeByID($_COOKIE['empID']));
    //         $smarty->assign('name', $_COOKIE['empName']);
    //         $smarty->assign('isLogin', $isLogin);
    //         $smarty->assign('orders', $orders);
    //         $smarty->assign('lastID', $lastID);
    //         $smarty->assign('permissions', PermissionService::getDAO()->getAll());
    //     }
    //     $smarty->display('pageBack/orderList.html');
    // }
}
