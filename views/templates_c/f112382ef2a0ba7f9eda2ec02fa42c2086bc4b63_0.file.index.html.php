<?php
/* Smarty version 3.1.34-dev-7, created on 2020-10-07 11:15:27
  from '/Applications/XAMPP/xamppfiles/htdocs/GameConsole/views/pageFront/index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f7d872f1459d9_14729440',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f112382ef2a0ba7f9eda2ec02fa42c2086bc4b63' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/GameConsole/views/pageFront/index.html',
      1 => 1602062125,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./navigationBar.html' => 1,
  ),
),false)) {
function content_5f7d872f1459d9_14729440 (Smarty_Internal_Template $_smarty_tpl) {
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

    .width100Percentage {
        width: 100%;
    }

    table{
        background-color: rgba(70, 4, 100, 0.3);
    }
</style>
<!-- <?php echo '<script'; ?>
 src="/GameConsole/views/js/jsonFormat.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/GameConsole/views/js/title.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/GameConsole/views/js/rule.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/GameConsole/views/js/viewModels/commodityViewModel.js"><?php echo '</script'; ?>
> -->
<!-- <?php echo '<script'; ?>
>
    let comSee = '<?php echo (isset($_smarty_tpl->tpl_vars['comSee']->value)) && $_smarty_tpl->tpl_vars['comSee']->value;?>
';
    let updateID = -1;
    let lastID = '<?php echo $_smarty_tpl->tpl_vars['lastID']->value;?>
';
    let getItemProcessing = false;

    $(window).ready(() => {
        //回最頂按鈕
        $(".topImgBtn").click(() => {
            $("html,body").animate({
                scrollTop: 0
            }, 1000);
        });

        //阻止無觀看權限者
        if (comSee !== '1') {
            window.location.href = "/GameConsole/index/getBackIndexView";
        }

        //滾動監聽器
        $(window).scroll(function (e) {
            let windowBottom = $(this).height() + $(this).scrollTop();
            console.log('window bottom' + windowBottom);
            console.log('body ' + $('body').height());
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
                            $('#dataShow').append(getEmpInsertCommodityItemView(
                                item.id,
                                item.name,
                                item.price,
                                item.quantity,
                                item.status,
                                item.creationDatetime,
                                (item.changeDatetime === null) ? '' : item.changeDatetime
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

        //更新按鈕
        $(".updateBtn").click(function () {
            updateID = $(this).parent().parent().children().html();
            $.ajax({
                type: 'GET',
                url: `/GameConsole/commodity/getOneData?id=${updateID}`
            }).then(function (e) {
                e = organizeFormat(e);
                let json = JSON.parse(e);
                if (json.success === true) {
                    $('#name').val(json.result.name).trigger('change');
                    $('#price').val(json.result.price).trigger('change');
                    $('#quantity').val(json.result.quantity).trigger('change');
                    $('#status').prop('checked', (json.result.status === '1'));
                    $('#picturePreview').attr('src', `/GameConsole/commodity/getOneImg?id=${updateID}`);
                } else {
                    alert(json.errMessage);
                }
            });
        });

        //新增按鈕
        $("#creatBtn").click(function () {
            updateID = -1;
            $('#name').val("1").trigger('change').val("");
            $('#price').val("").trigger('change');
            $('#quantity').val("").trigger('change');
            $('#status').prop('checked', false);
            $('#picturePreview').attr('src', '');
        });



        //下列為 Modal 控制用－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－

        //名稱欄位檢查
        $('#name').change(function () {
            getCheckNameMessage(this.value);
        });

        //價格欄位檢查
        $('#price').change(function () {
            getCheckPriceMessage(this.value);
        });


        //庫存欄位檢查
        $('#quantity').change(function () {
            getCheckQuantityMessage(this.value);
        });

        //圖片新增按鈕
        $('#inputImage').change(function () {
            if (this.files && getCheckImage(this.files[0])) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $('#picturePreview').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            } else {
                alert('檔案格式錯誤');
                $('#inputImage').val('');
                $('#picturePreview').attr('src', `/GameConsole/commodity/getOneImg?id=${updateID}`);
            }
        });

        //送出按鈕
        $("#subBtn").click(function () {
            let data = {
                id: updateID,
                name: $('#name').val(),
                price: $('#price').val(),
                quantity: $('#quantity').val(),
                status: $('#status').prop('checked')
            };

            let errMessage = '';
            let errMessage2 = '';
            errMessage += getCheckNameMessage(data.name);
            errMessage += getCheckPriceMessage(data.price);
            errMessage2 = getCheckQuantityMessage(data.quantity);
            if (errMessage.length > 0) {
                alert(errMessage + errMessage2);
                return;
            }
            if (errMessage2.length > 0 && !confirm(errMessage2 + '確定要繼續執行？')) {
                return;
            }

            let img;
            let canUpdateImg = false;
            if ((img = $('#inputImage').get(0).files[0]) && getCheckImage(img)) {
                canUpdateImg = true;
            }

            if (updateID < 0) {
                //新增
                $.ajax({
                    type: 'POST',
                    url: `/GameConsole/commodity/insert`,
                    data: { 0: JSON.stringify(data) }
                }).then(function (e) {
                    e = organizeFormat(e);
                    let json = JSON.parse(e);
                    console.log(json);
                    if (json.success === false) {
                        alert(json.errMessage);
                    } else if (json.result.result === true) {
                        //更新圖片
                        if (canUpdateImg) {
                            updateImg(json.result.id, img);
                        }

                        //從資料庫撈資料
                        $.ajax({
                            type: 'GET',
                            url: `/GameConsole/commodity/getOneData?id=${json.result.id}`
                        }).then(function (e) {
                            e = organizeFormat(e);
                            let json = JSON.parse(e);
                            if (json.success === true) {
                                $('#dataShow').prepend(getEmpInsertCommodityItemView(
                                    json.result.id,
                                    json.result.name,
                                    json.result.price,
                                    json.result.quantity,
                                    json.result.status,
                                    json.result.creationDatetime,
                                    (json.result.changeDatetime === null) ? '' : json.result.changeDatetime
                                ));
                            } else {
                                alert(json.errMessage);
                            }
                        });

                        $('#closeBtn').trigger('click');
                    } else {
                        alert('發生不明錯誤');
                    }
                });
            } else {
                //更新

                //更新圖片
                if (canUpdateImg) {
                    updateImg(updateID, img);
                }

                //更新資料
                $.ajax({
                    type: 'PUT',
                    url: '/GameConsole/commodity/update',
                    data: { 0: JSON.stringify(data) }
                }).then(function (e) {
                    e = organizeFormat(e);
                    let json = JSON.parse(e);
                    if (json.success === false) {
                        alert(json.errMessage);
                    } else if (json.result === true) {
                        $.ajax({
                            type: 'GET',
                            url: `/GameConsole/commodity/getOneData?id=${updateID}`
                        }).then(function (e) {
                            e = organizeFormat(e);
                            let json = JSON.parse(e);
                            if (json.success === true) {
                                $(`#com${updateID}`).html(getEmpUpdateCommodityItemView(
                                    json.result.id,
                                    json.result.name,
                                    json.result.price,
                                    json.result.quantity,
                                    json.result.status,
                                    json.result.creationDatetime,
                                    json.result.changeDatetime
                                ));
                            } else {
                                alert(json.errMessage);
                            }
                        });

                        $('#closeBtn').trigger('click');
                    } else {
                        alert("發生意外錯誤");
                    }
                });
            }

        });

    });

    //更新圖片
    function updateImg(id, img) {
        let putData = new FormData();
        putData.append('id', id);
        putData.append('img', img);

        $.ajax({
            type: 'POST',
            url: '/GameConsole/commodity/updateImg',
            data: putData,
            cache: false,
            contentType: false,
            processData: false
        }).then(function (e) {
            e = organizeFormat(e);
            let json = JSON.parse(e);
            if (json.success === false) {
                alert(json.errMessage);
            } else if (json.result === true) {
                setTimeout(function () {
                    let reader = new FileReader();
                    reader.onload = function (e) {
                        $(`#showImg${id}`).attr('src', e.target.result);
                    }
                    reader.readAsDataURL(img);
                }, 10);

            }
        });
    }

    //確認名稱並得到錯誤訊息內容
    function getCheckNameMessage(value) {
        let checkMessage = $('#nameErrMessage');
        let input = $('#name');
        let returnStr = '請輸入名稱\r\n';

        checkMessage.empty();
        input.removeClass('borderBottomRed');
        if (value.trim().length <= 0) {
            checkMessage.text(returnStr);
            input.addClass('borderBottomRed');
            return returnStr;
        }
        return "";
    }

    //確認價格並得到錯誤訊息內容
    function getCheckPriceMessage(value) {
        let checkMessage = $('#priceErrMessage');
        let input = $('#price');
        let returnStr = '價格目前為負值\r\n';

        checkMessage.empty();
        input.removeClass('borderBottomRed');
        if (value < 0) {
            checkMessage.text(returnStr);
            input.addClass('borderBottomRed');
            return returnStr;
        }
        return "";
    }

    //確認庫存並得到錯誤訊息內容
    function getCheckQuantityMessage(value) {
        let checkMessage = $('#quantityErrMessage');
        let input = $('#quantity');
        let returnStr = '庫存目前為負值\r\n';

        checkMessage.empty();
        input.removeClass('borderBottomRed');
        if (value < 0) {
            checkMessage.text(returnStr);
            input.addClass('borderBottomRed');
            return returnStr;
        }
        return "";
    }

    //確認圖片格式
    function getCheckImage(value) {
        return value && value.type.match(imageTypeRule);
    }


<?php echo '</script'; ?>
> -->

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
            <div class="col-sm-6 col-md-4 col-lg-3 col-xs-12">
                <table>
                    <tr>
                        <td colspan="2"><?php echo $_smarty_tpl->tpl_vars['commodity']->value['name'];?>
</td>
                    </tr>
                    <tr>
                        <td colspan="2"><img src="/GameConsole/commodity/getOneImg?ID=<?php echo $_smarty_tpl->tpl_vars['commodity']->value['id'];?>
"
                                onerror="javascript:this.src='/GameConsole/views/img/gravatar.jpg'"></td>
                    </tr>
                    <tr>
                        <td>價格：<?php echo $_smarty_tpl->tpl_vars['commodity']->value['price'];?>
</td>
                        <td><button class="width100Percentage">加入購物車</button></td>
                    </tr>
                </table>
            </div>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>



        </div>

    </main><!-- /.container -->

</body>

</html><?php }
}
