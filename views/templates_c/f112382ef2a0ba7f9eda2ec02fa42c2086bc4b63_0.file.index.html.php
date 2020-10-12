<?php
/* Smarty version 3.1.34-dev-7, created on 2020-10-12 09:58:05
  from '/Applications/XAMPP/xamppfiles/htdocs/GameConsole/views/pageFront/index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f840c8d87dba2_33344346',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f112382ef2a0ba7f9eda2ec02fa42c2086bc4b63' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/GameConsole/views/pageFront/index.html',
      1 => 1602487320,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./navigationBar.html' => 1,
  ),
),false)) {
function content_5f840c8d87dba2_33344346 (Smarty_Internal_Template $_smarty_tpl) {
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
        height: auto;
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
    let lastID = '<?php if ((isset($_smarty_tpl->tpl_vars['lastID']->value))) {
echo $_smarty_tpl->tpl_vars['lastID']->value;
}?>';
    lastID = parseInt(lastID);
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

            if (isNaN(lastID) || lastID <= 0) {
                $(this).off('scroll');
                return;
            }

            if ((windowBottom >= ($('body').height() * 0.7)) && !getItemProcessing && lastID > 1) {
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

    });

<?php echo '</script'; ?>
>

<body>
    <?php $_smarty_tpl->_subTemplateRender('file:./navigationBar.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    <div class="blank"></div>

    <main class="container">
        <img class="topImgBtn" src="/GameConsole/views/img/top.png" alt="">

        <div class="row">

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
                        <img class="img-responsive" src="/GameConsole/commodity/getOneImg?ID=<?php echo $_smarty_tpl->tpl_vars['commodity']->value['id'];?>
"
                            onerror="javascript:this.src='/GameConsole/views/img/gravatar.jpg'">
                        <h3>價格：<?php echo $_smarty_tpl->tpl_vars['commodity']->value['price'];?>
</h3>
                        <h4><?php echo $_smarty_tpl->tpl_vars['commodity']->value['name'];?>
</h4>
                    </a>
                </div>
            </div>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>



        </div>

    </main><!-- /.container -->

</body>

</html><?php }
}
