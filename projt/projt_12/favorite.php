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
										vip_site,
										{'id': bbs_id, 'rating': rating},
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

				<div id="content">
					<div id="cont_left">
						<div id="nav">
							<a href="https://kupiprodai.ru/">Доска объявлений</a> <img alt="" height="8" src="https://kupiprodai.ru/images/arrow.gif" title="" width="4"> Избранное
						</div>
						<div class="msgs margin_bottom">
							<div class="filter">
								<span id="filter_act">Объявления 4</span> <span><a href="https://kupiprodai.ru/favorite/search/">Поиск</a></span>
							</div>
							<div class="clear740">
								<form action="https://kupiprodai.ru/favorite/del/" method="post">
									<table class="favorite_table">
										<tr>
											<th></th>
											<th class="center td_width32"><input name="checkall" onclick="checkAll(this.form,'chek[]',this.checked);" type="checkbox"></th>
										</tr>
										<tr>
											<td class="padding_none" colspan="2">
												<div class="line_white">
													<div class="line_photo">
														<input class="pusto" name="chek[]" type="checkbox" value="3420689"> <a href="https://msk.kupiprodai.ru/auto/moscow_zapchasti_dvigatel_DDD_Audi_A6_20D_novyy_s_navesnym_3420689"><img alt="" src="https://img02.kupiprodai.ru/052019/1557338036406.jpg" title="Двигатель DDD Audi A6 2.0D новый с навесным"></a>
													</div>
													<div class="line_text" title="Двигатель 2.0 TDI DDD на Audi A6 Ауди. Мотор 2019 года с пробегом 400 км - с тестовой машины. Из Германии, состояние нового.">
														<a class="line_title" href="https://msk.kupiprodai.ru/auto/moscow_zapchasti_dvigatel_DDD_Audi_A6_20D_novyy_s_navesnym_3420689">Двигатель DDD Audi A6 2.0D новый с навесным</a> <span class="params">Вид товара: Запчасти;&nbsp; Тип товара: Для автомобилей;&nbsp;</span> <span class="price">225 000 руб.</span>
													</div>
													<div class="line_info">
														Сергеймотор<br>
														<a href="https://msk.kupiprodai.ru/auto/moscow_zapchasti/">Москва</a> <img alt="Москва" height="15" src="https://kupiprodai.ru/images/map_icon.png" title="Москва" width="16"><br>
														Просмотров: 0<br>
														Сегодня, <span class="time">20:55</span>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td class="favorite_table_end border_none" colspan="2"><input type="submit" value=""></td>
										</tr>
									</table>
								</form>
							</div>
						</div>
					</div>
					<div align="center" id="cont_right">
						<!-- Яндекс.Директ -->
						<div id="yandex_ad"></div>
						<script type="text/javascript">
						(function(w, d, n, s, t) {w[n] = w[n] || [];w[n].push(function() {Ya.Direct.insertInto(136546, "yandex_ad", {ad_format: "direct",font_size: 1,type: "vertical",limit: 3,title_font_size: 2,links_underline: false,site_bg_color: "FFFFFF",header_bg_color: "FFFFFF",title_color: "2A6CB6",url_color: "2A6CB6",text_color: "000000",hover_color: "B1282D",sitelinks_color: "2A6CB6",favicon: true,no_sitelinks: false});});t = d.getElementsByTagName("script")[0];s = d.createElement("script");s.src = "//an.yandex.ru/system/context.js";s.type = "text/javascript";s.async = true;t.parentNode.insertBefore(s, t);})(window, document, "yandex_context_callbacks");
						</script>
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
</body>

</html>