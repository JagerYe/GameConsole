<?php
/* Smarty version 3.1.34-dev-7, created on 2020-10-13 03:41:19
  from '/Applications/XAMPP/xamppfiles/htdocs/GameConsole/views/pageBack/commodityList.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f8505bf532167_52768324',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f5f0d670ee24d5a465f59bcb16abfb72abc09d1e' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/GameConsole/views/pageBack/commodityList.html',
      1 => 1602553271,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./navigationBar.html' => 1,
  ),
),false)) {
function content_5f8505bf532167_52768324 (Smarty_Internal_Template $_smarty_tpl) {
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

    <?php if (!((isset($_smarty_tpl->tpl_vars['comSee']->value)))) {?>
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

    .width100Percentage {
        width: 100%;
    }

    .errMessage {
        color: red;
    }

    .borderBottomRed {
        border-bottom: 2px solid red;
    }

    img {
        max-width: 100%;
        max-height: 100px;
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
 src="/GameConsole/views/js/viewModels/commodityViewModel.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    let updateID = -1;
    let lastID = '<?php echo $_smarty_tpl->tpl_vars['lastID']->value;?>
';
    let getItemProcessing = false;
    let comUse = "<?php echo (isset($_smarty_tpl->tpl_vars['comUse']->value)) && $_smarty_tpl->tpl_vars['comUse']->value;?>
";


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
                                comUse,
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
                                    comUse,
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
                        $.ajax({
                            type: 'GET',
                            url: `/GameConsole/commodity/getOneData?id=${updateID}`
                        }).then(function (e) {
                            e = organizeFormat(e);
                            let json = JSON.parse(e);
                            if (json.success === true) {
                                $(`#com${updateID}`).html(getEmpUpdateCommodityItemView(
                                    comUse,
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
            $('#inputImage').val('');
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
                    <th>圖片</th>
                    <th>商品名稱</th>
                    <th>價格</th>
                    <th>庫存</th>
                    <th>上下架狀態</th>
                    <th>建立時間</th>
                    <th>修改時間</th>
                    <?php if ((isset($_smarty_tpl->tpl_vars['comUse']->value)) && $_smarty_tpl->tpl_vars['comUse']->value) {?>
                    <th>
                        <button class="btn btn-success width100Percentage" id="creatBtn" type="button"
                            data-toggle="modal" data-target="#commodityModal">新增商品</button>
                    </th>
                    <?php }?>
                </tr>
            </thead>

            <tbody id="dataShow">
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['commoditys']->value, 'commodity');
$_smarty_tpl->tpl_vars['commodity']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['commodity']->value) {
$_smarty_tpl->tpl_vars['commodity']->do_else = false;
?>
                <tr id="com<?php echo $_smarty_tpl->tpl_vars['commodity']->value['id'];?>
">
                    <td><?php echo $_smarty_tpl->tpl_vars['commodity']->value['id'];?>
</td>
                    <td><img src="/GameConsole/commodity/getOneImg?id=<?php echo $_smarty_tpl->tpl_vars['commodity']->value['id'];?>
" alt=""
                            id="showImg<?php echo $_smarty_tpl->tpl_vars['commodity']->value['id'];?>
"></td>
                    <td><?php echo $_smarty_tpl->tpl_vars['commodity']->value['name'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['commodity']->value['price'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['commodity']->value['quantity'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['commodity']->value['status'] ? '上架' : '下架';?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['commodity']->value['creationDatetime'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['commodity']->value['changeDatetime'];?>
</td>

                    <?php if ((isset($_smarty_tpl->tpl_vars['comUse']->value)) && $_smarty_tpl->tpl_vars['comUse']->value) {?>
                    <td>
                        <button class="btn btn-info width100Percentage updateBtn" type="button" data-toggle="modal"
                            data-target="#commodityModal">修改</button>
                    </td>
                    <?php }?>
                </tr>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </tbody>






        </table>

        <?php if ((isset($_smarty_tpl->tpl_vars['comUse']->value)) && $_smarty_tpl->tpl_vars['comUse']->value) {?>
        <!-- Modal，用於新增or修改商品用-->
        <div class="modal fade" id="commodityModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                        <h4 class="modal-title"></h4>
                        <!--開頭-->
                    </div>
                    <div class="modal-body">
                        <!--身-->

                        <table class="table table-hover table-bordered">
                            <tbody>
                                <tr>
                                    <td>名稱</td>
                                    <td>
                                        <input class="width100Percentage" type="text" id="name">
                                        <p class="errMessage" id="nameErrMessage"></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>價格</td>
                                    <td>
                                        <input class="width100Percentage" type="number" id="price" min="0">
                                        <p class="errMessage" id="priceErrMessage"></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>庫存</td>
                                    <td>
                                        <input class="width100Percentage" type="number" id="quantity" min="0">
                                        <p class="errMessage" id="quantityErrMessage"></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>上下架狀態</td>
                                    <td>
                                        <label>
                                            <input type="checkbox" id="status">上架
                                        </label>

                                    </td>
                                </tr>
                                <tr>
                                    <td>圖片預覽</td>
                                    <td>
                                        <img src="/GameConsole/commodity/getOneImg?id=<?php echo $_smarty_tpl->tpl_vars['commodity']->value['id'];?>
" alt=""
                                            id="picturePreview">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        圖片上傳<input type="file" accept="image/*" id="inputImage">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <!--底-->
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="closeBtn">取消</button>
                        <!--取消按鈕-->
                        <button type="button" class="btn btn-primary" id="subBtn">新增</button>
                        <!--送出-->
                    </div>
                </div>
            </div>
        </div>
        <?php }?>

    </main><!-- /.container -->

</body>

</html><?php }
}
