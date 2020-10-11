<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/order/OrderDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/orderDetail/OrderDetailService.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/config.php";
class OrderDAO implements OrderDAO_Interface
{
    //新增訂單
    public function insert($memberID, $address, $orderDetails)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("INSERT INTO `Orders`(`memberID`, `address`, `creationDatetime`) VALUES (:memberID,:address,NOW());");
            $sth->bindParam("memberID", $memberID);
            $sth->bindParam("address", $address);
            $sth->execute();
            $id = $dbh->lastInsertId();

            //新增訂單明細
            if (!OrderDetailService::getDAO()->insert($id, $orderDetails, $dbh)) {
                throw new Exception('新增明細發生錯誤');
            }

            $dbh->commit();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            throw new Exception("新增發生錯誤\r\n" . $err->getMessage());
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
        $dbh = null;
        return true;
    }

    //修改
    // public function update(){}

    //取得會員部分訂單
    public function getSomeByMemberID($memberID, $orderID = null)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT * FROM `Orders`
                WHERE `memberID`=:memberID && `orderID`<IFNULL(:orderID,(~0 >> 32))
                ORDER BY `orderID` DESC LIMIT 5;"
            );
            $sth->bindParam("memberID", $memberID);
            $sth->bindParam("orderID", $orderID);
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
