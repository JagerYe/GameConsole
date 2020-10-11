<?php
/* Smarty version 3.1.34-dev-7, created on 2020-10-11 06:11:22
  from 'C:\xampp\htdocs\GameConsole\views\pageFront\orderList.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f8285ea2a4a84_66017399',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7d519791b11e8747c900111fccee8537a3f8305d' => 
    array (
      0 => 'C:\\xampp\\htdocs\\GameConsole\\views\\pageFront\\orderList.html',
      1 => 1602389476,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./navigationBar.html' => 1,
  ),
),false)) {
function content_5f8285ea2a4a84_66017399 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/GameConsole/views/img/logo.png">

    <title>GAME休閒館</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
        integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom styles for this template -->
    <link href="/GameConsole/views/css/starter-template.css" rel="stylesheet">

    <!-- Bootstrap -->
    <?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"
        integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd"
        crossorigin="anonymous"><?php echo '</script'; ?>
>

    <!-- ajax -->
    <?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"><?php echo '</script'; ?>
>

    <?php if (!((isset($_smarty_tpl->tpl_vars['isLogin']->value)) && $_smarty_tpl->tpl_vars['isLogin']->value)) {?>
    <meta http-equiv="refresh" content="0;url=/GameConsole/index/getIndexView">
    <?php }?>
</head>
<style>
    table {
        width: 100%;
    }

    .showDetails {
        width: 100%;
    }

    .oneOrder {
        margin-bottom: 10px;
    }
</style>
<?php echo '<script'; ?>
 src="/GameConsole/views/js/jsonFormat.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/GameConsole/views/js/title.js"><?php echo '</script'; ?>
>

<body>
    <?php $_smarty_tpl->_subTemplateRender('file:./navigationBar.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    <div class="blank"></div>

    <main class="container">
        <div id="orderList">
            <div class="oneOrder" id="order1">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <td>訂單編號</td>
                            <td>日期</td>
                            <td>總價</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>2020-06-12</td>
                            <td>1000</td>
                        </tr>
                    </tbody>
                </table>
                <div class="row" id="details">
                    <div class="col-xs-1"><a href="#">查看明細</a></div>
                    <div class="col-xs-11" id="showDetails"></div>
                </div>
            </div>

            <div class="oneOrder" id="order2">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <td>訂單編號</td>
                            <td>日期</td>
                            <td>總價</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>2020-06-12</td>
                            <td>1000</td>
                        </tr>
                    </tbody>
                </table>
                <div class="row" id="details">
                    <div class="col-xs-1"><a href="#">關閉明細</a></div>
                    <div class="col-xs-11" id="showDetails">
                        <table class="table table-hover table-bordered">
                            <tbody>
                                <tr>
                                    <td>商品名稱</td>
                                    <td>數量</td>
                                    <td>價格</td>
                                </tr>
                                <tr>
                                    <td>商品名稱</td>
                                    <td>數量</td>
                                    <td>價格</td>
                                </tr>
                                <tr>
                                    <td>商品名稱</td>
                                    <td>數量</td>
                                    <td>價格</td>
                                </tr>
                                <tr>
                                    <td>商品名稱</td>
                                    <td>數量</td>
                                    <td>價格</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </main>
</body>

</html><?php }
}
