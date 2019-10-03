<?php 
	session_start();

	if( $_GET["logout"] == 1 ) unset($_SESSION["login_ok"]);

	if( isset($_SESSION["login_ok"]) ){
			header("Location: index.php");
			exit;
	}

	define('LOGIN', 'admin');
	define('PASSWORD', '12345');

	$error = '';
	if( !empty($_POST["login"]) ){

			// проверяем логин и пароль
			if( LOGIN != $_POST["login"] || PASSWORD != $_POST["password"] )  $error = 'неправильный логин или пароль';

			// если ошибки нет
			if( empty($error) ){
					$_SESSION["login_ok"] = 1;
					header("Location: index.php");
					exit;
			}
	}
	
?>
<!DOCTYPE html>
<html lang="ru">
	
	<head>
		<meta charset="UTF-8">
		<title>Авторизация</title>
		<!-- Bootstrap -->
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
		<link href="assets/styles.css" rel="stylesheet" media="screen">
		 <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
	</head>
	<body id="login">
		<div class="container">

			<form method="post" action="" class="form-signin">
				<h2 class="form-signin-heading">Пожалуйста войдите</h2>
				<input type="text" class="input-block-level" name="login" placeholder="Логин" value="<?= $_POST["login"]; ?>" />
				<input type="password" class="input-block-level" name="password" placeholder="Пароль" value="<?= $_POST["password"]; ?>" />
				<div class="control-group error">
					<label class="control-label"><?= $error ?></label>
				</div>
				<label class="checkbox">
					<input type="checkbox" value="remember-me"> Запомни меня
				</label>
				<button class="btn btn-large btn-primary" type="submit">Войти</button>
			</form>

		</div> <!-- /container -->
		<script src="vendors/jquery-1.9.1.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>