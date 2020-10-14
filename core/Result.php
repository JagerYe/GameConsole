<?php
class Result
{
    public static function getResultJson($success, $result, $errMessage = "")
    {
        $data['success'] = $success;
        $data['result'] = $result;
        $data['errMessage'] = $errMessage;
        return json_encode($data);
    }

    //通用-------------------------------------------------------
    //ID
    public function checkID($id)
    {
        return preg_match("/\d/", $id);
    }

    public function setName($name)
    {
        return strlen(trim($name)) <= 0;
    }

    public function setImageType($imagetype)
    {
        return preg_match("/image.*/", $imagetype);
    }

    //登入相關-------------------------------------------------
    public function setLoginID($loginID)
    {
        return preg_match("/\d/", $loginID);
    }

    public function setCookieID($cookieID)
    {
        return preg_match("/\w+/", $cookieID);
    }

    public function setPrice($price)
    {
        return preg_match("/\d/", $price) && $price >= 0;
    }

    //購買數量
    public function setBuyQuantity($quantity)
    {
        return preg_match("/\d/", $quantity) && $quantity > 0;
    }

    //庫存數量
    public function setStockQuantity($quantity)
    {
        return preg_match("/\d/", $quantity);
    }

    public function setCommodityStatus($status)
    {
        return is_bool($status);
    }

    

    //帳號相關------------------------------------------------------------------
    public function setAccount($account)
    {
        return preg_match("/\w{6,20}/", $account);
    }

    public function setPassword($account)
    {
        return preg_match("/\w{6,20}/", $account);
    }

    public function setEmail($email)
    {
        $emailRule = "/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/";
        return preg_match($emailRule, $email);
    }

    public function setPhone($phone)
    {
        return preg_match("/\d{10}/", $phone);
    }

    //會員狀態
    public function setMemberStatus($status)
    {
        return is_bool($status);
    }
}
