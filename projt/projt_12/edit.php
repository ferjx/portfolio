<?php 

	/* коннект базы*/
	$link = mysqli_connect("localhost", "porfeus2", "dm9UDDdy88ds9", "porfeus2_uzbablo");

	/* проверка коннекта */
	if (mysqli_connect_errno()) {
		echo "Ошибка коннекта: %s\n", mysqli_connect_error();
		exit;
	}

	foreach( $_POST as $k => $v) {
		$_POST[$k] =  mysqli_real_escape_string( $link, $_POST[$k] );
	}/* Конец. коннект базы*/


	$error 			= '';

	$id 						= $_POST["id"];
	$name 				= $_POST["name"];
	$email 			= $_POST["email"];
	$telegram = $_POST["telegram"];
	$phone 			= $_POST["phone"];
	$region 		= $_POST["region"];
	$address 	= $_POST["address"];
	$category = $_POST["category"];
	$category_add 		= $_POST["category_add"];
	$category_type 	= $_POST["category_type"];
	$title 			= $_POST["title"];
	$text 				= $_POST["text"];
	$site 				= $_POST["site"];
	$price				= $_POST["price"];
	$photo 			= $_POST["photo"];
	$password = $_POST["password"];
	$date 				= $_POST["date"];
	$ree_pass = $_POST['ree_pass'];

	// url get
	$result = mysqli_query( $link, 'SELECT * FROM `doska` WHERE `ok` = 1 AND `id` = ' . intval($_GET['id']) );
	$row 			= mysqli_fetch_assoc( $result );

	// существует ли id
	if( empty($row['id']) ){
	    // объявление не дайдено
	    header("Location: 404.php");
	    exit;
	}

	// редактировать объявление. "проверяем ошибку"
	if ( $_POST['ree_action'] == "1" ) {
			if ( $ree_pass == '' ) { $error .= 'Заполните поле<br>'; }
			if ( $ree_pass == true && $ree_pass != $row['password'] ) { $error .= 'Неправильный пароль<br>'; }
			if ( $ree_pass == $row['password'] ) { 
				header("Location: edit.php?id=". $row['id'] ."&password=". $row['password'] );
				exit;
			}
	}

	// echo "<pre>";
	// var_dump( !empty($row['photo']) );
	// echo "</pre>";

	// Подать объявление
	if( $_POST["action"] == "add_form" ) 
	{
		if(	$name == '' )  			{ $error .= 'Не указано Ваше имя <br>'; }
		if( $email == '' ) 			{ $error .= 'Не указано E-mail <br>'; }
		if( $phone == '' ) 			{ $error .= 'Не указано Ваше телефон <br>'; }
		if( $region == '' ) 		{ $error .= 'Не указано Ваше Регион <br>'; }
		if( $category == '' ) { $error .= 'Укажите категорию <br>'; }
		if( $category_type == '' ) { $error .= 'Укажите тип <br>'; }
		if( $title == '' ) 			{ $error .= 'Укажите заголовок <br>'; }
		if( $text == '' ) 				{ $error .= 'Укажите Текст объявления <br>'; }
		if( $price == '' ) 			{ $error .= 'Укажите цену <br>'; }
		if( $password == '' ) { $error .= 'Не указан пароль <br>'; }
		if( $_POST["password"] !== $_POST["confirmpass"] ) { $error .= 'Повторный пароль не совпадает <br />'; }
		
		// проверяем формат photo
		if( !empty($_FILES["photo"]) )
		{
				if( !empty($_FILES["photo"]["name"]) )
				{
						$original = $_FILES["photo"]["name"];
						if( strstr($original, '.jpg') ) {
										$format = '.jpg';
						}else
						if( strstr($original, '.png') ) {
										$format = '.png';
						}else
						if( strstr($original, '.gif') ) {
										$format = '.gif';
						}else {
										$error .= 'Неправильный формат фото <br>';
						}
				}
			}
			
			if( $error == "" )
			{
					// создаем файл .jpg, .png
					$newFile = $row['photo'];
					if( !empty($_FILES["photo"]) && !empty($_FILES["photo"]["tmp_name"]) )
					{	
							if ( !empty($row['photo']) ) {
									unlink($row['photo']);
							}
							$file = $_FILES["photo"]["tmp_name"];
							$newFile = 'uploads/'.time().'_'.uniqid().$format;
							copy($file, $newFile);
							
					}

					/* подготавливаем запрос */
					$query = "UPDATE `doska` SET `name` = '". $name ."', `email` = '". $email ."', `telegram` = '". $telegram ."', `phone` = '". $phone ."', `region` = '". $region ."', `address` = '". $address ."', `category` = '". $category ."', `category_add` = '". $category_add ."', `category_type` = '". $category_type ."', `title` = '". $title ."', `text` = '". $text ."', `site` = '". $site ."', `price` = '". $price ."', `photo` = '". $newFile ."', `password` = '". $password ."', `date` = NOW() WHERE `id` =". $_GET['id'];

					/* выполняем запрос */
					if( !mysqli_query($link, $query) ) 
					{
						echo "Ошибка добавления записи: %s\n", mysqli_error();
						exit;
					}

					/* закрываем соединение */
					mysqli_close($link);

					// header("Location: index.php");
					header("Location: edit.php?id=". $row['id'] ."&password=". $row['password'] ."&status=ok");
					exit;
			}
	}

	mysqli_close($link);
