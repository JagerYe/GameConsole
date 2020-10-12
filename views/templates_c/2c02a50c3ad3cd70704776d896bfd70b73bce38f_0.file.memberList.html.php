<?php
/* Smarty version 3.1.34-dev-7, created on 2020-10-12 12:01:33
  from '/Applications/XAMPP/xamppfiles/htdocs/GameConsole/views/pageBack/memberList.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f84297d805bd7_73125863',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2c02a50c3ad3cd70704776d896bfd70b73bce38f' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/GameConsole/views/pageBack/memberList.html',
      1 => 1602496891,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./navigationBar.html' => 1,
  ),
),false)) {
function content_5f84297d805bd7_73125863 (Smarty_Internal_Template $_smarty_tpl) {
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
    <?php if (!((isset($_smarty_tpl->tpl_vars['memSee']->value)))) {?>
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

    .width100 {
        width: 100%;
    }

    .hidden {
        visibility: hidden;
    }
</style>
<?php echo '<script'; ?>
 src="/GameConsole/views/js/jsonFormat.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/GameConsole/views/js/title.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/GameConsole/views/js/viewModels/orderViewModel.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>

    $(window).ready(() => {
        //回最頂按鈕
        $('.topImgBtn').click(() => {
            $('html,body').animate({
                scrollTop: 0
            }, 1000);
        });

        //訂單紀錄
        $('.orderListBtn').click(function () {
            let buttonThis = $(this);
            buttonThis.closest('.oneMember').next().toggleClass('hidden');

            //如有開啟時關閉
            if (buttonThis.closest('.oneMember').next('.memberOrders').find('.showOrder').html().length > 0) {
                buttonThis.text('開啟訂單記錄').closest('.oneMember').next('.memberOrders').find('.showOrder').empty();
                return;
            }

            let data = {
                'id': buttonThis.closest('.oneMember').find('.memberID').text(),
                'lastShowOrderID': null
            };

            $.ajax({
                type: "GET",
                url: "/GameConsole/order/getMemberOrder",
                data: { 0: JSON.stringify(data) }
            }).then(function (e) {
                e = organizeFormat(e);
                let json = JSON.parse(e);
                console.log(json);

                if (json.success === false) {
                    buttonThis.closest('.oneMember').next().toggleClass('hidden');
                    alert(json.errMessage);
                    return;
                }
                if (json.result === false) {
                    buttonThis.closest('.oneMember').next().toggleClass('hidden');
                    alert('你是怎麼做到的？');
                    return;
                }

                for (let item of json.result) {
                    buttonThis.text('關閉訂單記錄').closest('.oneMember').next('.memberOrders').find('.showOrder')
                        .append(getOrderListView(item.orderID, item.creationDatetime, item.total));
                }





            });
        });

        //狀態更改
        $('.status').click(function () {
            let button = $(this);
            let buttonClass = this.className.substring(this.className.lastIndexOf('btn'), this.className.length);
            let status = (buttonClass === 'btn-success') ? true : false;

            if (!confirm(`確定要${status ? '停用' : '啟用'}該會員？`)) {
                return;
            }

            let data = {
                'id': $(this).closest('.oneMember').find('.memberID').text(),
                'status': !status
            };

            $.ajax({
                type: "PUT",
                url: "/GameConsole/member/updateStatus",
                data: { 0: JSON.stringify(data) }
            }).then(function (e) {
                e = organizeFormat(e);
                let json = JSON.parse(e);
                console.log(json);

                if (json.success === false) {
                    alert(json.errMessage);
                    return;
                }
                if (json.result === true) {
                    if (status) {
                        button.removeClass('btn-success').addClass('btn-danger').text('停用');
                    } else {
                        button.removeClass('btn-danger').addClass('btn-success').text('啟用');
                    }

                }
            });

        });
    });

<?php echo '</script'; ?>
>

<body>
    <?php $_smarty_tpl->_subTemplateRender('file:./navigationBar.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    <div class="blank"></div>

    <main class="container">
        <img class="topImgBtn" src="/GameConsole/views/img/top.png" alt="">

        <table class="table table-hover table-bordered" id="mainShow">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>帳號</th>
                    <th>姓名</th>
                    <th>email</th>
                    <th>電話</th>
                    <th>目前狀態</th>
                    <th>創立時間</th>
                    <th>修改資料時間</th>
                    <th></th>
                </tr>
            </thead>


            <tbody id="dataShow">
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['members']->value, 'member');
$_smarty_tpl->tpl_vars['member']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['member']->value) {
$_smarty_tpl->tpl_vars['member']->do_else = false;
?>
                <tr class="oneMember">
                    <td class="memberID"><?php echo $_smarty_tpl->tpl_vars['member']->value['id'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['member']->value['account'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['member']->value['name'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['member']->value['email'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['member']->value['phone'];?>
</td>
                    <td>
                        <?php if ($_smarty_tpl->tpl_vars['member']->value['status'] === '1') {?>
                        <button type="button" class="status width100 btn btn-success">啟用</button>
                        <?php } else { ?>
                        <button type="button" class="status width100 btn btn-danger">停用</button>
                        <?php }?>
                    </td>
                    <td><?php echo $_smarty_tpl->tpl_vars['member']->value['creationDatetime'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['member']->value['changeDatetime'];?>
</td>
                    <td>
                        <button type="button" class="btn btn-info width100 orderListBtn">開啟訂單記錄</button>
                    </td>
                </tr>
                <tr class="hidden memberOrders">
                    <td></td>
                    <td class="showOrder" colspan="8"></td>
                </tr>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </tbody>



        </table>
    </main><!-- /.container -->

</body>

</html><?php }
}
