<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/orderdetail/OrderDetailDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/config.php";
class OrderDetailDAO implements OrderDetailDAO_Interface
{
    //新增訂單
    public function insert($orderID, $orderDetails, $dbh)
    {
        $sqlStr = "INSERT INTO `OrderDetails`(`orderID`, `commodityID`, `price`, `quantity`, `creationDatetime`) VALUES ";
        foreach ($orderDetails as $key => $value) {
            $sqlStr .= "(:orderID{$key},:commodityID{$key},:price{$key},:quantity{$key},NOW()),";
        }
        $sqlStr = substr_replace($sqlStr, ';', -1, 1);
        try {
            $sth = $dbh->prepare($sqlStr);

            foreach ($orderDetails as $key => &$detail) {
                $sth->bindParam("orderID{$key}", $orderID);
                $sth->bindParam("commodityID{$key}", $detail['id']);
                $sth->bindParam("price{$key}", $detail['price']);
                $sth->bindParam("quantity{$key}", $detail['quantity']);

                CommodityService::getDAO()->consume($dbh, $detail['id'], $detail['quantity']);
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
            $sth = $dbh->prepare("SELECT od.`orderID`, `commodityID`, od.`price`, od.`quantity`, `name`, `memberID`
            FROM `OrderDetails` AS od
            INNER JOIN `Commodities` AS c ON od.`commodityID`=c.`id`
            INNER JOIN `Orders` AS o ON od.`orderID`=o.`orderID`
            WHERE od.`orderID`=:orderID && `commodityID`<IFNULL(:commodityID,(~0 >> 32))
            ORDER BY `commodityID` DESC LIMIT 5;");
            $sth->bindParam("orderID", $orderID);
            $sth->bindParam("commodityID", $commodityID);
            $sth->execute();
            $request = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            $dbh = null;
            throw new Exception("取得資料發生錯誤\r\n" . $err->getMessage());
        }
        $dbh = null;
        return $request;
    }
}
