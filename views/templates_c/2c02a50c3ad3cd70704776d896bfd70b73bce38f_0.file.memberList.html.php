<?php
/* Smarty version 3.1.34-dev-7, created on 2020-10-15 05:37:03
  from '/Applications/XAMPP/xamppfiles/htdocs/GameConsole/views/pageBack/memberList.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f87c3df886461_80762660',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2c02a50c3ad3cd70704776d896bfd70b73bce38f' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/GameConsole/views/pageBack/memberList.html',
      1 => 1602573572,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./navigationBar.html' => 1,
  ),
),false)) {
function content_5f87c3df886461_80762660 (Smarty_Internal_Template $_smarty_tpl) {
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

    .showOrder {
        padding: 0;
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
 src="/GameConsole/views/js/viewModels/memberViewModel.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    let memUse = '<?php if ((isset($_smarty_tpl->tpl_vars['memUse']->value)) && $_smarty_tpl->tpl_vars['memUse']->value) {
echo $_smarty_tpl->tpl_vars['memUse']->value;
}?>';
    memUse = (memUse.length > 0 || memUse === '1') ? true : false;
    let getItemProcessing = false;//取得其他項目執行狀態
    let getLastIDProcessing = false;//取得最後ID執行狀態
    let lastID = '<?php if ((isset($_smarty_tpl->tpl_vars['lastID']->value))) {
echo $_smarty_tpl->tpl_vars['lastID']->value;
}?>';
    let showLastID = '<?php if ((isset($_smarty_tpl->tpl_vars['showLastID']->value))) {
echo $_smarty_tpl->tpl_vars['showLastID']->value;
}?>';
    lastID = parseInt(lastID);
    showLastID = parseInt(showLastID);

    $(window).ready(() => {
        //回最頂按鈕
        $('.topImgBtn').click(() => {
            $('html,body').animate({
                scrollTop: 0
            }, 1000);
        });

        //滾動監聽器
        $(window).scroll(function (e) {
            let windowBottom = $(this).height() + $(this).scrollTop();
            console.log('window bottom' + windowBottom);
            console.log('body ' + $('body').height());

            if (isNaN(lastID) || isNaN(showLastID)) {
                $(this).off('scroll');
                return;
            }

            if (!getLastIDProcessing && showLastID >= lastID) {
                getLastIDProcessing = true;
                setTimeout(function () {
                    $.ajax({
                        type: 'GET',
                        url: '/GameConsole/member/getLastID'
                    }).then(function (e) {
                        e = organizeFormat(e);
                        let json = JSON.parse(e);
                        if (json.success === false) {
                            return;
                        }
                        lastID = parseInt(json.result);
                    });
                }, 1000);
            }

            if ((windowBottom >= ($('body').height() * 0.7)) && !getItemProcessing && showLastID < lastID) {
                getItemProcessing = true;
                $.ajax({
                    type: 'GET',
                    url: `/GameConsole/member/getSome?lastID=${showLastID}`
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
                    lastID = parseInt(json.result.lastID);
                    for (let item of json.result.data) {
                        $('#dataShow').append(getMemberListView(
                            memUse,
                            item.id,
                            item.account,
                            item.name,
                            item.email,
                            item.phone,
                            item.status,
                            item.creationDatetime,
                            (item.changeDatetime === null) ? '' : item.changeDatetime
                        ));
                        showLastID = parseInt(item.id);
                    }
                    getOrderListBtnListener();//訂單查看
                    getChangeStatusBtnListener();//權限修改

                    getItemProcessing = false;
                });
            }
        }).trigger('scroll');

        //有使用權限者才可使用功能
        if (memUse) {
            getOrderListBtnListener();//訂單查看
            getChangeStatusBtnListener();//權限修改
        }

    });


    function showDetailsBtnListener() {
        $('.showDetailsBtn').off('click').click(function () {
            let orderID = $(this).closest('div[class="oneOrder"]').find('.orderID').html();
            let showDetails = $(`#showDetails${orderID}`);
            let button = $(this);

            if (showDetails.html().length > 0) {
                showDetails.empty();
                button.text('查看明細');
                return;
            }

            let data = {
                'orderID': orderID,
                'commodityID': null
            }

            $.ajax({
                type: 'GET',
                url: '/GameConsole/order/getOrderDetail',
                data: { 0: JSON.stringify(data) }
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
                            return;
                    }
                    return;
                }

                button.text('關閉明細');
                for (let item of json.result) {
                    // console.log(item['commodityID']);
                    showDetails.append(getDetailsListView(
                        item['name'],
                        item['price'],
                        item['quantity']
                    ));
                }
            });
        });

    }

<?php echo '</script'; ?>
>
<?php if ((isset($_smarty_tpl->tpl_vars['memUse']->value)) && $_smarty_tpl->tpl_vars['memUse']->value) {
echo '<script'; ?>
>

    function getOrderListBtnListener() {
        $('.orderListBtn').off('click').click(function () {
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
                    switch (json.errMessage) {
                        case '無此權限':
                        case '確認身份發生錯誤':
                            alert(json.errMessage + '將會重新整理頁面');
                            history.go(0);
                            return;
                        default:
                            alert(json.errMessage);
                    }
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

                showDetailsBtnListener();

            });
        });
    }

    function getChangeStatusBtnListener() {
        //狀態更改
        $('.status').off('click').click(function () {
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
                    switch (json.errMessage) {
                        case '無此權限':
                        case '確認身份發生錯誤':
                            alert(json.errMessage + '將會重新整理頁面');
                            history.go(0);
                            return;
                        default:
                            alert(json.errMessage);
                    }
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
    }
<?php echo '</script'; ?>
>
<?php }?>

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
                    <?php if ((isset($_smarty_tpl->tpl_vars['memUse']->value)) && $_smarty_tpl->tpl_vars['memUse']->value) {?>
                    <th></th>
                    <?php }?>
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
                    <?php if ((isset($_smarty_tpl->tpl_vars['memUse']->value)) && $_smarty_tpl->tpl_vars['memUse']->value) {?>
                    <td>
                        <button type="button" class="btn btn-info width100 orderListBtn">開啟訂單記錄</button>
                    </td>
                    <?php }?>
                </tr>
                <tr class="hidden memberOrders info">
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
