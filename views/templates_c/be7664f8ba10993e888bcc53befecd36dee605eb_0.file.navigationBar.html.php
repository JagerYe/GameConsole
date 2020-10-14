<?php
/* Smarty version 3.1.34-dev-7, created on 2020-10-14 03:35:44
  from '/Applications/XAMPP/xamppfiles/htdocs/GameConsole/views/pageFront/navigationBar.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f8655f0d5dab9_89341018',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'be7664f8ba10993e888bcc53befecd36dee605eb' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/GameConsole/views/pageFront/navigationBar.html',
      1 => 1602639153,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f8655f0d5dab9_89341018 (Smarty_Internal_Template $_smarty_tpl) {
?><nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/GameConsole/index/getIndexView">Game休閒館</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="/GameConsole/index/getIndexView">商品列表</a>
                </li>
                <li><a href="/GameConsole/commodity/getShoppingCartView">購物車</a></li>
                <?php if ((isset($_smarty_tpl->tpl_vars['isLogin']->value)) && $_smarty_tpl->tpl_vars['isLogin']->value) {?>
                <li>
                    <a href="/GameConsole/order/getMemOrderListView">交易紀錄</a>
                </li>
                <?php }?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if ($_smarty_tpl->tpl_vars['isLogin']->value === true) {?>
                <li id="showUserName"><a
                        href=<?php echo (isset($_smarty_tpl->tpl_vars['isUpdate']->value)) && $_smarty_tpl->tpl_vars['isUpdate']->value ? "#" : "/GameConsole/member/getUpdateView";?>
><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</a>
                </li>
                <li><a href="/GameConsole/member/getLoginView">登出</a></li>
                <?php } else { ?>
                <li><a href="/GameConsole/member/getCreateView">註冊</a></li>
                <li><a href="/GameConsole/member/getLoginView">登入</a></li>
                <?php }?>
            </ul>
        </div>
    </div>

</nav><?php }
}
