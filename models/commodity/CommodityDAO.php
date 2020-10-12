<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/commodity/CommodityDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/config.php";
class CommodityDAO implements CommodityDAO_Interface
{
    //新增
    public function insert($name, $price, $quantity,  $status = false)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("INSERT INTO `Commodities`(`name`, `price`, `quantity`, `status`, `creationDatetime`)
                VALUES (:name,:price,:quantity,:status,NOW());");
            $sth->bindParam("name", $name);
            $sth->bindParam("price", $price);
            $sth->bindParam("quantity", $quantity);
            $sth->bindParam("status", $status, PDO::PARAM_BOOL);
            $sth->execute();
            $id = $dbh->lastInsertId();
            $dbh->commit();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            throw new Exception("新增發生錯誤\r\n" . $err->getMessage());
        }
        $dbh = null;
        return $id;
    }

    //結帳時扣庫存用
    public function consume($dbh, $id, $buyQuantity)
    {
        try {
            $sth = $dbh->prepare("UPDATE `Commodities` SET
                `quantity`=(SELECT SUM(`quantity`-:buyQuantity) FROM `Commodities` WHERE `id`=:id && `quantity` >= :buyQuantity),
                `changeDatetime`=NOW() WHERE `id`=:id;");
            $sth->bindParam("id", $id);
            $sth->bindParam("buyQuantity", $buyQuantity);
            $sth->execute();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            throw new Exception("購買失敗\r\n");
        }
        $dbh = null;
        return true;
    }

    //更新
    public function update($id, $name, $price, $quantity, $status)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("UPDATE `Commodities` SET `name`=:name,`price`=:price,`quantity`=:quantity,`status`=:status,`changeDatetime`=NOW() WHERE `id`=:id");
            $sth->bindParam("id", $id);
            $sth->bindParam("name", $name);
            $sth->bindParam("price", $price);
            $sth->bindParam("quantity", $quantity);
            $sth->bindParam("status", $status, PDO::PARAM_BOOL);
            $sth->execute();
            $dbh->commit();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            throw new Exception("更新發生錯誤\r\n" . $err->getMessage());
        }
        $dbh = null;
        return true;
    }

    //更新圖片
    public function updateImage($id, $img)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("UPDATE `Commodities` SET `image`=LOAD_FILE(:image),`changeDatetime`=NOW() WHERE `id`=:id;");
            $sth->bindParam("id", $id);
            $sth->bindParam("image", $img);
            $sth->execute();
            $dbh->commit();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            throw new Exception("更新圖片發生錯誤\r\n" . $err->getMessage());
        }
        $dbh = null;
        return true;
    }

    //刪除
    // public function deleteByID($id){}

    //取得一個商品資料
    public function getOneByID($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `id`, `name`, `price`, `quantity`, `status`, `creationDatetime`, `changeDatetime` FROM `Commodities` WHERE `id`=:id;");
            $sth->bindParam("id", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            $dbh = null;
            throw new Exception("取得單一商品發生錯誤\r\n" . $err->getMessage());
        }
        $dbh = null;
        return $request;
    }

    //取得一張圖片
    public function getOneImgByID($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `image` FROM `Commodities` WHERE `id`=:id;");
            $sth->bindParam("id", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_NUM);
            $sth = null;
        } catch (PDOException $err) {
            $dbh = null;
            throw new Exception("取得圖片發生錯誤\r\n" . $err->getMessage());
        }
        $dbh = null;
        return $request['0'];
    }

    //取得部份商品
    public function getSome($id = null)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `id`, `name`, `price`, `quantity`, `status`, `creationDatetime`, `changeDatetime` FROM `Commodities`
                WHERE `id`<IFNULL(:id, (~0 >> 32)) ORDER BY `id` DESC LIMIT 5;");
            $sth->bindParam("id", $id);
            $sth->execute();
            $request = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            $dbh = null;
            throw new Exception("取得商品發生錯誤\r\n" . $err->getMessage());
        }
        $dbh = null;
        return $request;
    }

    //取得部份上架商品
    public function getSomeCanBuy($id = null)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `id`, `name`, `price`, `quantity`, `status`, `creationDatetime`, `changeDatetime` FROM `Commodities`
                WHERE status=1 && `id`<IFNULL(:id, (~0 >> 32)) ORDER BY `id` DESC LIMIT 5;");
            $sth->bindParam("id", $id);
            $sth->execute();
            $request = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            $dbh = null;
            throw new Exception("取得商品發生錯誤\r\n" . $err->getMessage());
        }
        $dbh = null;
        return $request;
    }
}
