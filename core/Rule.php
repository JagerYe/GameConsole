<?php
class Rule
{
    //通用-------------------------------------------------------
    //ID
    public function checkID($id)
    {
        return preg_match("/\d/", $id);
    }

    public function checkName($name)
    {
        return strlen(trim($name)) > 0;
    }

    public function checkImageType($imagetype)
    {
        return preg_match("/image.*/", $imagetype);
    }

    //登入相關-------------------------------------------------
    public function checkLoginID($loginID)
    {
        return preg_match("/\d/", $loginID);
    }

    public function checkCookieID($cookieID)
    {
        return preg_match("/\w+/", $cookieID);
    }

    public function checkPrice($price)
    {
        return preg_match("/\d/", $price) && $price >= 0;
    }

    //購買數量
    public function checkBuyQuantity($quantity)
    {
        return preg_match("/\d/", $quantity) && $quantity > 0;
    }

    //庫存數量
    public function checkStockQuantity($quantity)
    {
        return preg_match("/\d/", $quantity);
    }

    public function checkCommodityStatus($status)
    {
        return is_bool($status);
    }

    //帳號相關------------------------------------------------------------------
    public function checkAccount($account)
    {
        return preg_match("/\w{6,20}/", $account);
    }

    public function checkPassword($account)
    {
        return preg_match("/\w{6,20}/", $account);
    }

    public function checkEmail($email)
    {
        $emailRule = "/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/";
        return preg_match($emailRule, $email);
    }

    public function checkPhone($phone)
    {
        return preg_match("/\d{10}/", $phone);
    }

    //會員狀態
    public function checkMemberStatus($status)
    {
        return is_bool($status);
    }

    //控制相關------------------------------------------------------------------
    //檢查分頁位子格式
    public function checkOffset($offset)
    {
        return preg_match("/\d+/", $offset);
    }

    //檢查條件格式
    public function checkCondition($condition)
    {
        return $condition === 'newToOld' || $condition === 'oldToNew' ||
            $condition === 'cheapToExpensive' || $condition === 'expensiveToCheap';
    }
}
