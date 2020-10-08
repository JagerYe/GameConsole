<?php
/* Smarty version 3.1.34-dev-7, created on 2020-10-08 03:39:00
  from '/Applications/XAMPP/xamppfiles/htdocs/GameConsole/views/pageBack/login.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f7e6db4314922_04700167',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd46723ce962173c4179d4efd7c18dd503616e1b1' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/GameConsole/views/pageBack/login.html',
      1 => 1602119333,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f7e6db4314922_04700167 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="Thoughts, reviews and ideas since 1999." />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="icon" href="/GameConsole/views/img/logo.png">

	<title>GAME休閒館</title>

	<link rel="canonical" href="https://getbootstrap.com/docs/4.1/examples/sign-in/">

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
		integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
	<link href="/GameConsole/views/css/signin.css" rel="stylesheet">
	<!-- Custom styles for this template -->

	<?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
		integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
		crossorigin="anonymous"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
		integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
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
	form {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		height: 50%;
	}
</style>
<?php echo '<script'; ?>
 src="/GameConsole/views/js/jsonFormat.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
	//檢查是否要登出
	function checkIsLogOut() {
		$("body").css("display", "none");
		$.ajax({
			type: "GET",
			url: "/GameConsole/employee/checkIsLogin"
		}).then(function (e) {
			console.log(e);

			try {
				let json = JSON.parse(organizeFormat(e));
				if (json.result === false) {
					$("body").css("display", "inline");
				}
				if (json.success === false || json.result === true) {
					throw new Error();
				}
			} catch (error) {
				$.ajax({
					type: "GET",
					url: "/GameConsole/employee/logout"
				}).then(() => {
					history.go(0);
				});
			}
		});
	}

	$(window).ready(() => {
		checkIsLogOut();
		//登入按鈕事件
		$("#login").click(() => {
			let data = {
				'account': $("#account").val(),
				'password': $("#password").val(),
				'isKeep': $("#isKeep").prop('checked')
			};
			$.ajax({
				type: "POST",
				url: "/GameConsole/employee/login",
				data: { 0: JSON.stringify(data) }
			}).then(function (e) {
				console.log(e);
				let json = JSON.parse(e);
				if (json.success === false) {
					alert(json.errMessage);
				} else if (json.result === true) {
					window.location.href = "/GameConsole/employee/getUpdateSelfView";
				} else {
					alert("發生不明錯誤");
				}
			});
		});
	});
<?php echo '</script'; ?>
>

<body class="text-center">
	<form class="form-signin" method="post">
		<img class="mb-4" src="/GameConsole/views/img/logo.png" alt="回首頁" style="background-color: black;">
		<h1 class="h3 mb-3 font-weight-normal">員工登入</h1>
		<label for="account" class="sr-only">帳號</label>
		<input type="text" id="account" name="account" class="form-control" placeholder="帳號" required autofocus>
		<label for="password" class="sr-only">密碼</label>
		<input type="password" id="password" name="password" class="form-control" placeholder="密碼" required>
		<label><input type="checkbox" name="isKeep" id="isKeep" value="true">保持登入</label>
		<button class="btn btn-lg btn-primary btn-block" id="login" type="button">登入</button>
		<p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
	</form>

</body>

</html><?php }
}
