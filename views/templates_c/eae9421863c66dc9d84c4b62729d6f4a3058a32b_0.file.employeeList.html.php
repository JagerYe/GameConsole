<?php
/* Smarty version 3.1.34-dev-7, created on 2020-10-05 12:20:37
  from '/Applications/XAMPP/xamppfiles/htdocs/GameConsole/views/pageBack/employeeList.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f7af3750abe60_47962593',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'eae9421863c66dc9d84c4b62729d6f4a3058a32b' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/GameConsole/views/pageBack/employeeList.html',
      1 => 1601893235,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./navigationBar.html' => 1,
  ),
),false)) {
function content_5f7af3750abe60_47962593 (Smarty_Internal_Template $_smarty_tpl) {
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
</head>
<style>
    .topImgBtn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background-color: black;
        max-height: 30px;
        max-width: 10px;
    }

    .updateBtn {
        width: 100%;
    }

    .width100Percentage {
        width: 100%;
    }

    .errMessage {
        color: red;
    }

    .borderBottomRed {
        border-bottom: 2px solid red;
    }
</style>
<?php echo '<script'; ?>
 src="/GameConsole/views/js/jsonFormat.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/GameConsole/views/js/title.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/GameConsole/views/js/rule.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    let empUse = '<?php echo $_smarty_tpl->tpl_vars['empUse']->value;?>
';
    let updatePermissionID = -1;
    $(window).ready(() => {
        //回最頂按鈕
        $(".topImgBtn").click(() => {
            $("html,body").animate({
                scrollTop: 0
            }, 1000);
        });

        //阻止無權限使用者修改
        if (empUse !== '1') {
            $('input').click(() => {
                return false;
            });
        }

        //權限按鈕
        $(".updatePermission").click(function () {
            updatePermissionID = $(this).parent().parent().children().html();
            console.log($(this).parent().parent().children().html());
        });

        //修改權限送出
        $("#updateCloseBtn").click(() => {

        });

        //帳號欄位檢查
        $("#account").change(function () {
            getCheckAccountMessage(this.value);
        });

        //帳號欄位檢查
        $("#name").change(function () {
            getCheckNameMessage(this.value);
        });

        //信箱欄位檢查
        $("#email").change(function () {
            getCheckEmailMessage(this.value);
        });

        //新增員工送出
        $("#updateCloseBtn").click(() => {

        });
    });

    //確認帳號並得到錯誤訊息內容
    function getCheckAccountMessage(value) {
        let checkMessage = $('#accountErrMessage');
        let input = $('#account');
        let returnStr = '帳號格式錯誤\r\n';

        checkMessage.empty();
        input.removeClass('borderBottomRed');
        if (!value.match(accountRule)) {
            checkMessage.text(returnStr);
            input.addClass('borderBottomRed');
            return returnStr;
        }
        return "";
    }

    //確認姓名並得到錯誤訊息內容
    function getCheckNameMessage(value) {
        let checkMessage = $('#nameErrMessage');
        let input = $('#name');
        let returnStr = '請輸入姓名\r\n';

        checkMessage.empty();
        input.removeClass('borderBottomRed');
        if (value.trim().length <= 0) {
            checkMessage.text(returnStr);
            input.addClass('borderBottomRed');
            return returnStr;
        }
        return "";
    }

    //確認信箱並得到錯誤訊息內容
    function getCheckEmailMessage(value) {
        let checkMessage = $('#emailErrMessage');
        let input = $('#email');
        let returnStr = '信箱格式錯誤\r\n';

        checkMessage.empty();
        input.removeClass('borderBottomRed');
        if (!value.match(emailRule)) {
            checkMessage.text(returnStr);
            input.addClass('borderBottomRed');
            return returnStr;
        }
        return "";
    }
<?php echo '</script'; ?>
>

<body>
    <?php $_smarty_tpl->_subTemplateRender('file:./navigationBar.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    <div class="blank"></div>

    <main class="container">
        <img class="topImgBtn" src="/GameConsole/views/img/top.png" alt="">

        <div class="text-right">
            <button class="btn btn-info " type="button" data-toggle="modal" data-target="#creatEmployeeModal"
                id="creatEmployeeBtn">新增員工</button>
        </div>



        <table class="table table-hover table-bordered" id="mainShow">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>帳號</th>
                    <th>姓名</th>
                    <th>email</th>
                    <th>創立日期</th>
                    <th>修改日期</th>
                    <th>權限</th>
                </tr>
            </thead>

            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['employees']->value, 'emp');
$_smarty_tpl->tpl_vars['emp']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['emp']->value) {
$_smarty_tpl->tpl_vars['emp']->do_else = false;
?>
            <tbody id="emp<?php echo $_smarty_tpl->tpl_vars['emp']->value['id'];?>
">
                <tr>
                    <td><?php echo $_smarty_tpl->tpl_vars['emp']->value['id'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['emp']->value['account'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['emp']->value['name'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['emp']->value['email'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['emp']->value['creationDatetime'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['emp']->value['changeDatetime'];?>
</td>
                    <td><button class="btn btn-info width100Percentage updatePermission" type="button"
                            data-toggle="modal" data-target="#updatePermissionModal">
                            <?php echo (isset($_smarty_tpl->tpl_vars['empUse']->value)) && $_smarty_tpl->tpl_vars['empUse']->value ? '修改' : '檢視';?>
權限
                        </button></td>
                </tr>
            </tbody>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>


        </table>

        <!-- Modal，用於修改權限用-->
        <div class="modal fade" id="updatePermissionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <!--背景-->
            <div class="modal-dialog" role="document">
                <!--內距-->
                <div class="modal-content">
                    <!--主體-->
                    <div class="modal-header">
                        <!--頭-->
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <!--按鈕要先，才能保持在上方-->
                        <h4 class="modal-title">修改權限</h4>
                        <!--開頭-->
                    </div>
                    <div class="modal-body">
                        <!--身-->
                        <label><input type="checkbox" name="" id="" value="1">員工檢視</label>
                        <label><input type="checkbox" name="" id="" value="1">員工管理</label>
                        <label><input type="checkbox" name="" id="" value="1">商品檢視</label>
                        <label><input type="checkbox" name="" id="" value="1">商品管理</label>
                        <label><input type="checkbox" name="" id="" value="1">會員檢視</label>
                        <label><input type="checkbox" name="" id="" value="1">會員管理</label>
                    </div>
                    <div class="modal-footer">
                        <!--底-->
                        <button type="button" class="btn btn-default" data-dismiss="modal"
                            id="updateCloseBtn">取消</button>
                        <!--取消按鈕-->
                        <button type="button" class="btn btn-primary" id="updateSubBtn">更新</button>
                        <!--送出-->
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal，用於新增員工用-->
        <div class="modal fade" id="creatEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <!--背景-->
            <div class="modal-dialog" role="document">
                <!--內距-->
                <div class="modal-content">
                    <!--主體-->
                    <div class="modal-header">
                        <!--頭-->
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <!--按鈕要先，才能保持在上方-->
                        <h4 class="modal-title">新增員工</h4>
                        <!--開頭-->
                    </div>
                    <div class="modal-body">
                        <!--身-->

                        <table class="table table-hover table-bordered">
                            <tbody>
                                <tr>
                                    <td>帳號</td>
                                    <td>
                                        <input class="width100Percentage" type="text" id="account">
                                        <div class="errMessage" id="accountErrMessage"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>姓名</td>
                                    <td>
                                        <input class="width100Percentage" type="text" id="name">
                                        <div class="errMessage" id="nameErrMessage"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>email</td>
                                    <td>
                                        <input class="width100Percentage" type="email" id="email">
                                        <div class="errMessage" id="emailErrMessage"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>權限</td>
                                    <td>
                                        <label><input type="checkbox" name="permission[]" id="1" value="1">員工檢視</label>
                                        <label><input type="checkbox" name="permission[]" id="2"
                                                value="2">員工管理</label><br>
                                        <label><input type="checkbox" name="permission[]" id="3" value="3">商品檢視</label>
                                        <label><input type="checkbox" name="permission[]" id="4"
                                                value="4">商品管理</label><br>
                                        <label><input type="checkbox" name="permission[]" id="5" value="5">會員檢視</label>
                                        <label><input type="checkbox" name="permission[]" id="6" value="6">會員管理</label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php if ($_smarty_tpl->tpl_vars['empUse']->value) {?>
                    <div class="modal-footer">
                        <!--底-->
                        <button type="button" class="btn btn-default" data-dismiss="modal"
                            id="updateCloseBtn">取消</button>
                        <!--取消按鈕-->
                        <button type="button" class="btn btn-primary" id="updateSubBtn">更新</button>
                        <!--送出-->
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </main><!-- /.container -->

</body>

</html><?php }
}
