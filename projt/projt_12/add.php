<?php 

	$error = '';

	$id = $_POST["id"];
	$name = $_POST["name"];
	$email = $_POST["email"];
	$telegram = $_POST["telegram"];
	$phone = $_POST["phone"];
	$region = $_POST["region"];
	$address = $_POST["address"];
	$category = $_POST["category"];
	$category_add = $_POST["category_add"];
	$category_type = $_POST["category_type"];
	$title = $_POST["title"];
	$text = $_POST["text"];
	$site = $_POST["site"];
	$price = $_POST["price"];
	$photo = $_POST["photo"];
	$password = $_POST["password"];
	$date = $_POST["date"];

	if( $_POST["action"] == "add_form" ) 
	{
		if($name == '') { $error .= 'Не указано Ваше имя <br>'; }
		if($email == '') { $error .= 'Не указано E-mail <br>'; }
		if($phone == '') { $error .= 'Не указано Ваше телефон <br>'; }
		if($region == '') { $error .= 'Не указано Ваше Регион <br>'; }
		if($category == '') { $error .= 'Укажите категорию <br>'; }
		if($category_type == '') { $error .= 'Укажите тип <br>'; }
		if($title == '') { $error .= 'Укажите заголовок <br>'; }
		if($text == '') { $error .= 'Укажите Текст объявления <br>'; }
		if($price == '') { $error .= 'Укажите цену <br>'; }
		if($password == '') { $error .= 'Не указан пароль <br>'; }
		if( $_POST["password"] !== $_POST["confirmpass"] ) { $error .= 'Повторный пароль не совпадает <br />'; }

		// print_r($_FLES["photo"]);
		// exit;

		// echo empty($_FILES["photo"]["tmp_name"]);
		// exit;


		// проверка формата
		if( !empty($_FILES["photo"]) )
		{
			if( !empty($_FILES["photo"]["name"]) )
			{
				$original = $_FILES["photo"]["name"];
				if( strstr($original, '.jpg') )
				{
						$format = '.jpg';
				}else
				if( strstr($original, '.png') )
				{
						$format = '.png';
				}else
				if( strstr($original, '.gif') )
				{
						$format = '.gif';
				}else
				{
						$error .= 'Неправильный формат фото <br>';
				}
			}
		}
			

		if ( $error == "") {

			// Загрузка файлов .jpg, .png
			if( !empty($_FILES["photo"]) && !empty($_FILES["photo"]["tmp_name"]) ){
					// print_r($_FILES["photo"]);
					
					$file = $_FILES["photo"]["tmp_name"];
					// $newFile = time().'_'.uniqid().$format;
					// $newFile = time().'_'.uniqid().$format;
					$newFile = 'uploads/'.time().'_'.uniqid().$format;
					copy($file, $newFile);
			}

			/* открываем соединение */
			$link = mysqli_connect("localhost", "porfeus2", "dm9UDDdy88ds9", "porfeus2_uzbablo");

			/* проверка коннекта */
			if ( mysqli_connect_errno() ) 
			{
				echo "Ошибка коннекта: %s\n", mysqli_connect_error();
				exit;
			}

			foreach( $_POST as $k => $v){
				$_POST[$k] =  mysqli_real_escape_string( $link, $_POST[$k] );
			}

			/* подготавливаем запрос */
			$query = "INSERT INTO `doska` ( `name`, `email`, `telegram`, `phone`, `region`, `address`, `category`, `category_add`, `category_type`, `title`, `text`, `site`, `price`, `photo`, `password`, `date` ) 
			VALUES( '$name','$email','$telegram','$phone','$region','$address','$category','$category_add','$category_type','$title','$text','$site','$price','$newFile','$password', NOW() )";
		
			/* выполняем запрос */
			if( !mysqli_query($link, $query) )
			{
				echo "Ошибка добавления записи: %s\n", mysqli_error();
				exit;
			}

			/* закрываем соединение */
			mysqli_close($link);

			// header("Location: index.php");
			header("Location: add.php?status=ok");
			exit;
		}
	}

	// if( isset($_POST["name"]) ){
	//  echo '<pre>';
	//    print_r( $_POST );
	//  echo '</pre>';
	// }  
