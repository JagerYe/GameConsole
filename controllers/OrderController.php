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

                $commodity['quantity'] = $item->quantity;
                $orderDetails[] = $commodity;
            }


            if (!($this->result = OrderService::getDAO()->insert(
                $_COOKIE['memID'],
                'test',
                $orderDetails
            ))) {
                throw new Exception('新增發生錯誤');
            }

            setcookie('shoppingCart', null, -1, '/');

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
        }

        $smarty->display('pageFront/orderList.html');
    }

    // //取得部份能購買的商品資料
    // public function getSomeCanBuyDate($lastID)
    // {
    //     try {

    //         $order = new Order();
    //         $order->setId($lastID);

    //         if (!($this->result = OrderService::getDAO()->getSomeCanBuy($order->getId()))) {
    //             throw new Exception('取得發生錯誤');
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
