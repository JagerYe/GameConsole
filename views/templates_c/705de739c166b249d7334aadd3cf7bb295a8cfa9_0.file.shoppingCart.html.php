<?php
/* Smarty version 3.1.34-dev-7, created on 2020-10-08 12:02:45
  from '/Applications/XAMPP/xamppfiles/htdocs/GameConsole/views/pageFront/shoppingCart.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f7ee3c5801f64_61334897',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '705de739c166b249d7334aadd3cf7bb295a8cfa9' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/GameConsole/views/pageFront/shoppingCart.html',
      1 => 1602151356,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./navigationBar.html' => 1,
  ),
),false)) {
function content_5f7ee3c5801f64_61334897 (Smarty_Internal_Template $_smarty_tpl) {
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
    img {
        max-width: 100%;
        max-height: 150px;
    }

    .width100Percentage {
        width: 100%;
    }

    .oneItem {
        margin-bottom: 10px;
    }

    .itemText {
        font-size: 20px;
    }
</style>
<?php echo '<script'; ?>
 src="/GameConsole/views/js/jsonFormat.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/GameConsole/views/js/title.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/GameConsole/views/js/viewModels/commodityViewModel.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    let lastID = '<?php echo $_smarty_tpl->tpl_vars['lastID']->value;?>
';
    let cartSize = '<?php echo $_smarty_tpl->tpl_vars['cartSize']->value;?>
';
    lastID = parseInt(lastID);
    cartSize = parseInt(cartSize);
    let getItemProcessing = false;

    $(window).ready(() => {
        //回最頂按鈕
        $(".topImgBtn").click(() => {
            $("html,body").animate({
                scrollTop: 0
            }, 1000);
        });

        //滾動監聽器
        $(window).scroll(function (e) {
            let windowBottom = $(this).height() + $(this).scrollTop();
            console.log('window bottom' + windowBottom);
            console.log('body ' + $('body').height());
            if ((windowBottom >= ($('body').height() * 0.7)) && !getItemProcessing && (cartSize > lastID + 1)) {
                getItemProcessing = true;
                $.ajax({
                    type: 'GET',
                    url: `/GameConsole/commodity/getSomeData?id=${lastID}`
                }).then(function (e) {
                    e = organizeFormat(e);
                    let json = JSON.parse(e);
                    if (json.success === true) {
                        for (let item of json.result) {
                            $('#dataShow').append(getCommodityItemView(
                                item.id,
                                item.name,
                                item.price
                            ));
                            lastID = item.id;
                        }

                    } else {
                        alert(json.errMessage);
                    }
                    getItemProcessing = false;
                });
            }
        }).trigger('scroll');

        //購買數量欄位
        $('.quantity').change(function () {
            if ((errMessage = getCheckQuantityMessage(this.value, this.id)).length > 0) {
                alert(errMessage);
                return;
            }

            let id = this.id.substring(11, this.id.length)
            let data = {
                'id': id,
                'quantity': this.value
            };

            $.ajax({
                type: "PUT",
                url: "/GameConsole/commodity/updateInShoppingCart",
                data: { 0: JSON.stringify(data) }
            }).then(function (e) {
                e = organizeFormat(e);
                let json = JSON.parse(e);

                if (json.success === false) {
                    alert(json.errMessage);
                    return;
                }
                if (json.result === true) {
                    $.ajax({
                        type: "PUT",
                        url: "/GameConsole/commodity/getShoppingCartTotal"
                    }).then(function (e) {
                        e = organizeFormat(e);
                        let json = JSON.parse(e);

                        if (json.success === false) {
                            alert(json.errMessage);
                            return;
                        }

                        $('#total').text(`總金額：${json.result}`);
                    });
                }
            });
        });

        //刪除按鈕
        $('.deleteBtn').click(function () {

            let id = this.id.substring(9, this.id.length);
            let data = { 'id': id };

            $.ajax({
                type: 'DELETE',
                url: '/GameConsole/commodity/deleteInShoppingCart',
                data: { 0: JSON.stringify(data) }
            }).then(function (e) {
                e = organizeFormat(e);
                let json = JSON.parse(e);

                if (json.success === false) {
                    alert(json.errMessage);
                    return
                }
                if (json.result === true) {
                    $(`#oneItem${id}`).remove();
                }
            });
        });

        //新增按鈕
        $('#checkoutBtn').click(() => {
            if (!confirm('確定剁手手？')) {
                return;
            }

            $.ajax({
                type: 'POST',
                url: '/GameConsole/order/insert'
            }).then(function (e) {
                e = organizeFormat(e);
                let json = JSON.parse(e);

                if (json.success === false) {
                    alert(json.errMessage);
                    return
                }
                if (json.result === true) {
                    window.location.href = "/GameConsole/order/getMemOrderListView";
                }
            });
        });

    });

    //確認姓名並得到錯誤訊息內容
    function getCheckQuantityMessage(value, id) {
        let input = $(`#${id}`);
        let returnStr = '購買數量少於1，請把大膽的想法收起來！';
        input.parent().removeClass('has-error');
        if (value < 1) {
            input.parent().addClass('has-error');
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


        <div class="row oneItem width100Percentage">
            <div class="col-xs-3"></div>
            <div class="col-xs-2">
                <h3>商品名稱</h3>
            </div>
            <div class="col-xs-2">
                <h3>商品價格</h3>
            </div>
            <div class="col-xs-3">
                <h3>購買數量</h3>
            </div>
            <div class="col-xs-2"></div>
        </div>

        <div class="showData">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['shoppingCart']->value, 'item');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
            <div class="row oneItem width100Percentage" id="oneItem<?php echo $_smarty_tpl->tpl_vars['item']->value->id;?>
">
                <div class="col-xs-3">
                    <img src="/GameConsole/commodity/getOneImg?ID=<?php echo $_smarty_tpl->tpl_vars['item']->value->id;?>
"
                        onerror="javascript:this.src='/GameConsole/views/img/gravatar.jpg'">
                </div>
                <div class="col-xs-2 itemText"><?php echo $_smarty_tpl->tpl_vars['item']->value->name;?>
</div>
                <div class="col-xs-2 itemText"><?php echo $_smarty_tpl->tpl_vars['item']->value->price;?>
</div>
                <div class="col-xs-3 ">
                    <input type="number" class="width100Percentage quantity form-control" id="buyQuantity<?php echo $_smarty_tpl->tpl_vars['item']->value->id;?>
"
                        max="<?php echo $_smarty_tpl->tpl_vars['item']->value->maxQuantity;?>
" min="1" value="<?php echo $_smarty_tpl->tpl_vars['item']->value->quantity;?>
">
                </div>
                <div class="col-xs-2">
                    <button class="width100Percentage deleteBtn" id="deleteBtn<?php echo $_smarty_tpl->tpl_vars['item']->value->id;?>
">刪除</button>
                </div>
            </div>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </div>

        <div class="row oneItem width100Percentage">
            <div class="col-xs-7"></div>
            <div class="col-xs-5 text-right">

            </div>
        </div>

        <div class="text-right">
            <h2 id="total">
                總金額：<?php echo $_smarty_tpl->tpl_vars['total']->value;?>

            </h2>
            <?php if ((isset($_smarty_tpl->tpl_vars['isLogin']->value)) && $_smarty_tpl->tpl_vars['isLogin']->value) {?>
            <button class="btn btn-info " type="button" data-toggle="modal" data-target="#creatEmployeeModal"
                id="checkoutBtn">結帳</button>
            <?php } else { ?>
            <h2>如需購買請先登入</h2>
            <?php }?>
        </div>

        <!-- 此為墊高畫面用 -->
        <div style="height: 50px;"></div>

    </main><!-- /.container -->

</body>

</html><?php }
}
