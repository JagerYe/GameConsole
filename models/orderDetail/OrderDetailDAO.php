<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/orderdetail/OrderDetailDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/config.php";
class OrderDetailDAO implements OrderDetailDAO_Interface
{
    //新增訂單
    public function insert($orderID, $orderDetails, $dbh)
    {
        $sqlStr = "INSERT INTO `OrderDetails`(`orderID`, `commodityID`, `price`, `quantity`, `creationDatetime`) VALUES ";
        $arrSize = sizeof($orderDetails);
        for ($i = 0; $i < $arrSize; $i++) {
            $sqlStr += "(:orderID{$i},:commodityID{$i},:price{$i},:quantity{$i},NOW())";
            $sqlStr += ($i >= ($arrSize - 1)) ? ';' : ',';
        }
        try {
            $sth = $dbh->prepare($sqlStr);

            foreach ($orderDetails as $key => $detail) {
                $sth->bindParam("orderID{$key}", $orderID);
                $sth->bindParam("commodityID{$key}", $detail->commodityID);
                $sth->bindParam("price{$key}", $detail->price);
                $sth->bindParam("quantity{$key}", $detail->quantity);
            }
            $sth->execute();

            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            return false;
        }
        return true;
    }

    //修改
    // public function update(){}

    //登入狀態
    public function getSomeByOrderID($orderID, $commodityID)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT * FROM `Orders`
                WHERE `orderID`=:orderID && `commodityID`=<IFNULL(:commodityID,(~0 >> 32))
                ORDER BY `commodityID` DESC LIMIT 5;"
            );
            $sth->bindParam("orderID", $orderID);
            $sth->bindParam("commodityID", $commodityID);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            $dbh = null;
            return null;
        }
        $dbh = null;
        return $request;
    }
}
