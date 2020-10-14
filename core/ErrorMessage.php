<?php
class ErrorMessage
{
    //格式類--------------------------------------------------------
    //通用
    const FORMAT_ID = 'ID格式錯誤';
    const FORMAT_NAME = '名稱格式錯誤';
    const FORMAT_IMAGE_TYPE = '上傳圖片格式錯誤';

    //商品類
    const FORMAT_PRICE = '價格格式錯誤';
    const FORMAT_BUY_QUANTITY = '購買數量錯誤';
    const FORMAT_STOCK_QUANTITY = '庫存數量錯誤';
    const FORMAT_COMMODITY_STATUS = '商品狀態格式錯誤';

    //帳號類
    const FORMAT_ACCOUNT = '帳號格式錯誤';
    const FORMAT_PASSWORD = '密碼格式錯誤';
    const FORMAT_USER_NAME = '名字格式錯誤';
    const FORMAT_EMAIL = '信箱格式錯誤';
    const FORMAT_PHONE = '電話錯誤';
    const FORMAT_MEMBER_STATUS = '權限格式錯誤';

    //確認類--------------------------------------------------------
    const CHECK_REQUEST_METHOD = '請求方式錯誤';
    const CHECK_IDENTITY = '確認身份發生錯誤';
    const CHECK_PERMISSION = '無此權限';

    //流程類--------------------------------------------------------
    //通用
    const PROCESS_NEW = '新增發生錯誤';
    const PROCESS_UPDATE = '更新發生錯誤';
    const PROCESS_UPDATE_IMAGE = '更新圖片錯誤';
    const PROCESS_GET = '取得資料發生錯誤';

    //商品類
    const PROCESS_SELET_NULL = '找無相關商品';
    const PROCESS_SHOPPING_CART_NULL = '購物車為空，跟你的錢包一樣';
    const PROCESS_OFF_SHELF = '已下架，請再確認購買商品';
    const PROCESS_OVERSTOCK = '購買數量超過庫存，數量將修改，請再確認購買數量';

    //帳號類
    const PROCESS_LOGIN_ERROR = '登入錯誤';
    const PROCESS_ACCOUNT_PASSWORD_ERROR = '帳密錯誤';
    const PROCESS_NOT_LOGIN = '並未登入';
    const PROCESS_LOGIN_OVER_TIME = '超過時間，請重新登入';

    //訂單類
    const PROCESS_ORDER_IS_NULL = '沒有訂單';
    const PROCESS_DETAIL_IS_NULL = '沒有明細';

    //權限類
    const PROCESS_CHANGE_SELF = '自殺，造成不能挽回的遺憾、留給親友極大的傷痛，對個人、家庭、社會都造成極大的損失，
        撥打衛生福利部安心專線(0800-788-995，請幫幫救救我)
        或撥打生命線1995及張老師1980';
}
