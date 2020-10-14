<?php
/* Smarty version 3.1.34-dev-7, created on 2020-10-14 03:49:34
  from '/Applications/XAMPP/xamppfiles/htdocs/GameConsole/views/pageFront/registered.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f86592e54cbf0_02223142',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '91b1106ed9b8ebd61378663b1bbb2d3e0dc83b56' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/GameConsole/views/pageFront/registered.html',
      1 => 1602064630,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f86592e54cbf0_02223142 (Smarty_Internal_Template $_smarty_tpl) {
?><!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="/GameConsole/views/img/logo.png">

	<title>留言板</title>

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
	article {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		height: 50%;
	}

	body {
		padding: 0;
	}

	.borderBottomRed {
		border-bottom: 2px solid red;
	}

	.errMas {
		color: red;
	}
</style>
<?php echo '<script'; ?>
 src="/GameConsole/views/js/jsonFormat.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
	//防止重新導入這，倒入這就直接回首頁
	$("body").css("display", "none");
	$.ajax({
		type: "GET",
		url: "/GameConsole/member/checkIsLogin"
	}).then(function (e) {
		e = organizeFormat(e);
		let json = JSON.parse(e);
		if (json.success === false) {
			alert(json.errMessage);
			$("body").css("display", "inline");
		} else if (json.result === true) {
			window.location.href = "/GameConsole/index/getIndexView";
		} else {
			$("body").css("display", "inline");
		}
	});
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/GameConsole/views/js/rule.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>

	function getCheckNameMessage(value) {
		let checkMessage = $("#nameCheckMessage");
		let input = $("#name");
		let returnStr = "請輸入姓名\r\n";

		checkMessage.empty();
		input.removeClass('borderBottomRed');

		if (value.trim().length <= 0) {
			checkMessage.text(returnStr);
			input.addClass('borderBottomRed');
			return returnStr;
		}
		return "";
	}

	function getCheckEmailMessage(value) {
		let checkMessage = $("#emailCheckMessage");
		let input = $("#email");
		let returnStr = "信箱格式錯誤\r\n";

		checkMessage.empty();
		input.removeClass('borderBottomRed');

		if (!value.match(emailRule)) {
			checkMessage.text(returnStr);
			input.addClass('borderBottomRed');
			return returnStr;
		}
		return "";
	}

	function getCheckPhoneMessage(value) {
		let checkMessage = $("#phoneCheckMessage");
		let input = $("#phone");
		let returnStr = "電話號碼格式錯誤\r\n";

		checkMessage.empty();
		input.removeClass('borderBottomRed');

		if (!value.match(phoneRule)) {
			checkMessage.text(returnStr);
			input.addClass('borderBottomRed');
			return returnStr;
		}
		return "";
	}

	function getCheckAccountMessage(value) {
		let checkMessage = $("#accountCheckMessage");
		let input = $("#account");
		let returnStr = "帳號格式錯誤\r\n";

		checkMessage.empty();
		input.removeClass('borderBottomRed');

		$.ajax({
			type: "GET",
			url: `/GameConsole/member/checkAccountExist?id=${value}`
		}).then(function (e) {
			e = organizeFormat(e);
			let json = JSON.parse(e);
			console.log(json);


			if (json.success === false) {
				alert(json.errMessage);
			} else if (json.result === true) {
				checkMessage.append("<br>此帳號有人使用<br>");
			}
		});

		if (!value.match(accountRule)) {
			checkMessage.text(returnStr);
			input.addClass('borderBottomRed');
			return returnStr;
		}
		return "";
	}

	function getCheckPasswordMessage(again = false) {
		let checkMessage = $("#passwordCheckMessage");
		let input1 = $("#password");
		let input2 = $("#passwordAgain");
		let returnStr = "";

		checkMessage.empty();
		input1.removeClass('borderBottomRed');
		input2.removeClass('borderBottomRed');

		if (!(input1.val()).match(passwordRule)) {
			input1.addClass('borderBottomRed');
			returnStr += '密碼格式錯誤！\r\n';
		}

		if (again && (input1.val() !== input2.val())) {
			input1.addClass('borderBottomRed');
			input2.addClass('borderBottomRed');
			returnStr += '兩次密碼不一致！\r\n';
		}
		checkMessage.text(returnStr);

		return returnStr;
	}

	$(window).ready(() => {

		//確認密碼是否一致
		$("#passwordAgain").change(function () {
			getCheckPasswordMessage(true);
		});

		//確認密碼格式
		$("#password").change(function () {
			getCheckPasswordMessage();
		});

		//檢驗帳號
		$("#account").change(function () {
			getCheckAccountMessage(this.value);
		});

		//檢測信箱
		$("#email").change(function () {
			getCheckEmailMessage(this.value);
		});

		//檢查名字
		$("#name").change(function () {
			getCheckNameMessage(this.value);
		});

		//檢查電話
		$("#phone").change(function () {
			getCheckPhoneMessage(this.value);
		});

		$("#btnSub").click(() => {

			let member = {
				"account": $("#account").val(),
				"name": $("#name").val(),
				"email": $("#email").val(),
				"phone": $("#phone").val(),
				"password": $("#password").val()
			};

			let errMessage = "";
			errMessage += getCheckNameMessage(member.name);
			errMessage += getCheckEmailMessage(member.email);
			errMessage += getCheckPhoneMessage(member.phone);
			errMessage += getCheckAccountMessage(member.account);
			errMessage += getCheckPasswordMessage(true);
			if (errMessage.length > 0) {
				alert(errMessage);
				return;
			}

			let subData = {
				member: JSON.stringify(member)
			}
			$.ajax({
				type: "POST",
				url: "/GameConsole/member/insert",
				data: subData
			}).then(function (e) {
				e = organizeFormat(e);
				let json = JSON.parse(e);
				console.log(json);
				if (json.success === false) {
					alert(json.errMessage);
				} else if (json.result === true) {
					alert("註冊成功，請登入");
					window.location.href = "/GameConsole/member/getLoginView";
				} else {
					alert('發生意外錯誤');
				}
			});

		});
	});

<?php echo '</script'; ?>
>

<body>

	<main role="main" class="container">
		<div class="panel panel-default">
			<article class="panel-body mx-auto pagination-centered">

				<h4 class="panel-title mt-3 text-center">註冊</h4>

				<form>
					<div class="form-group input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"> <i class="fa fa-user"></i> </span>
						</div>
						<input id="name" class="form-control" placeholder="請輸入姓名" type="text">
					</div> <!-- form-group// -->
					<p class="form-group errMas" id="nameCheckMessage"></p>

					<div class="form-group input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
						</div>
						<input id="email" class="form-control" placeholder="請輸入Email" type="email">
					</div> <!-- form-group// -->
					<p class="form-group errMas" id="emailCheckMessage"></p>

					<div class="form-group input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"> <i class="fa fa-phone"></i> </span>
						</div>
						<input id="phone" class="form-control" placeholder="請輸入手機號碼" type="text">
					</div> <!-- form-group// -->
					<p class="form-group errMas" id="phoneCheckMessage"></p>

					<div class="form-group input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"> <i class="fa fa-user"></i> </span>
						</div>
						<input id="account" class="form-control" placeholder="請輸入帳號" type="text">
					</div> <!-- form-group// -->
					<p class="form-group errMas" id="accountCheckMessage"></p>

					<div class="form-group input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
						</div>
						<input id="password" class="form-control" placeholder="請輸入密碼" type="password">
					</div> <!-- form-group// -->

					<div class="form-group input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
						</div>
						<input id="passwordAgain" class="form-control" placeholder="請在輸入一次密碼" type="password">
					</div> <!-- form-group// -->
					<p class="form-group errMas" id="passwordCheckMessage"></p>

					<div class="form-group">
						<button type="button" id="btnSub" class="btn btn-primary btn-block"> Create Account
						</button>
					</div> <!-- form-group// -->

					<p class="text-center">Have an account? <a href="/GameConsole/member/getLoginView">Log
							In</a> </p>
				</form>

			</article>
		</div> <!-- panel.// -->

	</main><!-- /.container -->

</body>

</html><?php }
}