?>
<!DOCTYPE html>
<html lang="ru">

<head>
		<title>Размещение объявлений на uzMoney бесплатно</title>
		<meta name="keywords" content='webmoney продать, купить webmoney' />
		<meta name="description" content='Подать объявление на uzbablo бесплатно и разместить еще на 100 досок объявлений' />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="css/style_main.css?28012019" type="text/css" />
		<link rel="stylesheet" href="css/style1.css?28012019" type="text/css" />
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
				</div>
				<div id="menu">
						<a id="menu_first" href="#"></a>
						<a href="/" class="menu_noact">Доски объявлений</a>
						<a href="/list.php?id=<?php echo $_GET['id']; ?>" class=" menu_act">Открыть страницу объявления</a>
						<a href="/add.php" class="menu_noact">Подать объявление</a>
				</div>

				<!-- <div id="top">
						<div id="logo">
								<span>размещение объявлений</span>
								<a href="/"><img src="images/logo_line.gif" width="214" height="27" alt="КупиПродай" title="КупиПродай" /></a>
						</div>
				</div>
				<div id="menu">
						<a id="menu_first" href="#"></a>
						<a href="/" class="menu_noact">Доски объявлений</a>
						<a href="/add.php" class=" menu_act">Подать объявление</a>
				</div> -->
				<div id="content">
						<div id="content_padd">
								<div class="clear_nopadd">

										<?php
											if ( $error != '' ):
										?>
												<div class="error">
													<?php echo $error; ?>
												</div>
										<?php
											elseif( empty($error) && !empty($_GET['password']) && !empty($_GET['status']) ):
										?>
												<div class="success">
													<?php echo "Объявление отредактировано! "; ?>
												</div>
										<?php
											endif;
										?>


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

								<?php if ( $_GET['password'] == $row['password'] ) { ?>
										<h1>Редактировать объявление</h1>
										<form method="POST" name="add" enctype="multipart/form-data" action="">
											<input type="hidden" name="action" value="add_form">
											
												<div class="forma_top">
														<div class="forma_bottom">
																<ul class="fix_width">
																		<li class="form_line">
																				<label><b>Ваше имя</b></label>
																				<div class="form_content">
																						<input class="w300" type="text" maxlength="100" name="name" value="<?= $_POST['name'] == '' ? $row['name'] : $_POST['name']; ?>" /> </div>
																		</li>
																		<li class="form_line">
																				<label><b>E-mail</b></label>
																				<div class="form_content">
																						<input class="w300" type="text" maxlength="100" name="email" value="<?= $_POST['email'] == '' ? $row['email'] : $_POST['email']; ?>" /> </div>
																		</li>
																		<li class="form_line">
																				<label><b>Telegram</b></label>
																				<div class="form_content">
																						<input class="w300" type="text" maxlength="100" name="telegram" value="<?= $_POST['telegram'] == '' ? $row['telegram'] : $_POST['telegram']; ?>" />
																				</div>
																				<span class="form_prim">Укажите без символа @</span>
																		</li>
																		<li class="form_line">
																				<label><b>Телефон</b></label>
																				<div class="form_content">
																						<input class="w300" type="text" maxlength="100" name="phone" value="<?= $_POST['phone'] == '' ? $row['phone'] : $_POST['phone']; ?>" />
																				</div>
																				<span class="form_prim">Пример: 99890 1234567</span>
																		</li>
																		<li class="form_line">
																				<label><b>Регион</b></label>
																				<div class="form_content">
																						<select class="select_long" name="region" id="citi_id">
																							<option <?php if( $row["region"] == "Ташкент" ) {echo " selected";} ?>>Ташкент</option>
																							<option <?php if( $row["region"] == "Ташкентская область" ) {echo " selected";} ?>>Ташкентская область</option>
																							<option <?php if( $row["region"] == "Андижанская область" ) {echo " selected";} ?>>Андижанская область</option>
																							<option <?php if( $row["region"] == "Бухарская область" ) {echo " selected";} ?>>Бухарская область</option>
																							<option <?php if( $row["region"] == "Джизакская область" ) {echo " selected";} ?>>Джизакская область</option>
																							<option <?php if( $row["region"] == "Каракалпакстан" ) {echo " selected";}  ?>>Каракалпакстан</option>
																							<option <?php if( $row["region"] == "Кашкадарьинская область" ) {echo " selected";} ?>>Кашкадарьинская область</option>
																							<option <?php if( $row["region"] == "Навоийская область" ) {echo " selected";} ?>>Навоийская область</option>
																							<option <?php if( $row["region"] == "Наманганская область" ) {echo " selected";} ?>>Наманганская область</option>
																							<option <?php if( $row["region"] == "Самаркандская область" ) {echo " selected";} ?>>Самаркандская область</option>
																							<option <?php if( $row["region"] == "Сурхандарьинская область" ) {echo " selected";} ?>>Сурхандарьинская область</option>
																							<option <?php if( $row["region"] == "Сырдарьинская область" ) {echo " selected";} ?>>Сырдарьинская область</option>
																							<option <?php if( $row["region"] == "Ферганская область" ) {echo " selected";} ?>>Ферганская область</option>
																							<option <?php if( $row["region"] == "Хорезмская область" ) {echo " selected";} ?>>Хорезмская область</option>
																						</select>
																				</div>
																				<span class="form_prim">Напишите Ваш город</span>
																		</li>
																		<li class="form_line_end">
																				<label>Адрес</label>
																				<div class="form_content">
																						<input class="w300" type="text" maxlength="100" name="address" value="<?= $_POST['address'] == '' ? $row['address'] : $_POST['address']; ?>" />
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
															<option value="">Выбрать</option>
															<option value="webmoney" <?php if( $row["category"] == "webmoney" ){ echo " selected"; } ?>>Webmoney</option>
															<option value="qiwi" <?php if( $row["category"] == "qiwi" ){ echo " selected"; } ?>>QIWI</option>
															<option value="yamoney" <?php if( $row["category"] == "yamoney" ){ echo " selected"; } ?>>Яндекс деньги</option>
															<option value="crypto" <?php if( $row["category"] == "crypto" ){ echo " selected"; } ?>>Криптовалюты</option>
															<option value="uzcard" <?php if( $row["category"] == "uzcard" ){ echo " selected"; } ?>>UzCard</option>
															<option value="other" <?php if( $row["category"] == "other" ){ echo " selected"; } ?>>Другие</option>
													</select>
											</div>




																		</li>
																		<li class="form_line">
																			<label style="padding-top:5px;"></label>
																			<div id="category_add">
																			</div>
																		</li>

																		<script>
																			$(function() {
																					$('#cat_id').change(function(){
																						var val = $( this).val();
																						if( val == 'webmoney' )
																						{
																							$('#category_add').html(
																								'<select class="select_long" name="category_add"><option >Выбрать</option><option <?php if( $row["category_add"] == "WMZ" ) {echo " selected";} ?>>WMZ</option><option <?php if( $row["category_add"] == "WMR" ) {echo " selected";} ?>>WMR</option><option <?php if( $row["category_add"] == "WME" ) {echo " selected";} ?>>WME</option></select>'
																							);
																						} else if( val == 'crypto' )
																						{
																							$('#category_add').html(
																								'<select class="select_long" name="category_add"><option >Выбрать</option><option <?php if( $row["category_add"] == "Bitcoin" ) {echo " selected";} ?>>Bitcoin</option><option <?php if( $row["category_add"] == "Ethereum" ) {echo " selected";} ?>>Ethereum</option><option <?php if( $row["category_add"] == "Litcoin" ) {echo " selected";} ?>>Litcoin</option><option <?php if( $row["category_add"] == "Monero" ) {echo " selected";} ?>>Monero</option><option <?php if( $row["category_add"] == "Dash" ) {echo " selected";} ?>>Dash</option></select>'
																							);
																						} else
																						{
																							$('#category_add').html('');
																						}
																					});
																					$('#cat_id').triggerHandler('change');
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
																						<input class="w300" onkeypress="numchars( 'add','1')" onkeydown="numchars( 'add','1' )" onkeyup="numchars( 'add','1' )" onfocus="set_title_from_params($(this)); numchars( 'add','1' );" onchange="numchars( 'add','1' )" type="text" maxlength="80" name="title" value="<?= $_POST['title'] == '' ? $row['title'] : $_POST['title']; ?>" /> </div>
																				<span id="msgtitle" class="form_prim">максимально 80 символов</span>
																				<img class="vopros" title="В текст заголовка нельзя включать номера телефонов, адреса электронной почты. Набор слов заглавными буквами разрешен только для написания аббревиатур. Контактную информацию нужно указывать в соответствующих полях ниже." src="images/vopros.gif" width="22" height="22" alt="" />
																		</li>
																		<li class="form_line">
																				<label><b>Текст объявления</b></label>
																				<div class="form_content_long2">
																						<textarea class="w500" onkeypress="numchars( 'add','2' )" onkeydown="numchars( 'add','2' )" onkeyup="numchars( 'add','2' )" onfocus="numchars( 'add','2' )" onchange="numchars( 'add','2' )" rows="8" maxlength="3000" name="text"><?= $_POST['text'] == '' ? $row['text'] : $_POST['text']; ?></textarea>
																						<div id="msgtext" class="form_content_prim">максимально 3000 символов</div>
																				</div>
																				<img class="vopros" title="В текст объявления нельзя включать номера телефонов, адреса электронной почты. Набор слов заглавными буквами разрешен только для написания аббревиатур. Контактную информацию нужно указывать в соответствующих полях ниже." src="images/vopros.gif" width="22" height="22" alt="" />
																		</li>
																		<li class="form_line">
																				<label>Адрес сайта</label>
																				<div class="form_content">
																						<input class="w300" type="text" maxlength="100" name="site" value="<?= $_POST['site'] == '' ? $row['site'] : $_POST['site']; ?>" />
																				</div>
																				<span class="form_prim">(если есть)</span>
																		</li>
																		<li class="form_line">
																				<label><b>Цена</b></label>
																				<div class="form_content">
																						<input class="w300" type="text" maxlength="30" name="price" value="<?= $_POST['price'] == '' ? $row['price'] : $_POST['price']; ?>" /> </div>
																				<span class="form_prim">Пример: 10000 (только цифры)</span>
																		</li>

																		<li class="form_line_end">
																				<label style="padding-top:3px;">Добавить фото</label>
																				<div class="form_content_long">
																					<input type="file" name="photo" id="photo" class="inputfile" data-multiple-caption="{count} files selected" accept=".jpg, .png, .gif">
																				</div>
																		</li>

																</ul>
														</div>
												</div>

												<div class="forma_top">
														<div class="forma_bottom">
																<ul class="fix_width">
																		<li class="form_line">
																				<label><b>Новый пароль:</b></label>
																				<div class="form_content">
																						<input class="w300" type="password" maxlength="30" name="password" value="<?= $_POST['password'] == '' ? $row['password'] : $_POST['password']; ?>" /> </div>
																				<span class="form_prim">Придумайте пароль:</span>
																		</li>
																		<li class="form_line">
																				<label><b>Повторите пароль:</b></label>
																				<div class="form_content">
																						<input class="w300" type="password" maxlength="30" name="confirmpass" value="<?= $_POST['password'] == '' ? $row['password'] : $_POST['password']; ?>" /> </div>
																				<span class="form_prim"></span>
																		</li>
																		<li class="form_line_end">
																				<label></label>
																				<div class="form_content">
																						<input class="button_long" name="action_submit" type="submit" value="Сохранить изменения" />
																				</div>
																		</li>
																</ul>
														</div>
												</div>
										</form>
								<?php } else { ?>
										<div id="nav">
											<a href="/">Доска объявлений</a> 
											<img src="images/arrow.gif" width="4" height="8" alt="" title=""> 
											<span>Редактировать объявление</span>
										</div>
										<form method="POST" name="ree_form_pass" action="">
											<input type="hidden" name="ree_action" value="1">
											<div class="forma_top">
													<div class="forma_bottom">
															<span class="tab_icon tab_mail">редактировать объявление</span>
															<ul class="fix_width">
																	<li class="form_line">
																			<label><b>Пароль:</b></label>
																			<div class="form_content">
																					<input class="w300" type="password" maxlength="30" name="ree_pass" value="" /> 
																			</div>
																			<span class="form_prim">Введите старый</span>
																	</li>
																	<li class="form_line_end">
																			<label></label>
																			<div class="form_content">
																					<input class="button_long" type="submit" value="Редактировать" />
																			</div>
																	</li>
															</ul>
													</div>
											</div>
										</form>
								<?php } ?>


										



										
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