?>
<!DOCTYPE html>
<html lang="ru">

<head>
		<title>Размещение объявлений на uzMoney бесплатно</title>
		<meta name="keywords" content='webmoney продать, купить webmoney' />
		<meta name="description" content='Подать объявление на uzbablo бесплатно и разместить еще на 100 досок объявлений' />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="css/style_main.css?28012019" type="text/css" />
		<link rel="stylesheet" href="css/style2.css?28012019" type="text/css" />
		<link rel="stylesheet" href="css/jquery-ui-1.9.0.custom.css" type="text/css" />
		<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
		<!-- <link rel="yandex-tableau-widget" href="yandex-tableau-manifest.json" /> -->
		<meta name="google-site-verification" content="" />
		<meta name='yandex-verification' content='' />
		<script src="js/jquery-1.8.2.min.js"></script>
		<script src="js/jquery-ui-1.9.0.custom.min.js"></script>
		<script src="js/jquery.placeholder.min.js"></script>
		<script src="js/auto_up_msg.js"></script>
		<script src="js/users_messages.js"></script>
</head>

<body>
		<div id="container">
				<script>
						$(function() {
								$("#formlogin").focus(function() {
										$('#labelLogin').text("");
								});
								$("#formpass").focus(function() {
										$('#labelPass').text("");
								});
								$("#formlogin").blur(function() {
										if ($("#formlogin").val() == '') $('#labelLogin').text("Email");
								});
								$("#formpass").blur(function() {
										if ($("#formpass").val() == '') $('#labelPass').text("Пароль");
								});
								if ($("#formlogin").val() != '') $('#labelLogin').text("");
								else $('#labelLogin').text("Email");
								if ($("#formpass").val() != '') $('#labelPass').text("");
								else $('#labelPass').text("Пароль");
						});
				</script>
				<div id="top">
						<div id="logo">
								<span>размещение объявлений</span>
								<a href="/"><img src="images/logo_line.gif" width="214" height="27" alt="КупиПродай" title="КупиПродай" /></a>
						</div>
						<!-- <div id="phone">(495) 363-87-00
								<br />(495) 720-92-99</div> -->

						<!-- <div id="enter">
								<form method="post" action="https://kupiprodai.ru/login/sub/">
										<label for="formlogin" id="labelLogin"></label>
										<input type="text" id='formlogin' name="login" value="" />
										<label for="formpass" id="labelPass"></label>
										<input type="password" id='formpass' name="pass" value="" />
										<input id="enter_button" type="submit" value="Войти" />
								</form>
								<span id="enter_menu"><a class="grey_link" href="https://kupiprodai.ru/help#reg">Регистрация</a> | <a class="grey_link" href="/remind/">Напомнить пароль</a></span>
						</div> -->
				</div>
				<div id="menu">
						<a id="menu_first" href="#"></a>
						<!-- <a href="https://vip.kupiprodai.ru" class="menu_noact">Размещение объявлений</a> -->

						<a href="/" class="menu_noact">Доски объявлений</a>

						<a href="/add.php" class=" menu_act">Подать объявление</a>

						<!-- <a class="menu_noact" href="https://kupiprodai.ru/">КупиПродай</a> -->

						<!-- <a class=" menu_noact" href="/contact/">Контакты</a> -->
				</div>
				<div id="content">
						<div id="content_padd">
								<div class="clear_nopadd">
										<h1>Подать объявление</h1>

										<?php
											if ( $error != '' ) {
										?>
											<div class="error">
												<?php echo $error; ?>
											</div>
										<?php
											}
										?>
										
										
										<?php
											if ( $_GET["status"] == 'ok' ) {
										 echo '<div class="success">Объявление добавлено!</div>'; 
											}
										?>

										
										<!-- <script>
											$(function(){
												var val = $('.error').html();
												var trim = $.trim(val);
												if( trim == '' ) { $('.error').fadeOut("slow"); } 
												else {
													$('.error').fadeTo("slow");
												}
											});
										</script> -->
										<script src="js/params_core.js"></script>
										<script src="js/metro_array.js"></script>
										<script src="js/params_data.js"></script>
										<script src="js/jquery.ui.widget.js"></script>
										<script src="js/jquery.fileupload.js"></script>
										<script src="js/images.js?v1.2"></script>
										<script src="js/jquery.inputmask.bundle.js"></script>
										<script src="js/title_from_params.js?5"></script>
										<link rel="stylesheet" type="text/css" href="css/images.css?09022018" />

										<script>
												$(function() {
														new ImageList({
																$uploader: $('#image-upload'),
																$container: $('#images'),
																$remaining: $('#images-remaining'),
																images: [],
																images_md5: [],
																maxNum: 12,
																uploadUrl: '/imageuploadnew/upload.php',
																deleteUrl: '/imageuploadnew/delete.php',
																rotateUrl: '/imageuploadnew/rotate.php'
														});

														$("input[name=phone]").inputmask("998(99) 999-99-99");
												});
										</script>

										<script>
												function numchars(formName, num) {
														if (num == 1) {
																count = $('input[name="title"]').val().length;
																if (count >= 80) {
																		count = "не осталось символов";
																		document.forms[formName].elements['title'].value = document.forms[formName].elements['title'].value.substring(0, 80);
																		ret = false;
																} else {
																		count = 80 - count;
																		count = "осталось " + count + " символов";
																		ret = true;
																}

																$('#msgtitle').text(count);
														}
														if (num == 2) {
																count = $('textarea[name="text"]').val().length;
																if (count >= 3000) {
																		count = "не осталось символов";
																		document.forms[formName].elements['text'].value = document.forms[formName].elements['text'].value.substring(0, 3000);
																		ret = false;
																} else {
																		count = 3000 - count;
																		count = "осталось " + count + " символов";
																		ret = true;
																}

																$('#msgtext').text(count);
														}
														return ret;
												}
												$(function() {
														txtParams = $.parseJSON('{"36":{"0":{"title":"%num%-\u043a \u043a\u0432\u0430\u0440\u0442\u0438\u0440\u0430","zapyataya":"1"}},"41":{"0":{"title":"%num% \u043c2","zapyataya":"1"}},"134":{"0":{"title":"%num% \u044d\u0442.","zapyataya":"1"}},"136":{"0":{"title":"%num% \u044d\u0442. \u0434\u043e\u043c","zapyataya":"1"}},"1":{"0":{"title":"%str%","zapyataya":"1"}},"3":{"0":{"title":"%str%","zapyataya":"0"}},"5":{"0":{"title":"%num%","zapyataya":"1"}},"47":{"987":{"title":"\u0414\u043e\u043c","zapyataya":"1"},"988":{"title":"\u0414\u0430\u0447\u0430","zapyataya":"1"},"989":{"title":"\u041a\u043e\u0442\u0442\u0435\u0434\u0436","zapyataya":"1"},"990":{"title":"\u0422\u0430\u043d\u0445\u0430\u0443\u0441","zapyataya":"1"}},"48":{"0":{"title":"%num% \u043c2","zapyataya":"0"}},"69":{"0":{"title":"%num% \u043c2","zapyataya":"0"}},"65":{"0":{"title":"\u041a\u043e\u043c\u043d\u0430\u0442\u0430 \u0432 %num%-\u043a","zapyataya":"1"}},"130":{"0":{"title":"%num% \u044d\u0442.","zapyataya":"1"}},"132":{"0":{"title":"%num% \u044d\u0442. \u0434\u043e\u043c","zapyataya":"1"}}}');
														$.ajax({
																type: "GET",
																url: '/getpageregions/',
																dataType: 'html',
																success: function(response) {
																		$("#dialog-region").html(response);
																}
														});

														dialog_region = $("#dialog-region").dialog({
																autoOpen: false,
																height: 700,
																width: 790,
																modal: true
														});

														dialog_city = $("#dialog-city").dialog({
																autoOpen: false,
																height: 550,
																width: 740,
																modal: true
														});

														$('input, textarea').placeholder();
														$("#citysel").autocomplete({
																source: "/controller.php?action=getcitys",
																minLength: 0,
																autoFocus: true,
																response: function(event, ui) {
																		if (ui.content.length == 0) $("#error_city").html("Необходимо уточнить, <a href='#' onclick='dialog_region.dialog(\"open\");return false;'>выберите город из списка</a>").show();
																		else $("#error_city").html("").hide();
																},
																select: function(event, ui) {
																		if (ui.item.id > 0) {
																				$("input[name='cityid']").val(ui.item.id);
																				show_metro(ui.item.id);
																		} else {
																				dialog_region.dialog('open');
																				return false;
																		}
																}
														});
														$("#citysel").autocomplete("disable");
														$("#citysel").click(function() {
																$("#citysel").autocomplete("enable");
																$(this).val("");
																if ($(this).val().length == 0) {
																		$(this).autocomplete("search");
																}
														});
														show_metro(0, 0);
												});

												function show_metro(city_id, metro_id) {
														$("#metro_id").html("");
														$("#metrodiv").hide();
														if (city_id > 0 && metro[city_id] != undefined && metro[city_id].length > 0) {
																var gen_metro = '<option value="0">Выберите метро</option>';
																$.each(metro[city_id], function(i, oMetro) {
																		selected = oMetro.id == metro_id ? 'selected' : '';
																		gen_metro += '<option ' + selected + ' value="' + oMetro.id + '">' + oMetro.name + '</option>';
																});
																$("#metro_id").html(gen_metro);
																$("#metrodiv").show();
														}
												}
										</script>

								</div>

								<div class="reg_instruction">
										<form method="POST" name="add" enctype="multipart/form-data" action="add.php">
											<input type="hidden" name="action" value="add_form">
											

												<div class="forma_top">
														<div class="forma_bottom">
																<ul class="fix_width">
																		<li class="form_line">
																				<label><b>Ваше имя</b></label>
																				<div class="form_content">
																						<input class="w300" type="text" maxlength="100" name="name" value="<?= $_POST['name']; ?>" /> </div>
																		</li>
																		<li class="form_line">
																				<label><b>E-mail</b></label>
																				<div class="form_content">
																						<input class="w300" type="text" maxlength="100" name="email" value="<?= $_POST['email']; ?>" /> </div>
																		</li>
																		<li class="form_line">
																				<label><b>Telegram</b></label>
																				<div class="form_content">
																						<input class="w300" type="text" maxlength="100" name="telegram" value="<?= $_POST['telegram']; ?>" />
																				</div>
																				<span class="form_prim">Укажите без символа @</span>
																		</li>
																		<li class="form_line">
																				<label><b>Телефон</b></label>
																				<div class="form_content">
																						<input class="w300" type="text" maxlength="100" name="phone" value="99()" />
																				</div>
																				<span class="form_prim">Пример: 99890 1234567</span>
																		</li>
																		<li class="form_line">
																				<label><b>Регион</b></label>
																				<div class="form_content">
																						<select class="select_long" name="region" id="citi_id">
																							<option>Ташкент</option>
																							<option>Ташкентская область</option>
																							<option>Андижанская область</option>
																							<option>Бухарская область</option>
																							<option>Джизакская область</option>
																							<option>Каракалпакстан</option>
																							<option>Кашкадарьинская область</option>
																							<option>Навоийская область</option>
																							<option>Наманганская область</option>
																							<option>Самаркандская область</option>
																							<option>Сурхандарьинская область</option>
																							<option>Сырдарьинская область</option>
																							<option>Ферганская область</option>
																							<option>Хорезмская область</option>
																						</select>
																				</div>
																				<!-- <div class="form_content">
																						<input class="w300" type="text" name="city" id="citysel" value="" />
																						<p style="display: none" class="error" id="error_city"></p>
																						<div class="metro" id="metrodiv">
																								<select id="metro_id" name="metro_id">
																									<option value="1_1">Ташкент</option>
																									<option value="1_2">Ташкентская область</option>
																									<option value="1_3">Андижанская область</option>
																									<option value="1_4">Бухарская область</option>
																									<option value="1_5">Джизакская область</option>
																									<option value="1_6">Каракалпакстан</option>
																									<option value="1_7">Кашкадарьинская область</option>
																									<option value="1_8">Навоийская область</option>
																									<option value="1_9">Наманганская область</option>
																									<option value="1_10">Самаркандская область</option>
																									<option value="1_11">Сурхандарьинская область</option>
																									<option value="1_12">Сырдарьинская область</option>
																									<option value="1_13">Ферганская область</option>
																									<option value="1_14">Хорезмская область</option>
																								</select>
																						</div>
																						<input type="hidden" name="cityid" value="">
																				</div> -->
																				<span class="form_prim">Напишите Ваш город</span>
																		</li>
																		<li class="form_line_end">
																				<label>Адрес</label>
																				<div class="form_content">
																						<input class="w300" type="text" maxlength="100" name="address" value="<?= $_POST['address']; ?>" />
																				</div>
																				<span class="form_prim">Улица Дом</span>
																		</li>
																</ul>
														</div>
												</div>

												<div class="forma_top">
														<div class="forma_bottom">
																<ul class="fix_width">
																		<li class="form_line">
																				<label style="padding-top:5px;"><b>Категория</b></label>
																				<div class="form_content">
																						<select class="select_long" name="category" id="cat_id">
																								<?php // if( $_POST['category'] !== '' ) echo '<option selected value="'. $_POST['category'] .'">' . $_POST['category'] . '</option>'; ?>
																								<option value="">Выбрать</option>
																								<option value="webmoney" <?php if( $_POST["category"] == "webmoney" ) echo " selected"; ?>>Webmoney</option>
																								<!-- <option value="1_2">WMZ</option>
																								<option value="1_4">WMR</option>
																								<option value="1_6">WME</option> -->
																								<option value="qiwi" <?php if( $_POST["category"] == "qiwi" ) echo " selected"; ?>>QIWI</option>
																								<option value="yamoney" <?php if( $_POST["category"] == "yamoney" ) echo " selected"; ?>>Яндекс деньги</option>
																								<option value="crypto" <?php if( $_POST["category"] == "crypto" ) echo " selected"; ?>>Криптовалюты</option>
																								<option value="uzcard" <?php if( $_POST["category"] == "uzcard" ) echo " selected"; ?>>UzCard</option>
																								<option value="other" <?php if( $_POST["other"] == "other" ) echo " selected"; ?>>Другие</option>
																								<!-- <option value="206_122">UzCard</option> -->
																						</select>
																				</div>
																		</li>
																		<li class="form_line">
																			<label style="padding-top:5px;"></label>
																			<div id="category_add">
																			</div>
																			<!-- <fieldset id="params">
																			</fieldset> -->
																		</li>
