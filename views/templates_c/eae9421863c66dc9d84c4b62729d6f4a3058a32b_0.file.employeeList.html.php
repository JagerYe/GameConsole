<?php
/* Smarty version 3.1.34-dev-7, created on 2020-10-15 09:09:09
  from '/Applications/XAMPP/xamppfiles/htdocs/GameConsole/views/pageBack/employeeList.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f87f595e30bd1_84243237',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'eae9421863c66dc9d84c4b62729d6f4a3058a32b' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/GameConsole/views/pageBack/employeeList.html',
      1 => 1602731579,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./navigationBar.html' => 1,
  ),
),false)) {
function content_5f87f595e30bd1_84243237 (Smarty_Internal_Template $_smarty_tpl) {
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
    <?php if (!((isset($_smarty_tpl->tpl_vars['empSee']->value)))) {?>
    <meta http-equiv="refresh" content="0;url=/GameConsole/employee/getUpdateSelfView">
    <?php }?>
</head>
<style>
    .topImgBtn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background-color: black;
        max-height: 30px;
        max-width: 30px;
        width: 20px;
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
 src="/GameConsole/views/js/viewModels/employeeViewModel.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    let empUse = '<?php echo (isset($_smarty_tpl->tpl_vars['empUse']->value)) && $_smarty_tpl->tpl_vars['empUse']->value;?>
';
    let updatePermissionEmpID = -1;
    let empPermissions = new Array();
    let getItemProcessing = false;
    let lastID = '<?php if ((isset($_smarty_tpl->tpl_vars['lastID']->value))) {
echo $_smarty_tpl->tpl_vars['lastID']->value;
}?>';
    let showLastID = '<?php if ((isset($_smarty_tpl->tpl_vars['showLastID']->value))) {
echo $_smarty_tpl->tpl_vars['showLastID']->value;
}?>';
    lastID = parseInt(lastID);
    showLastID = parseInt(showLastID);

    function checkboxGearing(checkbox, isUpdate = false) {
        let checkClass = (isUpdate) ? '.updatePermission' : '.creatEmpPermission';

        switch (parseInt($(checkbox).val())) {
            case 1:
                if ($(checkbox).prop('checked') === false) {
                    $(`${checkClass}[value=2]`).prop('checked', false);
                }
                break;

            case 2:
                if ($(checkbox).prop('checked') === true) {
                    $(`${checkClass}[value=1]`).prop('checked', true);
                }
                break;

            case 3:
                if ($(checkbox).prop('checked') === false) {
                    $(`${checkClass}[value=4]`).prop('checked', false);
                }
                break;

            case 4:
                if ($(checkbox).prop('checked') === true) {
                    $(`${checkClass}[value=3]`).prop('checked', true);
                }
                break;

            case 5:
                if ($(checkbox).prop('checked') === false) {
                    $(`${checkClass}[value=6]`).prop('checked', false);
                }
                break;

            case 6:
                if ($(checkbox).prop('checked') === true) {
                    $(`${checkClass}[value=5]`).prop('checked', true);
                }
                break;

            default:
                break;
        }

    }
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

        //新增員工權限checkBox處理
        $('.creatEmpPermission').click(function () {
            checkboxGearing(this);
        });

        //更新權限checkBox處理
        $('.updatePermission').click(function () {
            checkboxGearing(this, true);
        });

        //滾動監聽器
        $(window).scroll(function (e) {
            let windowBottom = $(this).height() + $(this).scrollTop();
            console.log('window bottom' + windowBottom);
            console.log('body ' + $('body').height());

            if (isNaN(lastID) || isNaN(showLastID) || showLastID >= lastID) {
                $(this).off('scroll');
                return;
            }

            if ((windowBottom >= ($('body').height() * 0.7)) && !getItemProcessing) {
                getItemProcessing = true;
                $.ajax({
                    type: 'GET',
                    url: `/GameConsole/employee/getSome?lastID=${showLastID}`
                }).then(function (e) {
                    e = organizeFormat(e);
                    let json = JSON.parse(e);
                    console.log(json);
                    if (json.success === false) {
                        switch (json.errMessage) {
                            case '無此權限':
                            case '確認身份發生錯誤':
                                alert(json.errMessage + '將會重新整理頁面');
                                history.go(0);
                                break;
                            default:
                                alert(json.errMessage);
                                break;
                        }
                        return;
                    }
                    lastID = json.result.lastID;
                    for (let item of json.result.data) {
                        $('#dataShow').append(getEmployeeListView(
                            empUse,
                            item.id,
                            item.account,
                            item.name,
                            item.email,
                            item.creationDatetime,
                            (item.changeDatetime === null) ? '' : item.changeDatetime
                        ));
                        showLastID = parseInt(item.id);
                    }

                    lastID = parseInt(json.result.lastID);
                    getItemProcessing = false;
                    $(window).trigger('scroll');
                });
            }
        }).trigger('scroll');


        //權限顯示按鈕
        updateListener();

        //修改權限送出
        $("#updateSubBtn").click(() => {
            empPermissions = new Array();
            $('input[class="updatePermission"]:checked').each(function () {
                empPermissions.push(this.value);
            });
            let permission = {
                'empID': updatePermissionEmpID,
                'permissions': empPermissions
            };

            $.ajax({
                type: "PUT",
                url: "/GameConsole/permission/updateEmpPermission",
                data: { 0: JSON.stringify(permission) }
            }).then(function (e) {
                console.log(e);
                let json = JSON.parse(e);
                if (json.success === false) {
                    switch (json.errMessage) {
                        case '無此權限':
                        case '確認身份發生錯誤':
                            alert(json.errMessage + '將會重新整理頁面');
                            history.go(0);
                            return;
                        default:
                            alert(json.errMessage);
                    }
                } else if (json.result === true) {
                    alert("更新成功");
                } else {
                    alert("發生意外錯誤");
                }
            });
        });

        //下列為新增欄位用

        //新增按鈕
        $("#creatEmployeeBtn").click(() => {
            $("#account").removeClass('borderBottomRed').val("");
            $("#name").removeClass('borderBottomRed').val("");
            $("#email").removeClass('borderBottomRed').val("");
            $(".errMessage").empty();
            $(".creatEmpPermission").prop('checked', false);
            empPermissions = new Array();
        });

        //帳號欄位檢查
        $("#account").change(function () {
            getCheckAccountMessage(this.value);
        });

        //姓名欄位檢查
        $("#name").change(function () {
            getCheckNameMessage(this.value);
        });

        //信箱欄位檢查
        $("#email").change(function () {
            getCheckEmailMessage(this.value);
        });

        //新增員工送出
        $("#createSubBtn").click(() => {
            let employee = {
                'account': $("#account").val(),
                'name': $("#name").val(),
                'email': $("#email").val()
            };

            let errMessage = "";
            errMessage += getCheckAccountMessage(employee.account);
            errMessage += getCheckNameMessage(employee.name);
            errMessage += getCheckEmailMessage(employee.email);
            if (errMessage.length > 0) {
                alert(errMessage);
                return;
            }

            $.ajax({
                type: "POST",
                url: "/GameConsole/employee/insert",
                data: { 0: JSON.stringify(employee) }
            }).then(function (e) {
                e = organizeFormat(e);
                let json = JSON.parse(e);
                if (json.success === false) {
                    switch (json.errMessage) {
                        case '無此權限':
                        case '確認身份發生錯誤':
                            alert(json.errMessage + '將會重新整理頁面');
                            history.go(0);
                            return;
                        default:
                            alert(json.errMessage);
                    }
                } else if (json.result.result === true) {
                    alert('新增成功');

                    let date = new Date();
                    $('#createCloseBtn').trigger('click');
                    $('#dataShow').append(getEmployeeListView(
                        empUse,
                        json.result.id,
                        employee.account,
                        employee.name,
                        employee.email,
                        (new Date()).toLocaleString()
                    ));
                    updateListener();

                    //新增權限
                    $('input[class="creatEmpPermission"]:checked').each(function () {
                        empPermissions.push(this.value);
                    });
                    if (empPermissions.length >= 1) {
                        let permission = {
                            'empID': json.result.id,
                            'permissions': empPermissions
                        };

                        $.ajax({
                            type: "POST",
                            url: "/GameConsole/permission/insert",
                            data: { 0: JSON.stringify(permission) }
                        });
                    }
                } else {
                    alert('發生不明錯誤');
                }

            });
        });

    });

    //重設Btn監聽器
    function updateListener() {
        //權限按鈕
        $(".updatePermissionBtn").click(function () {
            $(".updatePermission").prop('checked', false);
            updatePermissionEmpID = $(this).parent().parent().children().html();
            console.log($(this).parent().parent().children().html());
            $.ajax({
                type: "GET",
                url: `/GameConsole/permission/getOneEmpPermissionList?ID=${updatePermissionEmpID}`
            }).then(function (e) {
                e = organizeFormat(e);
                console.log(e);
                let json = JSON.parse(e);
                if (json.success === false) {
                    switch (json.errMessage) {
                        case '無此權限':
                        case '確認身份發生錯誤':
                            alert(json.errMessage + '將會重新整理頁面');
                            history.go(0);
                            return;
                        default:
                            alert(json.errMessage);
                    }
                } else if (json.result.result === true) {

                    json.result.data.forEach(item => {
                        $(`.updatePermission[value=${item.permissionID}]`).prop('checked', true);
                    });

                }
            });
        });
    }

    //確認帳號並得到錯誤訊息內容
    function getCheckAccountMessage(value) {
        let checkMessage = $('#accountErrMessage');
        let input = $('#account');
        let returnStr = '帳號格式錯誤\r\n';

        checkMessage.empty();
        input.removeClass('borderBottomRed');

        //檢查重複
        $.ajax({
            type: "GET",
            url: `/GameConsole/employee/checkAccountExist?id=${value}`
        }).then(function (e) {
            e = organizeFormat(e);
            let json = JSON.parse(e);

            if (json.success === false) {
                alert(json.errMessage);
            } else if (json.result === true) {
                checkMessage.append("<br>此帳號有人使用<br>");
                input.addClass('borderBottomRed');
            }
        });

        //檢查格式
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

        <?php if (((isset($_smarty_tpl->tpl_vars['empUse']->value)) && $_smarty_tpl->tpl_vars['empUse']->value)) {?>
        <div class="text-right">
            <button class="btn btn-info " type="button" data-toggle="modal" data-target="#creatEmployeeModal"
                id="creatEmployeeBtn">新增員工</button>
        </div>
        <?php }?>


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


            <tbody id="dataShow">
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['employees']->value, 'emp');
$_smarty_tpl->tpl_vars['emp']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['emp']->value) {
$_smarty_tpl->tpl_vars['emp']->do_else = false;
?>
                <tr id="emp<?php echo $_smarty_tpl->tpl_vars['emp']->value['id'];?>
">
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
                    <td><button class="btn btn-info width100Percentage updatePermissionBtn" type="button"
                            data-toggle="modal" data-target="#updatePermissionModal">
                            <?php echo (isset($_smarty_tpl->tpl_vars['empUse']->value)) && $_smarty_tpl->tpl_vars['empUse']->value ? '修改' : '檢視';?>
權限
                        </button></td>
                </tr>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </tbody>



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
                        <table class="table table-hover">
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['permissions']->value, 'permission');
$_smarty_tpl->tpl_vars['permission']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['permission']->value) {
$_smarty_tpl->tpl_vars['permission']->do_else = false;
?>
                            <tr>
                                <td>
                                    <label><input type="checkbox" class="updatePermission"
                                            value="<?php echo $_smarty_tpl->tpl_vars['permission']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['permission']->value['name'];?>
</label>
                                </td>
                            </tr>
                            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        </table>

                    </div>
                    <?php if (((isset($_smarty_tpl->tpl_vars['empUse']->value)) && $_smarty_tpl->tpl_vars['empUse']->value)) {?>
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
        <?php if (((isset($_smarty_tpl->tpl_vars['empUse']->value)) && $_smarty_tpl->tpl_vars['empUse']->value)) {?>
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
                                        <table class="table table-hover table-bordered">
                                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['permissions']->value, 'permission');
$_smarty_tpl->tpl_vars['permission']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['permission']->value) {
$_smarty_tpl->tpl_vars['permission']->do_else = false;
?>
                                            <tr>
                                                <td>
                                                    <label><input type="checkbox" class="creatEmpPermission"
                                                            value="<?php echo $_smarty_tpl->tpl_vars['permission']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['permission']->value['name'];?>
</label>
                                                </td>
                                            </tr>
                                            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                        </table>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php if (((isset($_smarty_tpl->tpl_vars['empUse']->value)) && $_smarty_tpl->tpl_vars['empUse']->value)) {?>
                    <div class="modal-footer">
                        <!--底-->
                        <button type="button" class="btn btn-default" data-dismiss="modal"
                            id="createCloseBtn">取消</button>
                        <!--取消按鈕-->
                        <button type="button" class="btn btn-primary" id="createSubBtn">新增</button>
                        <!--送出-->
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
        <?php }?>
    </main><!-- /.container -->

</body>

</html><?php }
}
