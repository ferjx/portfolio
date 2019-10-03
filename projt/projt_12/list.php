<?php 
		session_start();

		// коннект с бд
		$link = mysqli_connect("localhost", "porfeus2", "dm9UDDdy88ds9", "porfeus2_uzbablo");

		// проверка ошибки конекта бд
		if (mysqli_connect_errno()) {
						echo "Ошибка коннекта бд: %s\n", mysqli_connect_error();
						exit;
		}

		// берем get url
		$result = mysqli_query( $link, 'SELECT * FROM `doska` WHERE `ok` = 1 AND `id` = ' . intval($_GET['id']) );
		$row = mysqli_fetch_assoc( $result );

		// "id" если нет направить на "404"
		if( empty($row['id']) ){
						header("Location: 404.php");
						exit;
		}

		
		// favorite
		// var_dump($_GET['id']);
		// var_dump(isset($_COOKIE['favorite']));
		// $favorites = [];
		// if ( isset($_COOKIE['favorites']) ) {

		// 	setcookie("favorites", $favorites);
		// 	$favorites = json_decode($_COOKIE["favorites"], true);
		// }else {
		// 	echo "true";
			
		// 	json_encode([
		// 			"status" 	=> 1,
		// 			"data" 		=> ["count" => "0"]
		// 		]
		// 	);
		// }
		
		// email message
		if( isset($_POST['send_message']) ) 
		{
				if( $_POST['from_email'] == '' ) { $error .= 'Введите ваш email корректно <br>'; }
				if( $_POST['msg'] == '' ) { $error .= 'Введите текст сообщения <br>'; }

				// отправляем сообщение
				require("phpmailer/mail.php");
				$to = $row["email"];
				$subject = $_SERVER['HTTP_HOST'] .': На ваше объявление получен ответ';
				$message = '
				<p><b>Тема</b>: '. $row['title'] .'</p>
				<p><b>Сообщение</b>: '. wordwrap($_POST['msg'], 100, "\r\n").'</p>
				<p><b>Отправитель</b>: '. $_POST['from_email'] .'</p>
				<p><b>Ссылка на объявление</b>: <a href="'. $_SERVER['HTTP_REFERER'] .'">'. $_SERVER['HTTP_HOST'] .'</a> </p>';

				send_mail($to, $subject, $message);

				die("ok");
		}

		// message 'form-type=jaloba&message='+text
		if( isset($_POST['form-type']) )
		{
				echo $_POST['text'];
				die("ok");
		}


		
		// stars
		if ( isset($_GET["rating"]) )
		{
					$voted_key = "voted_id_".$row["id"];
					if( isset($_SESSION[$voted_key]) ){
							// если уже голосовал
							$otvet = [
									'status' => 1,
									'res' => 'golosoval'
							];
					}else
					{
							$_SESSION[$voted_key] = 1;

							$query = 'UPDATE `doska` SET `stars_total` = `stars_total` + '. $_GET['rating'] .', `stars_num` = `stars_num` + 1 WHERE `id` = '. $_GET['id'];
							mysqli_query( $link, $query);

							// если голос принят
							$otvet = [
									'status' => 1,
									'res' => 'ok'
							];
					}
					die( json_encode($otvet) );
		}

		// stars result

		if (  $row['stars_total'] != 0 && $row['stars_num'] != 0 ) {
			$stars = round( $row['stars_total'] / $row['stars_num'] );
		}

		// views update
		mysqli_query( $link, 'UPDATE `doska` SET `views` = `views` + 1 WHERE `id` = '. $_GET['id'] );

		// views_date update
		if( $row["views_date"] != date("o-m-d") ){
		    mysqli_query( $link, "UPDATE `doska` SET `views_today` = 1 WHERE `id` = ". $_GET['id'] );
		    mysqli_query( $link, 'UPDATE `doska` SET `views_date` = NOW() WHERE `id` = '. $_GET['id'] );
		}else{
		    mysqli_query( $link, "UPDATE `doska` SET `views_today` = `views_today` + 1 WHERE `id` = ". $_GET['id'] );
		}

		// echo "<pre>";
		// print_r( $_SESSION );
		// echo "</pre>";
		// unset( $_SESSION[$voted_key] );