<script>
	$(function() { 
		$('#cat_id').change(function(){
			var val = $( this).val();
			if( val == 'webmoney' )
			{
				$('#category_add').html(
					'<select class="select_long" name="category_add"><option >Выбрать</option><option >WMZ</option><option >WMR</option><option >WME</option></select>'
				);
			} else if( val == 'crypto' )
			{
				$('#category_add').html(
					'<select class="select_long" name="category_add"><option >Выбрать</option><option >Bitcoin</option><option >Ethereum</option><option >Litcoin</option><option >Monero</option><option >Dash</option></select>'
				);
			} else
			{
				$('#category_add').html('');
			}
		});
	});
</script>

																		<li class="form_line">
																				<label><b>Тип объявления</b></label>
																				<div class="form_content">
																						<select class="select_long" name="category_type">
																							<option>Купить</option>
																							<option>Продать</option>
																						</select>
																				</div>
																		</li>

																		<li class="form_line">
																				<label><b>Заголовок</b></label>
																				<div class="form_content">
																						<input class="w300" onkeypress="numchars( 'add','1')" onkeydown="numchars( 'add','1' )" onkeyup="numchars( 'add','1' )" onfocus="set_title_from_params($(this)); numchars( 'add','1' );" onchange="numchars( 'add','1' )" type="text" maxlength="80" name="title" value="<?= $_POST['title']; ?>" /> </div>
																				<span id="msgtitle" class="form_prim">максимально 80 символов</span>
																				<img class="vopros" title="В текст заголовка нельзя включать номера телефонов, адреса электронной почты. Набор слов заглавными буквами разрешен только для написания аббревиатур. Контактную информацию нужно указывать в соответствующих полях ниже." src="images/vopros.gif" width="22" height="22" alt="" />
																		</li>
																		<li class="form_line">
																				<label><b>Текст объявления</b></label>
																				<div class="form_content_long2">
																						<textarea class="w500" onkeypress="numchars( 'add','2' )" onkeydown="numchars( 'add','2' )" onkeyup="numchars( 'add','2' )" onfocus="numchars( 'add','2' )" onchange="numchars( 'add','2' )" rows="8" maxlength="3000" name="text"><?= $_POST['text']; ?></textarea>
																						<div id="msgtext" class="form_content_prim">максимально 3000 символов</div>
																				</div>
																				<img class="vopros" title="В текст объявления нельзя включать номера телефонов, адреса электронной почты. Набор слов заглавными буквами разрешен только для написания аббревиатур. Контактную информацию нужно указывать в соответствующих полях ниже." src="images/vopros.gif" width="22" height="22" alt="" />
																		</li>
																		<li class="form_line">
																				<label>Адрес сайта</label>
																				<div class="form_content">
																						<input class="w300" type="text" maxlength="100" name="site" value="<?= $_POST['site']; ?>" />
																				</div>
																				<span class="form_prim">(если есть)</span>
																		</li>
																		<li class="form_line">
																				<label><b>Цена</b></label>
																				<div class="form_content">
																						<input class="w300" type="text" maxlength="30" name="price" value="0" /> </div>
																				<span class="form_prim">Пример: 10000 (только цифры)</span>
																		</li>

																		<li class="form_line_end">
																				<label style="padding-top:3px;">Добавить фото</label>
																				<div class="form_content_long">

																					<input type="file" name="photo" id="photo" class="inputfile" data-multiple-caption="{count} files selected" accept=".jpg, .png">
																					<?php
																						// $file_result = "";
																						// if ($_FILES["photo"]["error"] > 0 ) {
																						//   $file_result .= "Нет загруженного файла или неверный файл ";
																						//   $file_result .= "Код ошибки: " . $_FILES["photo"]["error"] . "<br>";
																						// }
																						// else {
																						//   $file_result .=
																						//   "Загрузить: " . $_FILES["photo"]["name"] . "<br />" .
																						//   "Тип: " . $_FILES["photo"]["type"] . "<br />" .
																						//   "Размер: " . ($_FILES["photo"]["size"] / 1024) . "Kb<br />" .
																						//   "Временный файл: " . $_FILES["photo"]["tmp_name"] . "<br />" ;
																						//   move_uploaded_file($_FILES["photo"]["tmp_name"], "static/" . $_FILES["photo"]["name"]);
																						//   echo $file_result .= "Загрузка файла прошла успешно!";
																						// }
																					?>
																				</div>
																		</li>

																</ul>
														</div>
												</div>

												<div class="forma_top">
														<div class="forma_bottom">
																<ul class="fix_width">
																		<li class="form_line">
																				<label><b>Пароль</b></label>
																				<div class="form_content">
																						<input class="w300" type="password" maxlength="30" name="password" value="<?= $_POST['password']; ?>" /> </div>
																				<span class="form_prim">Придумайте пароль</span>
																		</li>
																		<li class="form_line">
																				<label><b>Повторите пароль</b></label>
																				<div class="form_content">
																						<input class="w300" type="password" maxlength="30" name="confirmpass" value="<?= $_POST['password']; ?>" /> </div>
																				<span class="form_prim"></span>
																		</li>
																		<li class="form_line_end">
																				<label></label>
																				<div class="form_content">
																						<input class="button_long" type="submit" value="Подать объявление" />
																				</div>
																		</li>
																</ul>
														</div>
												</div>

										</form>
								</div>

						</div>
				</div>

				<div id="dialog-region" title="Выберите регион">
				</div>
				<div id="dialog-city" title="Выберите город">
				</div>
				<div id="push"></div>
		</div>
		<div id="footer" style="text-align: center">
				&copy; 2019 - <a href="/info/terms/">Правила</a>
		</div>
</body>

</html>