<?php
/* Smarty version 3.1.34-dev-7, created on 2020-10-16 03:05:14
  from '/Applications/XAMPP/xamppfiles/htdocs/GameConsole/views/pageFront/index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f88f1caa678d3_86856743',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f112382ef2a0ba7f9eda2ec02fa42c2086bc4b63' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/GameConsole/views/pageFront/index.html',
      1 => 1602754646,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./navigationBar.html' => 1,
  ),
),false)) {
function content_5f88f1caa678d3_86856743 (Smarty_Internal_Template $_smarty_tpl) {
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
        max-height: 100%;
        height: auto;
    }

    .oneCommodity {
        height: 250px;
        margin-bottom: 50px;
    }

    .showImgDiv {
        padding: 0;
        margin: 0;
        height: 150px;
    }

    .vcenter {
        float: none;
        display: inline-block;
        vertical-align: middle;
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
 src="/GameConsole/views/js/imgError.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/GameConsole/views/js/cookie.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>setCookie('lastPath', '/GameConsole/index');<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    let offset = '<?php if ((isset($_smarty_tpl->tpl_vars['offset']->value))) {
echo $_smarty_tpl->tpl_vars['offset']->value;
}?>';
    offset = parseInt(offset);
    let stopSet = '<?php if ((isset($_smarty_tpl->tpl_vars['stopSet']->value))) {
echo $_smarty_tpl->tpl_vars['stopSet']->value;
}?>';
    stopSet = parseInt(stopSet);
    let getItemProcessing = false;
    let seletStr = '';
    let condition = 'newToOld';

    $(window).ready(() => {
        // console.log(getCookie('lastPageaaa'));
        // console.log(setCookie('empName', 'FF'));
        // console.log(deleteCookie('lastPage'));

        //回最頂按鈕
        $(".topImgBtn").click(() => {
            $("html,body").animate({
                scrollTop: 0
            }, 1000);
        });

        //滾動監聽器
        $(window).scroll(function (e) {
            console.log($('.showImg').length);
            console.log($('.showImg').get(0));
            let windowBottom = $(this).height() + $(this).scrollTop();
            console.log('window bottom' + windowBottom);
            console.log('body ' + $('body').height());

            if (isNaN(offset) || offset < 0 || isNaN(stopSet) || stopSet < 0) {
                $(this).off('scroll');
                return;
            }

            if ((windowBottom >= ($('body').height() * 0.7)) && !getItemProcessing) {
                getData(true);
            }

        }).trigger('scroll');

        //搜尋
        $('#seletText').on('input propertychange', () => {
            seletStr = $('#seletText').val();
            offset = 0;
            if (seletStr.length <= 0) {
                $('#dataShow').empty();
            }

            getData();
        });

        //條件按鈕
        $('.conditionBtn').click(function () {
            $('.conditionBtn').parent().find('.btn-primary').removeClass('btn-primary').addClass('btn-light');
            $(this).removeClass('btn-light').addClass('btn-primary');
            condition = this.id;
            offset = 0;
            getData();
        });

    });

    function getData(isScroll = false) {

        if (!isScroll) {
            $('#dataShow').empty();
        }

        if (offset >= stopSet) {
            return;
        }

        let data = {
            'names': seletStr,
            'condition': condition,
            'offset': offset
        };

        //當沒搜尋條件時
        if (seletStr.length <= 0) {
            getItemProcessing = true;
            $.ajax({
                type: 'GET',
                url: `/GameConsole/commodity/getSomeCanBuyDate`,
                data: { 0: JSON.stringify(data) }
            }).then(function (e) {
                getItemProcessing = false;
                e = organizeFormat(e);
                let json = JSON.parse(e);
                if (json.success === true) {
                    for (let item of json.result.data) {
                        $('#dataShow').append(getCommodityItemView(
                            item.id,
                            item.name,
                            item.price,
                            item.quantity
                        ));
                    }
                    setOnImgErrListener();
                    offset += json.result.data.length;
                    stopSet = parseInt(json.result.stopSet);
                    $(window).trigger('scroll');
                }
            });
        }

        //當有搜尋條件時
        if (seletStr.length > 0) {
            getItemProcessing = true;
            $.ajax({
                type: 'GET',
                url: `/GameConsole/commodity/getSomeByName`,
                data: { 0: JSON.stringify(data) }
            }).then(function (e) {
                getItemProcessing = false;
                e = organizeFormat(e);
                let json = JSON.parse(e);
                console.log(json);
                if (json.success === false) {
                    $('#dataShow').html(getSeleteNullView(json.errMessage));
                    return;
                }

                for (let item of json.result.data) {
                    $('#dataShow').append(getCommodityItemView(
                        item.id,
                        item.name,
                        item.price,
                        item.quantity
                    ));
                }
                setOnImgErrListener();
                offset += json.result.data.length;
                stopSet = parseInt(json.result.stopSet);
                $(window).trigger('scroll');
            });
        }

    }

<?php echo '</script'; ?>
>

<body>
    <?php $_smarty_tpl->_subTemplateRender('file:./navigationBar.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    <div class="blank"></div>
    <main class="container">

        <div class="row">
            <div class="col-xs-12 col-sm-9">
                <button class="conditionBtn btn btn-primary" id="newToOld">上市日期：新到舊</button>
                <button class="conditionBtn btn btn-light" id="oldToNew">上市日期：舊到新</button>
                <button class="conditionBtn btn btn-light" id="cheapToExpensive">價格：低到高</button>
                <button class="conditionBtn btn btn-light" id="expensiveToCheap">價格：高到低</button>
            </div>
            <div class="col-xs-12 col-sm-3">
                <div class="input-group">
                    <input type="text" class="form-control" id="seletText" placeholder="請輸入關鍵字">
                </div>
            </div>
        </div>

        <hr>

        <div class="row text-center" id="dataShow">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['commoditys']->value, 'commodity');
$_smarty_tpl->tpl_vars['commodity']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['commodity']->value) {
$_smarty_tpl->tpl_vars['commodity']->do_else = false;
?>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2 bg-light text-dark">
                <div class="oneCommodity text-center">
                    <a href="/GameConsole/commodity/getOneView?id=<?php echo $_smarty_tpl->tpl_vars['commodity']->value['id'];?>
">
                        <div class="showImgDiv">
                            <img class="center-block vcenter showImg" id="img<?php echo $_smarty_tpl->tpl_vars['commodity']->value['id'];?>
"
                                src="/GameConsole/commodity/getOneImg?id=<?php echo $_smarty_tpl->tpl_vars['commodity']->value['id'];?>
">
                        </div>
                        <h3>價格：<?php echo $_smarty_tpl->tpl_vars['commodity']->value['price'];?>
</h3>
                        <h4><?php echo $_smarty_tpl->tpl_vars['commodity']->value['name'];?>
</h4>
                    </a>
                    <?php if ($_smarty_tpl->tpl_vars['commodity']->value['quantity'] <= 0) {?>
                    <h3 class="text-danger">已售完</h3>
                    <?php }?>
                </div>
            </div>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </div>

    </main><!-- /.container -->

</body>
<?php echo '<script'; ?>
>
    setOnImgErrListener();
<?php echo '</script'; ?>
>

</html><?php }
}
