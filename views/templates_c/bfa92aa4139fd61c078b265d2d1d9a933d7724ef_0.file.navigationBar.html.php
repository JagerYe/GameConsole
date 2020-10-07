<?php
/* Smarty version 3.1.34-dev-7, created on 2020-10-07 18:33:02
  from 'C:\xampp\htdocs\GameConsole\views\pageBack\navigationBar.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f7dedbe5a0399_73969517',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bfa92aa4139fd61c078b265d2d1d9a933d7724ef' => 
    array (
      0 => 'C:\\xampp\\htdocs\\GameConsole\\views\\pageBack\\navigationBar.html',
      1 => 1602070468,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f7dedbe5a0399_73969517 (Smarty_Internal_Template $_smarty_tpl) {
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
            <a class="navbar-brand" href="/GameConsole/employee/getUpdateSelfView">Game休閒館</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php if ((isset($_smarty_tpl->tpl_vars['empSee']->value)) && $_smarty_tpl->tpl_vars['empSee']->value) {?>
                <li>
                    <a href="/GameConsole/employee/getEmployeeListView">員工<?php echo (isset($_smarty_tpl->tpl_vars['empUse']->value)) && $_smarty_tpl->tpl_vars['empUse']->value ? '管理' : '檢視';?>
</a>
                </li>
                <?php }?>
                <?php if ((isset($_smarty_tpl->tpl_vars['comSee']->value)) && $_smarty_tpl->tpl_vars['comSee']->value) {?>
                <li>
                    <a href="/GameConsole/commodity/getEmpCommodityListView">商品<?php echo (isset($_smarty_tpl->tpl_vars['comUse']->value)) && $_smarty_tpl->tpl_vars['comUse']->value ? '管理' : '檢視';?>
</a>
                </li>
                <?php }?>
                <?php if ((isset($_smarty_tpl->tpl_vars['memSee']->value)) && $_smarty_tpl->tpl_vars['memSee']->value) {?>
                <li>
                    <a href="/GameConsole/member/getMemberListView">會員<?php echo (isset($_smarty_tpl->tpl_vars['memUse']->value)) && $_smarty_tpl->tpl_vars['memUse']->value ? '管理' : '檢視';?>
</a>
                </li>
                <?php }?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if ($_smarty_tpl->tpl_vars['isLogin']->value === true) {?>
                <li id="showUserName"><a
                        href=<?php echo (isset($_smarty_tpl->tpl_vars['isUpdate']->value)) && $_smarty_tpl->tpl_vars['isUpdate']->value ? "#" : "/GameConsole/employee/getUpdateSelfView";?>
><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</a>
                </li>
                <li><a href="/GameConsole/employee/getLoginView" id="showLogin">登出</a></li>
                <?php } else { ?>
                <li><a href="/GameConsole/employee/getLoginView" id="showLogin">登入</a></li>
                <?php }?>
            </ul>
        </div>
    </div>

</nav><?php }
}
