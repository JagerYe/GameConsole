<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/commodities/CommoditiesDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/GameConsole/models/config.php";
class CommoditiesDAO_PDO implements CommoditiesDAO
{
    //新增
    public function insert($name, $price, $quantity, $text = "", $status = false)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("INSERT INTO `Commodities`(`name`, `price`, `quantity`, `text`, `status`, `creationDate`)
                VALUES (:name,:price,:quantity,:text,:status,NOW());");
            $sth->bindParam("name", $name);
            $sth->bindParam("price", $price);
            $sth->bindParam("quantity", $quantity);
            $sth->bindParam("text", $text);
            $sth->bindParam("status", $status);
            $sth->execute();
            $dbh->commit();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            return false;
        }
        $dbh = null;
        return true;
    }

    //更新
    public function update($id, $name, $price, $quantity, $text, $status)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("UPDATE `Commodities` SET `name`=:name,`price`=:price,`quantity`=:quantity,`text`=:text,`status`=:status,`changeDate`=NOW() WHERE `id`=:id");
            $sth->bindParam("id", $id);
            $sth->bindParam("name", $name);
            $sth->bindParam("price", $price);
            $sth->bindParam("quantity", $quantity);
            $sth->bindParam("text", $text);
            $sth->bindParam("status", $status);
            $sth->execute();
            $dbh->commit();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            return false;
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
            $sth = $dbh->prepare("UPDATE `Commodities` SET `image`=LOAD_FILE(:image),`changeDate`=NOW() WHERE `id`=:id;");
            $sth->bindParam("id", $id);
            $sth->bindParam("image", $img);
            $sth->execute();
            $dbh->commit();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            return false;
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
            $sth = $dbh->prepare("SELECT `id`, `name`, `price`, `quantity`, `text`, `status`, `creationDate`, `changeDate` FROM `Commodities` WHERE `id`=:id;");
            $sth->bindParam("id", $id);
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
            return null;
        }
        $dbh = null;
        return $request['0'];
    }

    //取得部份商品
    public function getSome($id = null)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `id`, `name`, `price`, `quantity`, `text`, `status`, `creationDate`, `changeDate` FROM `Commodities`
                WHERE `id`<IFNULL(:id, (~0 >> 32)) ORDER BY `id` DESC LIMIT 5;"
            );
            $sth->bindParam("id", $id);
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
