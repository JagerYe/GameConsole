<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/order/OrderDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/config.php";
class OrderDAO_PDO implements OrderDAO
{
    //新增訂單
    public function insert($memberID, $address, $orderDetails)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("INSERT INTO `Orders`(`memberID`, `address`, `creationDate`) VALUES (:memberID,:address,NOW());");
            $sth->bindParam("memberID", $memberID);
            $sth->bindParam("address", $address);
            $sth->execute();
            $id = $dbh->lastInsertId();

            //等訂單明細

            $dbh->commit();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            return 0;
        }
        $dbh = null;
        return $id;
    }

    //修改
    // public function update(){}

    //登入狀態
    public function getSomeByMemberID($memberID, $orderID = null)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT * FROM `Orders`
                WHERE `memberID`=:memberID && `orderID`=<IFNULL(:orderID,(~0 >> 32))
                ORDER BY `orderID` DESC LIMIT 5;"
            );
            $sth->bindParam("memberID", $memberID);
            $sth->bindParam("orderID", $orderID);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            $dbh = null;
            return false;
        }
        $dbh = null;
        return $request;
    }
}