?>

<!DOCTYPE html>
<html lang="ru">

<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $row["title"]; ?></title>
		<meta name="description" content='' />
		<meta name="keywords" content='' />
		<meta property="og:title" content="" />
		<meta property="og:type" content="" />
		<meta property="og:url" content="" />
		<meta property="og:site_name" content="" />
		<meta property="og:description" content="" />
		<meta property="og:image" content="" />
		<meta property="og:image" content="" />
		<meta property="og:image" content="" />
		<link rel="stylesheet" href="css/style3.css" type="text/css" />
		<link rel="stylesheet" href="css/fotorama.css" type="text/css" />
		<link rel="stylesheet" href="css/jquery-ui-1.9.0.custom.css" type="text/css" />
		<link rel="stylesheet" href="css/jquery.webui-popover.css" type="text/css" />
		<link rel="stylesheet" type="text/css" href="css/images.css" />
		<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
		<!-- <link rel="yandex-tableau-widget" href="https://msk.kupiprodai.ru/yandex-tableau-manifest.json" /> -->
		<script src="js/jquery-1.8.2.min.js"></script>
		<script src="js/jquery-ui-1.9.0.custom.min.js"></script>
		<script src="js/params_data.js"></script>
		<script src="js/params_core.js?28012019"></script>
		<!-- <script src="js/send_mail.js?13"></script> -->
		<script src="js/comments.js?6"></script>
		<script src="js/spam.js?2"></script>
		<script src="js/spam_msg.js?2"></script>
		<script src="js/jquery.scrollTo.min.js"></script>
		<script src="js/jquery.form.js"></script>
		<script src="js/jquery.ifixpng.js"></script>
		<script src="js/jquery.fancyzoom.min.js"></script>
		<script src="js/metro_array.js"></script>
		<script src="js/metro_core.js"></script>
		<script src="js/bbslike.js?1"></script>
		<script src="js/images.js?v1.2"></script>
		<script src="js/jquery.fileupload.js"></script>
		<!-- <script src="//api-maps.yandex.ru/2.1/?lang=ru_RU"></script> -->
		<!-- <script src="https://kupiprodai.ru/js/yandex_map.js?2"></script> -->
		<script src="js/fotorama.js"></script>
		<script src="js/favorite.js?1"></script>
		<script src="js/jquery.cookie.js"></script>
		<script src="js/shareSocial.js?1"></script>
		<script src="js/jquery.webui-popover.js"></script>
		<script src="js/Chart.min.js"></script>
</head>

