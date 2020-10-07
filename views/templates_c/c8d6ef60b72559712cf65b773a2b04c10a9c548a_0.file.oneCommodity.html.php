<?php
/* Smarty version 3.1.34-dev-7, created on 2020-10-07 18:32:18
  from 'C:\xampp\htdocs\GameConsole\views\pageFront\oneCommodity.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f7ded92a15268_30079458',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c8d6ef60b72559712cf65b773a2b04c10a9c548a' => 
    array (
      0 => 'C:\\xampp\\htdocs\\GameConsole\\views\\pageFront\\oneCommodity.html',
      1 => 1602088331,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./navigationBar.html' => 1,
  ),
),false)) {
function content_5f7ded92a15268_30079458 (Smarty_Internal_Template $_smarty_tpl) {
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
        height: auto;
    }

    .width100Percentage {
        width: 100%;
    }

    .mainShow {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
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
					alert('購買成功');
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
    <main class="container">
        <div class="mainShow">
            <h3><?php echo $_smarty_tpl->tpl_vars['commodity']->value['name'];?>
</h3>
            <div>
                <img src="/GameConsole/commodity/getOneImg?ID=<?php echo $_smarty_tpl->tpl_vars['commodity']->value['id'];?>
"
                    onerror="javascript:this.src='/GameConsole/views/img/gravatar.jpg'">
            </div>
            <p>價格：<?php echo $_smarty_tpl->tpl_vars['commodity']->value['price'];?>
</p>
            <div>
                購買數量：<input type="number" max="<?php echo $_smarty_tpl->tpl_vars['commodity']->value['quantity'];?>
" min="1" value="1" id="quantity">
            </div>
            <p id="quantityCheckMessage"></p>
            <div>
                <button type="button" id="sub">加入購物車</button>
            </div>
        </div>
    </main><!-- /.container -->

</body>

</html><?php }
}
