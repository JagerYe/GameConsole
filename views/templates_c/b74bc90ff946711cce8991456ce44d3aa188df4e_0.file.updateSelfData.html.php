<?php
/* Smarty version 3.1.34-dev-7, created on 2020-10-16 03:58:20
  from '/Applications/XAMPP/xamppfiles/htdocs/GameConsole/views/pageFront/updateSelfData.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f88fe3ca12527_87026577',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b74bc90ff946711cce8991456ce44d3aa188df4e' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/GameConsole/views/pageFront/updateSelfData.html',
      1 => 1602735000,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./navigationBar.html' => 1,
  ),
),false)) {
function content_5f88fe3ca12527_87026577 (Smarty_Internal_Template $_smarty_tpl) {
?><!doctype html>
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
	<?php if (!((isset($_smarty_tpl->tpl_vars['isLogin']->value)) && $_smarty_tpl->tpl_vars['isLogin']->value)) {?>
    <meta http-equiv="refresh" content="0;url=/GameConsole/index">
    <?php }?>
</head>
<style>
	body {
		padding: 0;
	}

	article {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		height: 50%;
	}

	.borderBottomRed {
		border-bottom: 2px solid red;
	}

	.errMas {
		color: red;
	}

	img {
		width: 100%;
		height: 100%;
		max-width: 150px;
		max-height: 150px;
		;
	}
</style>

<?php echo '<script'; ?>
 src="/GameConsole/views/js/rule.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/GameConsole/views/js/title.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/GameConsole/views/js/jsonFormat.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
	let id = '<?php echo $_smarty_tpl->tpl_vars['isLogin']->value ? $_smarty_tpl->tpl_vars['mem']->value["id"] : -1;?>
';
	if (id < 0 || !Number.isInteger(parseInt(id))) {
		window.location.href = "/GameConsole/index";
	}

	//確認姓名並得到錯誤訊息內容
	function getCheckNameMessage(value) {
		let checkMessage = $('#nameCheckMessage');
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
		let checkMessage = $('#emailCheckMessage');
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

	$(window).ready(() => {
		$('body').css('display', '<?php echo $_smarty_tpl->tpl_vars['isLogin']->value ? 'inline' : 'none';?>
')

		//格式檢查
		$("#name").change(function () {
			getCheckNameMessage(this.value);
		});

		$("#email").change(function () {
			getCheckEmailMessage(this.value);
		});

		//送出按鈕事件
		$("#btnSub").click(() => {

			//包裝
			let employee = {
				"id": id,
				"name": $("#name").val(),
				"email": $("#email").val()
			};

			//檢查
			let errMessage = "";
			errMessage += getCheckNameMessage(employee.name);
			errMessage += getCheckEmailMessage(employee.email);
			if (errMessage.length > 0) {
				alert(errMessage);
				return;
			}

			//送出
			$.ajax({
				type: "PUT",
				url: "/GameConsole/employee/update",
				data: { 0: JSON.stringify(employee) }
			}).then(function (e) {
				let json = JSON.parse(organizeFormat(e));
				if (json.success === false) {
					alert(json.errMessage);
				} else if (json.result === true) {
					alert("更新成功");
					history.go(0);
				} else {
					alert("發生不明錯誤");
				}
			});
		});
	});
<?php echo '</script'; ?>
>

<body>
	<?php if ($_smarty_tpl->tpl_vars['isLogin']->value) {?>
	<?php $_smarty_tpl->_subTemplateRender('file:./navigationBar.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
	<div class="blank"></div>
	<main role="main" class="container">
		<div class="card bg-light">
			<article class="card-body mx-auto">
				<h4 class="card-title mt-3 text-center">更新自己資料</h4>

				<form>
					<div id="mainShow">

						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> <i class="fa fa-user"></i> </span>
							</div>
							<input id="name" class="form-control" placeholder="請輸入姓名" type="text"
								value="<?php echo $_smarty_tpl->tpl_vars['mem']->value['name'];?>
">
						</div>
						<p class="form-group errMas" id="nameCheckMessage"></p>
						<!-- form-group// -->

						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
							</div>
							<input id="email" class="form-control" placeholder="請輸入Email" type="email"
								value="<?php echo $_smarty_tpl->tpl_vars['mem']->value['email'];?>
">
						</div>
						<p class="form-group errMas" id="emailCheckMessage"></p>
						<!-- form-group// -->

					</div>

					<div class="form-group">
						<button type="button" id="btnSub" class="btn btn-primary btn-block">更新</button>
						<a class="btn btn-primary btn-block"
							href="/GameConsole/member/getUpdateSelfPasswordView">變更密碼</a>
					</div> <!-- form-group// -->
				</form>
			</article>
		</div> <!-- card.// -->

	</main><!-- /.container -->
	<?php }?>
</body>

</html><?php }
}