<body>
		<script>
				$(function() {
						vip_site = "list.php";
						site = "list.php";
						favorite_image_on = "images/favor_menu_on.png";
						favorite_image_off = "images/favor_menu_off.png";
						$('.favorite_popover').webuiPopover({
								title: " ",
								content: "Добавлено в <a href='" + site + "/favorite/'>избранное</a>",
								autoHide: 3000,
								trigger: 'manual'
						});
						img_add_like = "images/star_off.gif";
						img_remove_like = "images/star_on.gif";
						// like_help_link = "https://kupiprodai.ru/more/free/likehelp/";
						add_like_text = "Разместить здесь";
						remove_like_text = "Размещено";
						razdely = 75;
						autoopened = razdely == 9 ? true : false;
						coords = [55.796574, 37.769226];
						var rating;
						var bbs_id = <?php echo $row['id']; ?>;
						var back_cit = -1;
						var back_edit = 0;
						if (back_cit >= 0) $("[cit = " + back_cit + "][edit = " + back_edit + "]").first().click();
						$.fn.fancyzoom.defaultsOptions.imgDir = 'images/fancyzoom-images/';
						$("#grd_photo a").fancyzoom();
						$("#bbslike").html("<img alt='' src='" + img_add_like + "'>");
						$("#bbslike_text").html(add_like_text);
						var ctx = $("#watchChart");
						var watchChart = new Chart(ctx, {
								type: 'line',
								data: {
										labels: ["14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27"],
										datasets: [{
												label: "Кол-во просмотров",
												fill: false,
												lineTension: 0.1,
												backgroundColor: "rgba(75,192,192,0.4)",
												borderColor: "rgba(75,192,192,1)",
												borderCapStyle: 'butt',
												borderDash: [],
												borderDashOffset: 0.0,
												borderJoinStyle: 'miter',
												pointBorderColor: "rgba(75,192,192,1)",
												pointBackgroundColor: "#fff",
												pointBorderWidth: 1,
												pointHoverRadius: 5,
												pointHoverBackgroundColor: "rgba(75,192,192,1)",
												pointHoverBorderColor: "rgba(220,220,220,1)",
												pointHoverBorderWidth: 2,
												pointRadius: 3,
												pointHitRadius: 10,
												spanGaps: false,
										}]
								},
								options: {
										scales: {
												yAxes: [{
														ticks: {
																beginAtZero: true
														}
												}]
										},
										legend: {
												display: false,
										},
								}
						});
						dialog_wc = $("#dialog-watch-chart").dialog({
								autoOpen: false,
								height: 410,
								width: 950,
								modal: true
						});
						$(".watch-chart-link").click(function() {
								var chart_vals = $(this).attr('data-watch-vals');
								var allviews = $(this).attr('data-watch-allviews');
								var msg_id = $(this).attr('data-watch-msg-id');
								$("#watch-chart-allviews").html(allviews);
								watchChart.data.datasets[0].data = $.parseJSON(chart_vals);
								watchChart.update(0);
								dialog_wc.dialog('open');
								$(".ui-dialog-titlebar-close").focus();
								return false;
						});
						$(".ui-widget-overlay").live("click", function() {
								if ($("#spam_form").dialog("isOpen")) $("#spam_form").dialog("close");
								if ($("#msg_spam_form").dialog("isOpen")) $("#msg_spam_form").dialog("close");
								if ($("#dialog-watch-chart").dialog("isOpen")) $("#dialog-watch-chart").dialog("close");
						});
						$(".grd_data_rating").hover(
								function() {
										$('.grd_data_rating').webuiPopover('show');
										jQuery(this).prepend("<div class='rating_choose'></div>");
								},
								function() {
										$('.grd_data_rating').webuiPopover('hide');
										jQuery(this).find("div[class=rating_choose]").remove();
								});
						$(".grd_data_rating").mousemove(
								function(e) {
										if (!e) e = window.event;
										if (e.pageX) {
												x = e.pageX;
										} else if (e.clientX) {
												x = e.clientX + (document.documentElement.scrollLeft || document.body.scrollLeft) - document.documentElement.clientLeft;
										}
										var posLeft = 0;
										var obj = this;
										while (obj.offsetParent) {
												posLeft += obj.offsetLeft;
												obj = obj.offsetParent;
										}
										var offsetX = x - posLeft,
												modOffsetX = 5 * offsetX % this.offsetWidth;
										rating = parseInt(5 * offsetX / this.offsetWidth);
										if (modOffsetX > 0) rating += 1;
										$(this).find("div[class=rating_choose]").eq(0).css("width", rating * 17.8 + "px");
								});
						$(".grd_data_rating").click(function() {
								// alert(vip_site);
								// alert(bbs_id);
								// alert(rating);
								$.get(
										vip_site, {'id': bbs_id, 'rating': rating},
										function(ret) {
												console.log(ret);
												$('.grd_data_rating').webuiPopover('hide');
												if (ret.status == 0) {
														if (ret.res != '') alert(ret.res);
												} 
												else {
														$(".grd_data_rating").remove();
														if (ret.res == 'error') $("#grd_data").append("<div><b>Вы не можете проголосовать</b></div>");
														else if (ret.res == 'ok') $("#grd_data").append("<div><b>Ваш голос принят</b></div>");
														else $("#grd_data").append("<div><b>Вы уже голосовали</b></div>");
												}
										},'json');
								return false;
						});
						$('.grd_data_rating').webuiPopover({
								placement: 'auto-top',
								trigger: 'manual',
								type: 'html',
								content: "Показатель определен на основе оценки посетителей, количества просмотров и интереса пользователей к контактам продавца."
						});
						$('.link_more').webuiPopover({
								placement: 'auto-bottom',
								trigger: 'manual',
								type: 'html',
								url: '#menu-link-more'
						});
						$(".link_more").click(function() {
								$('.link_more').webuiPopover('toggle');
								return false;
						});
						dialog_siteenabled = $("#dialog-site-enabled").dialog({
								autoOpen: false,
								height: 160,
								width: 630,
								modal: true
						});
						dialog_sitereqeust = $("#dialog-site-request").dialog({
								autoOpen: false,
								height: 200,
								width: 400,
								modal: true
						});
						dialog_sitereqeust_code_not_full = $("#dialog-site-request-code-not-full").dialog({
								autoOpen: false,
								height: 120,
								width: 600,
								modal: true
						});
						dialog_sitecreate = $("#dialog-site-create").dialog({
								autoOpen: false,
								height: 200,
								width: 630,
								modal: true
						});
						$(".siteitemlink").click(function() {
								var siteAction = $(this).attr('data-action');
								$.get("/siterequest/", {
												'id': bbs_id,
												'siteaction': siteAction
										},
										function(ret) {
												//                $('.grd_data_rating').webuiPopover('hide');
												if (ret.status == 0) {
														if (ret.data != '') alert(ret.data);
												} else {
														switch (ret.data.siteaction) {
																case "siteenabled":
																		$("#dialog-site-enabled").html(ret.data.res);
																		dialog_siteenabled.dialog('open');
																		break;
																case "siterequest":
																		$("#dialog-site-request").html(ret.data.res);
																		dialog_sitereqeust.dialog('open');
																		break;
																case "siterequestcodenotfull":
																		$("#dialog-site-request-code-not-full").html(ret.data.res);
																		dialog_sitereqeust_code_not_full.dialog('open');
																		break;
																case "sitecreate":
																		$("#dialog-site-create").html(ret.data.res);
																		dialog_sitecreate.dialog('open');
																		break;
																default:
																		return false;
																		break;
														}
														$(".ui-dialog-titlebar-close").focus();
												}
										},
										'json');
								return false;
						});
				});
		</script>
		<div id="container">
				
				<?php include "header.php"; ?>

				<div id="content" itemscope itemtype="http://schema.org/Product">
						<!-- <div id="nav_msg">
								<a title="Доска бесплатных объявлений - Москва" href="#">Объявления Москва</a> <img src="images/arrow.gif" width="4" height="8" alt="" title="" /> <a title="Спорт, Активный отдых" href="#">Спорт, Активный отдых</a> <img src="images/arrow.gif" width="4" height="8" alt="" title="" />
								<a id="grd_next" href="#">Следующее</a>
						</div> -->

						<div id="cont_left">
								<div id="grd">
										<!-- <div id="grd_title">
												<div id="favor_title">
														<a class="favorite_add" title="Добавить в избранное" href="#" data-bbs_id="<?php echo $row['id'] ?>"><img alt="" width="30" height="29" src="images/favor_menu_off.png"></a>
												</div>
												<h1 id="h1_inner" itemprop="name"><?php echo $row["title"]; ?></h1>
										</div> -->
										<div id="grd_data">
												<div class="grd_data_info">

														№ <?php echo $row["id"] ?>, Размещено
														<span class="time">
																<?php
																		// echo $row["date"];
																		$time = strtotime($row["date"]);
																		if( date('d.m.y') == date('d.m.y', $time) ) {
																				echo 'сегодня ' . date('h:i', $time);
																		}
																		elseif( date('d.m.y', time()-86400) == date('d.m.y', $time ) ) {
																						echo 'вчера ' . date('h:i', $time);
																		}
																		else {
																				echo date('d.m.y', $time);
																		}
																?>
														</span>
												</div>
												<div class="grd_data_view">
														<img src="images/eye_icon.gif" width="18" height="11" alt="" title="" /> <a data-watch-vals='[1,0,1,0,1,2,1,1,1,0,2,1,0,8]' data-watch-msg-id='2365918' data-watch-allviews='330' class="watch-chart-link" href="#"><?php echo $row["views"]; ?><b>
														<?php 
																echo '+'. $row['views_today'];
														?>
															</b></a>
												</div>

												<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating" class="grd_data_rating">
														<div itemprop="ratingValue" style="width:<?php echo $stars * "20%" ?>%;" class="rating" content="<?php echo $stars; ?>"></div>
														<meta itemprop="ratingCount" content="72" />
														<img src="images/rating.png" width="89" height="16" alt="" title="" />
												</div>

												<span class="more"><a class="link_more" href="#">Еще</a></span>
												<!-- <span class="up"><a href="#">Поднять</a></span> -->
												<div id="menu-link-more" style="display: none">
														<ul class="dropdown-menu">
																<!-- <li>
																	<span class="send"><a href="#">Разослать</a></span>
																</li> -->
																<li>
																	<span class="edit"><a href="edit.php?id=<?php echo $_GET["id"]; ?>">Редактировать</a></span>
																</li>
																<li>
																		<span class="spam"><input type="button" class="spam_msg" data-bbs_id="<?php echo $row['id'] ?>" value="Жалоба" /></span>
																</li>
														</ul>
												</div>
										</div>
										<div id="sendmail_content" style="display: none;">
												<!-- <div id="send_error">Введите ваш email корректно<br>Введите текст сообщения<br></div> -->
												<div id="send_error"></div>
												<div class="clear100p">
														<span class="tab_icon tab_mail">Написать сообщение</span>

														<!-- <form id="sendform" method="POST" action="phpmailer/mail.php"> -->
														<form id="sendform" method="post" action="list.php?id=<?php echo $row['id']; ?>">
																<input type="hidden" name="send_message" value="1">
																<ul class="tabform">
																		<li class="form740_line">
																				<label><b>Ваш e-mail</b></label>
																				<div class="form740_content">
																						<input class="w300" type="text" id="send_email" name="from_email" value="<?php echo $_POST['from_email']; ?>">
																				</div>
																		</li>
																		<li class="form740_line">
																				<label><b>Текст сообщения</b></label>
																				<div class="form740_content2">
																						<textarea style="width:480px;" class="text740" id="send_msg" name="msg"><?php echo $_POST['msg']; ?></textarea>
																				</div>
																		</li>
																		<li class="form740_line_end">
																				<label></label>
																				<div class="form740_content">
																						<input class="button" id="sendmail_sub" type="button" value="Отправить">
																				</div>
																		</li>
																</ul>
														</form>

												</div>
										</div>

										<script>
												$(function(){
														$('.a_dotted').on('click', function(){
																		$('#sendmail_content').show( "slow" );
														})

														$('#sendmail_sub').on('click', function(){
																		var send_email = $('#send_email').val(),
																						send_msg = $('#send_msg').val();

																		$('#send_error').html('');
																		if( send_email == '' ) { $('#send_error').append('Введите ваш email корректно<br>') }
																		if( send_msg == '' ) { $('#send_error').append('Введите текст сообщения<br>') }
																		if( send_email && send_msg )
																		{
																						// alert("Сообщение успешно доставлено");
																						$.post($('form#sendform').attr('action'), $('form#sendform').serialize(), function(html){
																										if( html == 'ok' ) {
																														alert('Сообщение успешно доставлено!')
																														$('#sendmail_content').hide( "slow" );
																														$('#send_email').val('');
																														$('#send_msg').val('');
																										}else {
																														alert('Ошибка - объявление не найдено')
																										}
																						})
																		}

														})

												});
										</script>

										<div id="grd_photo">
												<div class="fotorama fotorama-numbers" data-allowfullscreen="true" data-maxheight="460" data-width="690" data-fit="contain" data-nav="thumbs" data-thumbwidth="112" data-thumbheight="80">
														<img itemprop="image" alt="" src="<?php echo $row["photo"]; ?>">
												</div>
										</div>

										<div id="grd_text">
												<table class="params_table">
														<tr>
																<td><b>Категория</b>
																		<td>
																				<td>
																						<?php echo $row["category_type"]; ?>
																						<?php echo $row["category"]; ?>
																						<?php echo $row["category_add"]; ?>
																				</td>
														</tr>
												</table>
												<p itemprop="description"><?php echo $row["text"]; ?></p>
												<br />

												<!-- <input class="map_button" type="button" data-msg_id="2365918" value="Показать на картe" id="yandex_map_toggle" /> -->
												<br />
												<br />
												<div id="yandex_map" style="display:none; width: 700px; height: 380px"></div>
												<br /> Друзья помогут купить или продать:
												<br />
												<div class="soc_share_full">
														<a class="vk" href="#" onclick="Share.vkontakte('<?php echo $_SERVER['HTTP_REFERER']; ?>','<?php echo $row['title']; ?>','<?php echo $row['photo']; ?>','<?php echo mb_strimwidth($row['text'], 0, 50, '...'); ?>','<?php echo $_GET['id']; ?>'); return false;">Вконтакте</a>

														<a class="facebook" href="#" onclick="Share.facebook('<?php echo $_SERVER['HTTP_REFERER']; ?>','<?php echo urlencode($row['title']); ?>','<?php echo $row['photo']; ?>','<?php echo urlencode( mb_strimwidth($row['text'], 0, 50, '...') ); ?>','<?php echo $_GET['id']; ?>'); return false;">Facebook</a>

														<a class="twitter" href="#" onclick="Share.twitter('<?php echo $_SERVER['HTTP_REFERER']; ?>','<?php echo $row['title']; ?>','<?php echo $_GET['id']; ?>'); return false;">Twitter</a>

														<a class="mymail" href="#" onclick="Share.mailru('<?php echo $_SERVER['HTTP_REFERER']; ?>','<?php echo $row['title']; ?>','<?php echo $row['photo']; ?>','<?php echo mb_strimwidth($row['text'], 0, 50, '...'); ?>','<?php echo $_GET['id']; ?>'); return false;">Мой мир</a>

														<a class="odnoklas" href="#" onclick="Share.odnoklassniki('<?php echo $_SERVER['HTTP_REFERER']; ?>','<?php echo mb_strimwidth($row['text'], 0, 50, '...'); ?>','<?php echo $row['photo']; ?>','<?php echo $_GET['id']; ?>'); return false;">Одноклассники</a>
												</div>
										</div>
								</div>

								<div id="grd_menu">
										<div id="grd_menu_left">
												<!-- <a class="reply comment_link" data-cit=0 data-edit=0 data-bbs_id="<?php //echo $row['id'] ?>">Комментировать</a> -->
										</div>

										<div id="grd_act">
												<span class="spam"><input type="button" class="spam_msg" data-bbs_id="<?php echo $row['id'] ?>" value="Жалоба" /></span>

												<span class="edit"><a href="edit.php?id=<?php echo $_GET["id"]; ?>">Изменить</a></span>
												<!-- <span class="send"><a href="/place">Разослать</a></span> -->
												<!-- <span class="up"><a href="/upmsg">Поднять</a></span> -->

												<!-- <div id="favor">
														<div data-bbs_id="<?php //echo $row['id'] ?>" class="favorite_popover"></div>
														<a class="favorite_add" title="Добавить в избранное" href="#" data-bbs_id="<?php //echo $row['id'] ?>"><img alt="" width="17" height="16" src="images/favor_menu_off.png"> Избранное</a>
												</div> -->
										</div>
								</div>

								<div id="comment_content"></div>

								<div id="star_tag">
										<!-- <a id="star_link" href="/register">Разместить бесплатно</a> -->
										<a id="star_link">Разместить бесплатно</a>
								</div>

								<div id="sim">

										<?php
												$where = 'WHERE 1 AND `ok`="1"';

												if ( $result_second = mysqli_query($link, "SELECT * FROM `doska` ". $where ." AND `region`='". $row['region'] ."' AND `category` = '". $row['category'] ."' ORDER BY rand() LIMIT 4") ) :
														// получаем записи
														while ($row_second = mysqli_fetch_assoc($result_second)) :
										?>

										<div>
												<a href="list.php?id=<?php echo $row_second["id"]; ?>">
														<img src="<?php if( $row_second['photo'] == '' ) { echo "images/nophoto.gif"; } else { echo $row_second['photo']; }  ?>" alt="<?php echo $row_second['title']; ?>" title="<?php echo $row_second['title']; ?>">
												</a>
												<a href="list.php?id=<?php echo $row_second["id"]; ?>"><?php echo $row_second['title']; ?></a>
												<br /><span><?php echo $row_second['price']; ?></span>
												<br /><span><?php echo $row_second['region']; ?></span>
										</div>

										<?php
														endwhile;
												endif;
										?>
								</div>
						</div>

						<div id="cont_right">
								<div id="grd_contacts" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
										<div id="grd_price"><span itemprop="price" content="1500"><?php echo $row['price']; ?></span> <span class="price_currency" itemprop="priceCurrency" content="RUB">сум.</span></div>

										<div class="tel" id='phone'>
												<a class="tel_link" onclick="$('#phone').html('<span class=\'numbr\'><?php echo $row['phone']; ?></span>')">Показать телефон<br /><?php echo mb_substr($row['phone'], 0, 11); ?>-XX-XX</a>
										</div>

										<div id="grd_info">
												<div id="email">
														<a class="email_abs sendmail" data-bbs_id="<?php echo $row['id'] ?>"></a>
														<a class="a_dotted sendmail" data-bbs_id="<?php echo $row['id'] ?>">Написать сообщение</a>
												</div>

												<div id="seller"><?php echo $row["name"]; ?></div>
												<div id="shema" itemprop="availableAtOrFrom"><?php echo $row["region"]; ?></div>

										</div>
								</div>


						</div>
				</div>

				<div id="push"></div>
		</div>
		<div id="spam_form" title='Оставить жалобу'>
				Причина жалобы:
				<br />
				<textarea class="w300" id="spam_text" name="spam_text" rows="3"></textarea>
				<br />
				<br />
				<input class="button" id="send_spam" type="button" value="Пожаловаться">
		</div>
		<div id="msg_spam_form" title='Оставить жалобу'>
				<a class="spam_reason_link" href="#">Уже продано</a>
				<br />
				<a class="spam_reason_link" href="#">Вымышленный объект</a>
				<br />
				<a class="spam_reason_link" href="#">Неверная цена</a>
				<br />
				<a class="spam_reason_link" href="#">Неверный адрес</a>
				<br />
				<a class="spam_reason_link" href="#">Не дозвониться</a>
				<br />
				<a class="spam_reason_link" href="#">Контакты и ссылки в описании</a>
				<br />
				<a class="spam_reason_link" href="#">Мошенничество с деньгами</a>
				<br />
				<br /> Другая причина:
				<textarea class="w300" id="msg_spam_text" name="spam_text" rows="3"></textarea>
				<br />
				<br />
				<input class="button" id="msg_send_spam" type="button" value="Пожаловаться">
		</div>

		
		<script>
			$(function() {
			    $( "#msg_spam_form" ).dialog({
			        autoOpen:false,
			        height:370,
			        width:340,
			        modal: true
			    });

			    $( ".spam_msg" ).live("click",function() {
			            bbs_id = $(this).attr('data-bbs_id');
			            $( "#msg_spam_form" ).dialog( "open" );
			    });

			    $("#msg_send_spam, .spam_reason_link").click(function() {
			        if ( $(this).is("A") ) var text = $(this).text();
			        else var text = $('#msg_spam_text').val();

			        if ( text != "" ) {
			        	$.post("list.php?id=<?php echo $row['id'] ?>", 'form-type=jaloba&message='+text, function(data){
			        	    if ($.trim(data) != "ok") {
			        	        alert(data);
			        	    }
			        	    else {
			        	        $( "#msg_spam_form" ).dialog( "close" );
			        	        alert("Спасибо! Ваша жалоба отправлена администрации сайта.\nМы постараемся обработать её в ближайшее время, но не можем гарантировать точные сроки.");
			        	    }
			        	});
			        }else {
			        	alert("Укажите причину");
			        }
			        return false;
			    });
			});
		</script>

		<?php include "footer.php"; ?>

		<div id="dialog-watch-chart" title="Динамика просмотров">
				<p><span id="watch-chart-allviews"></span> просмотра(ов)</p>
				<div style="width: 910px;">
						<canvas id="watchChart" width="300" height="100"></canvas>
				</div>
		</div>
		<div id="dialog-site-enabled" title="Указать сайт"></div>
		<div id="dialog-site-request" title="Перейти на сайт"></div>
		<div id="dialog-site-request-code-not-full" title="На сайте код не полный"></div>
		<div id="dialog-site-create" title="Вам подарок - сайт?"></div>
</body>

</html>