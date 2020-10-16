<?php
/* Smarty version 3.1.34-dev-7, created on 2020-10-16 03:11:54
  from '/Applications/XAMPP/xamppfiles/htdocs/GameConsole/views/pageFront/oneCommodity.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f88f35ad43925_66596276',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2a59875c52c696939baeb8ef7104127865089344' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/GameConsole/views/pageFront/oneCommodity.html',
      1 => 1602810713,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./navigationBar.html' => 1,
  ),
),false)) {
function content_5f88f35ad43925_66596276 (Smarty_Internal_Template $_smarty_tpl) {
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

    <?php if (!((isset($_smarty_tpl->tpl_vars['commodity']->value['id'])))) {?>
    <meta http-equiv="refresh" content="0;url=/GameConsole/index/getIndexView">
    <?php }?>
</head>
<style>
    img {
        max-width: 100%;
        max-height: 100%;
        height: auto;
        width: auto;
    }

    input{
        width: 50%;
    }

    .showImg {
        max-width: 100%;
        height: 300px;
    }

    .width100Percentage {
        width: 100%;
    }

    .mainShow {
        position: absolute;
        top: 25%;
        left: 50%;
        transform: translate(-50%, -25%);
        height: 50%;
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
 src="/GameConsole/views/js/imgError.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/GameConsole/views/js/cookie.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>setCookie('lastPath', '/GameConsole/commodity/getOneView?id=<?php echo $_smarty_tpl->tpl_vars['commodity']->value["id"];?>
');<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    let commodityID = "<?php echo $_smarty_tpl->tpl_vars['commodity']->value['id'];?>
";

    $(window).ready(() => {

        $('#quantity').change(function () {
            getCheckQuantityMessage(this.value);
        });

        $('#sub').click(() => {
            let data = {
                'id': commodityID,
                'quantity': $('#quantity').val()
            }

            if ((errMessage = getCheckQuantityMessage(data.quantity)).length > 0) {
                alert(errMessage);
                return;
            }

            $.ajax({
                type: 'POST',
                url: '/GameConsole/commodity/addInShoppingCart',
                data: { 0: JSON.stringify(data) }
            }).then(function (e) {
                e = organizeFormat(e);
                let json = JSON.parse(e);
                console.log(json);
                if (json.success === false) {
                    alert(json.errMessage);
                } else if (json.result === true) {
                    alert('加入購物車');
                } else {
                    alert("發生不明錯誤");
                }
            });
        });
    });

    function getCheckQuantityMessage(value) {
        let checkMessage = $("#quantityCheckMessage");
        let input = $("#quantity");
        let returnStr = "購買數量少於1，你484有大膽的想法？";

        checkMessage.empty();
        input.removeClass('borderBottomRed');

        if (value < 1) {
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
    <main class="container text-center">
        <div class="mainShow">
            <h3><?php echo $_smarty_tpl->tpl_vars['commodity']->value['name'];?>
</h3>
            <div class="showImg">
                <img class="center-block" src="/GameConsole/commodity/getOneImg?ID=<?php echo $_smarty_tpl->tpl_vars['commodity']->value['id'];?>
">
            </div>
            <h3>價格：<?php echo $_smarty_tpl->tpl_vars['commodity']->value['price'];?>
</h3>
            <?php if ($_smarty_tpl->tpl_vars['commodity']->value['quantity'] > 0) {?>
            <div>
                購買數量：<input type="number" max="<?php echo $_smarty_tpl->tpl_vars['commodity']->value['quantity'];?>
" min="1" value="1" id="quantity">
            </div>
            <p id="quantityCheckMessage"></p>
            <div>
                <button type="button" id="sub">加入購物車</button>
            </div>
            <?php } else { ?>
            <h3 class="text-danger">此商品已售完</h3>
            <?php }?>
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
