<?php 
	// коннект с бд
	$link = mysqli_connect("localhost", "porfeus2", "dm9UDDdy88ds9", "porfeus2_uzbablo");

	// проверка ошибки конекта бд
	if (mysqli_connect_errno()) {
			echo "Ошибка коннекта бд: %s\n", mysqli_connect_error();
			exit;
	}

	// pagination
	// количество страниц объявления
	$PAGES_NUM = 5;

	// в мускул, выводимых страниц объявления
	$PAGES_GET = abs( ( empty((string)$_GET['page']) ? 1 : (string)$_GET['page'] ) * $PAGES_NUM - $PAGES_NUM );
	
	// дисконнект бд
	// mysqli_close($link);
?>
<!DOCTYPE html>
<html lang="ru">

<head>
		<title>Narmala.com - бесплатные объявления в России от частных лиц и компаний</title>
	
		<!-- no-index -->
	  <meta name="robots" content="noindex">
	  <meta name="googlebot" content="noindex">
	  <!-- no-index -->

		<meta name="keywords" content="купить/продать webmoney в узбекистане, обменть webmoney, электронные деньги в Ташкенте" />
		<meta name="description" content="Доска объявлений в Ташкенте по размешению электронных денег" />
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<!-- <meta name='yandex-verification' content='' /> -->
		<link rel="stylesheet" href="css/style1.css?28012019" type="text/css" />
		<link rel="stylesheet" href="css/jquery-ui-1.9.0.custom.css" type="text/css" />
		<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
		<!-- <link rel="yandex-tableau-widget" href="https://voronezh.kupiprodai.ru/yandex-tableau-manifest.json" /> -->
		<meta name="google-site-verification" content="" />
		<meta name='yandex-verification' content='' />
		<script src="js/jquery-1.8.2.min.js"></script>
		<script src="js/jquery-ui-1.9.0.custom.min.js"></script>
		<script src="js/params_data.js"></script>
		<script src="js/params_core.js?28012019"></script>
		<script src="js/metro_array.js"></script>
		<script src="js/metro_core.js"></script>
		<script src="js/shareSocial.js?1"></script>
		<!-- <script src="//yandex.st/share/share.js" charset="utf-8"></script> -->
		<script src="js/city_ind_show_more.js?4"></script>

</head>

<body>
		<div id="container">

				<?php include "header.php"; ?>

				<div id="content">
						<div class="clear">
								<div id="ind_left">
										<h1 id="h1_main">Объявления в России</h1>



										<div id="msgs_ind">
												<?php
													// function getTime($date){
													// 	// $row["date"] 
													// 	$time = strtotime($date);
													// 	return date("d.m.Y", $time);
													// }
													$where = 'WHERE 1 AND `ok`="1"';

													// Фильтр поиска
													if ( $_GET['region'] != '' ) $where .= ' AND region="'.$_GET['region'].'"';
													if ( $_GET['category'] != '' ) $where .= ' AND category="'.$_GET['category'].'"';
													if ( $_GET['category_add'] != '' ) $where .= ' AND category_add="'.$_GET['category_add'].'"';
													if ( $_GET['category_type'] != '' ) $where .= ' AND category_type="'.$_GET['category_type'].'"';
													// if ( $_GET['search'] != '' ) $where .= ' and name"'.$_GET['search'].'"';
													// if ( $_GET['search'] != '' ) $where .= ' and title, text like "%'.$_GET['search'].'%"';
													if ( $_GET['search'] != '' ) $where .= ' AND concat(name, text, title) like "%'.$_GET['search'].'%"';

													$query = "SELECT * FROM `doska` $where ORDER BY id DESC LIMIT $PAGES_GET,$PAGES_NUM;";

													if ($result = mysqli_query($link, $query)) :
														// получаем записи
														while ($row = mysqli_fetch_assoc($result)) :
												?>
														<div class="line_ind_grey">
																<div class="line_photo_ind">
																		<img alt="<?php echo $row["category"]; ?>" src="<?php if( $row['photo'] == '' ) { echo "images/nophoto.gif"; } else { echo $row['photo']; }  ?>" width="140" height="100" /> 
																</div>
																<div class="line_text_ind" title="<?php echo $row["title"]; ?>">
																		<a class="line_title_ind" href="list.php?id=<?php echo $row["id"]; ?>"><?php echo $row["title"]; ?></a>
																		<span class="params_ind"><?php echo mb_strimwidth($row["text"], 0, 300, "...")  ?></span>
																		<?php
																			if( $row["price"] > 0 ) 
																				{
																		?>
																						<span class="price_ind"><?php echo $row["price"] ?></span>
																		<?php
																				}
																		?>
																		<?php echo $row["region"]; ?> <a class="underline_none" href=""><?php echo $type_wm = $row["category"]; ?>&nbsp;<?php echo $row["category_add"]; ?></a> 

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
																			?>
																		<sub>
																			<?php
																					echo date('H:i', $time);
																				}
																			?>
																		</sub>
																		</span>

																</div>
														</div>
												<?php
														endwhile;
													endif;
												?>
												<!-- <script>
													$(function() {
														var valPric = $('.price_ind').html();
														if (valPric == "" || $('.price_ind').is(':empty') || valPric == "0" ) { $('.price_ind').hide(); }
													});
												</script> -->

												<!-- <div class="line_ind_yellow">

														<a href="https://voronezh.kupiprodai.ru/podat_obyavlenie_voronezh#everyday"><img class="arrow_up" src="images/arrow_up.png" width="42" height="43" alt="" title="Ежедневное автоподнятие объявлений" /></a>

														<div class="line_photo_ind">
																<img alt="" src="images/nophoto.gif" width="140" height="100" /> </div>
														<div class="line_text_ind" title="Административный помощник">
																<a class="line_title_ind" href="https://voronezh.kupiprodai.ru/rabota/voronezh_vakansii_administrativnyy_pomoschnik_3204322">Административный помощник</a>
																<span class="params_ind">- ведение переговоров
																	- приём звонков
																	- заполнение документов
																	- заключение договоров
																	Требования: исполнительность...</span>
																<span class="price_ind">26 500 руб.</span> Воронеж. <a class="underline_none" href="https://voronezh.kupiprodai.ru/rabota/voronezh_vakansii/">Предлагаю работу</a> <span class="time">Сегодня в 20:58</span>
														</div>
												</div> -->
												<!-- <div class="line_ind_yellow">

														<a href="https://voronezh.kupiprodai.ru/podat_obyavlenie_voronezh#everyday"><img class="arrow_up" src="images/arrow_up.png" width="42" height="43" alt="" title="Ежедневное автоподнятие объявлений" /></a>

														<div class="line_photo_ind">
																<a href="https://voronezh.kupiprodai.ru/rabota/voronezh_vakansii_marketolog_3055381"><img alt="" src="images/builds/1548932705190.jpg" title="Маркетолог" /></a>
														</div>
														<div class="line_text_ind" title="Маркетолог">
																<a class="line_title_ind" href="https://voronezh.kupiprodai.ru/rabota/voronezh_vakansii_marketolog_3055381">Маркетолог</a>
																<span class="params_ind">Обязанности: создание рекламных материалов, взаимодействие со СМИ, составление текстов, подготовка предложений, работа в...</span>
																<span class="price_ind">27 000 руб.</span> Воронеж. <a class="underline_none" href="https://voronezh.kupiprodai.ru/rabota/voronezh_vakansii/">Предлагаю работу</a> <span class="time">Сегодня в 20:58</span>
														</div>
												</div> -->
												
												<!-- <div class="line_ind_white">

														<div class="line_photo_ind">
																<a href="https://voronezh.kupiprodai.ru/office/voronezh_bittexno_remkomplekt_podshipnikov_stiralnyh_mashin_2692955"><img alt="" src="images/builds/1538371040625.jpg" title="Ремкомплект подшипников стиральных машин" /></a>
														</div>
														<div class="line_text_ind" title="Ремкомплект подшипников стиральных машин">
																<a class="line_title_ind" href="https://voronezh.kupiprodai.ru/office/voronezh_bittexno_remkomplekt_podshipnikov_stiralnyh_mashin_2692955">Ремкомплект подшипников стиральных машин</a>
																<span class="params_ind">Новые. В наличии. Сальник входит в комплект.
																	Вышлем в регионы при 100% предоплате.</span>
																<span class="price_ind">1 000 руб.</span> Воронеж. <a class="underline_none" href="https://voronezh.kupiprodai.ru/office/voronezh_bittexno/">Техника для дома</a> <span class="time">Сегодня в 19:32</span>
														</div>
												</div> -->

										</div>
										<!-- <div class="show_more">
												<a id="show_more" data-curr_pos="12" href="">Показать еще</a>
												<a class="register" href="add.php">Подать объявление</a>
										</div> -->


										<div class="content_pages">
											<?php
												$sql = 'SELECT COUNT(`id`) AS `total_count` FROM `doska` '. $where;
												$sql_result = mysqli_query($link, $sql);
												$sql_row = mysqli_fetch_array($sql_result);

											  /* Входные параметры */
											  $count_pages = ceil($sql_row['total_count'] / $PAGES_NUM);
											  $active = ( empty($_GET["page"]) ? 1 : $_GET["page"] );
											  


											  $count_show_pages = 5;
												
											  $url = 'index.php?category='.$_GET["category"].'&search='.$_GET["search"].'&region='.$_GET["region"].'&category_type='.$_GET["category_type"].'';

											  $url_page = 'index.php?category='.$_GET["category"].'&search='.$_GET["search"].'&region='.$_GET["region"].'&category_type='.$_GET["category_type"].'&page=';
											  if ($count_pages > 1) { // Всё это только если количество страниц больше 1
											    /* Дальше идёт вычисление первой выводимой страницы и последней (чтобы текущая страница была где-то посредине, если это возможно, и чтобы общая сумма выводимых страниц была равна count_show_pages, либо меньше, если количество страниц недостаточно) */
											    $left = $active - 1;
											    $right = $count_pages - $active;
											    if ($left < floor($count_show_pages / 2)) $start = 1;
											    else $start = $active - floor($count_show_pages / 2);
											    $end = $start + $count_show_pages - 1;
											    if ($end > $count_pages) {
											      $start -= ($end - $count_pages);
											      $end = $count_pages;
											      if ($start < 1) $start = 1;
											    }
												
											?>
											  <!-- Дальше идёт вывод Pagination -->
											  <div id="hod_top">
											  	<span id="hod_pages">Страницы</span>
											  </div>
											  <div id="hod_bottom">
											  	<?php if ($active != 1) { ?>
											  		<a class="normal" href="<?=$url?>" title="Первая">Первая</a>
											  		<a class="normal" href="<?php if ($active == 2) { ?><?=$url?><?php } else { ?><?=$url_page.($active - 1)?><?php } ?>" title="Предыдущая">Предыдущая</a>
											  	<?php } ?>

											    <?php for ($i = $start; $i <= $end; $i++) { ?>
											      <?php if ($i == $active) { ?><span class="hod_act"><?=$i?></span><?php } else { ?><a class="normal" href="<?php if ($i == 1) { ?><?=$url?><?php } else { ?><?=$url_page.$i?><?php } ?>"><?=$i?></a><?php } ?>
											    <?php } ?>

											    <?php if ($active != $count_pages) { ?>
											    	<a class="normal" href="<?=$url_page.($active + 1)?>" title="Следующая">Следующая</a>
											    	<a class="normal" href="<?=$url_page.$count_pages?>" title="Последняя">Последняя</a>
											    <?php } ?>
											  </div>
											<?php } ?>
										</div>
								</div>
								<div id="ind_right">
										<div id="rounded_top2"><span class="title">Объявления по категориям</span></div>
										<div id="cat2">
												<div id="cat_padd2">
														<?php // $count_wm = mysqli_query($link, "SELECT count(*) FROM `doska` WHERE `category` = 'webmoney'"); ?>
														<?php 
															// $count_limit = mysqli_fetch_assoc($count_wm);
															function countItems($category){
																global $link;
																$query = mysqli_query($link, 'SELECT count(*) FROM `doska` WHERE `category` = "'.$category.'"');
																$fetch = mysqli_fetch_assoc($query);
																return $fetch["count(*)"];
															}
														?>
														<div class="cat_block2" id="cat_block_1">
																<span><a href="index.php?category=nedwij">Недвижимость</a> (<?=countItems('webmoney') ?>)</span>
														</div>
														<div class="cat_block2" id="cat_block_9">
																<span><a href="index.php?category=biznec">Бизнес и промышленность</a> (<?=countItems('yamoney') ?>)</span>
														</div>
														<div class="cat_block2" id="cat_block_16">
																<span><a href="index.php?category=cars">Транспорт</a> (<?=countItems('qiwi') ?>)</span>
														</div>
														<div class="cat_block2" id="cat_block_19">
																<span><a href="index.php?category=bariga">Купля, продажа</a> (<?=countItems('uzcard') ?>)</span>
														</div>
														<div class="cat_block2" id="cat_block_27">
																<span><a href="index.php?category=servis">Услуги</a> (<?=countItems('crypto') ?>)</span>
														</div>
												</div>
										</div>
								</div>

						</div>
						<div id="illustrations">
								<a class="right_margin" href="index.php?category=webmoney"><img src="images/ill_WebMoney.png" width="165" height="95" alt="" title="" /> WebMoney
								</a>

								<a class="right_margin" href="index.php?category=yamoney"><img src="images/ill_yaDengi.png" width="165" height="95" alt="" title="" /> Яндекс деньги
								</a>
 
								<a class="right_margin" href="index.php?category=qiwi"><img src="images/ill_QIWI.png" width="165" height="95" alt="" title="" /> QIWI
								</a>

								<a class="right_margin" href="index.php?category=uzcard"><img src="images/ill_UzCard.png" width="165" height="95" alt="" title="" /> UzCard</a>

								<a class="right_margin" href="index.php?category=crypto"><img src="images/ill_cripto.png" width="165" height="95" alt="" title="" /> Криптовалюта</a>

								<a href="index.php?category=other"><img src="images/ill_other.png" width="165" height="95" alt="" title="" /> Другие
								</a>
							 
						</div>

						<!-- <div class="rounded">
								<div id="rounded_top"><span class="title">Объявления в городах</span></div>
								<div id="geo">
										<div id="geo_padd_ind">
												<a href="https://voronezh.kupiprodai.ru/">Воронежская область</a>
												<br />
												<a id="your_city_ind" title="Доска бесплатных объявлений Воронеж" href="https://voronezh.kupiprodai.ru/voronezh_all/">Воронеж</a>

												<img id="city_icon" src="images/city_icon.gif" width="12" height="21" alt="" title="" />
												<div id="cities_ind"> <a title="Доска бесплатных объявлений Бобров" href="https://voronezh.kupiprodai.ru/bobrov_all/">Бобров</a>,
														<a title="Доска бесплатных объявлений Борисоглебск" href="https://voronezh.kupiprodai.ru/borisoglebsk_all/">Борисоглебск</a>,
														<a title="Доска бесплатных объявлений Калач" href="https://voronezh.kupiprodai.ru/kalach_all/">Калач</a>,
														<a title="Доска бесплатных объявлений Лиски" href="https://voronezh.kupiprodai.ru/liski_all/">Лиски</a>,
														<a title="Доска бесплатных объявлений Новая Усмань" href="https://voronezh.kupiprodai.ru/novayausman_all/">Новая Усмань</a>,
														<a title="Доска бесплатных объявлений Нововоронеж" href="https://voronezh.kupiprodai.ru/novovoronezh_all/">Нововоронеж</a>,
														<a title="Доска бесплатных объявлений Острогожск" href="https://voronezh.kupiprodai.ru/ostrogozhsk_all/">Острогожск</a>,
														<a title="Доска бесплатных объявлений Павловск" href="https://voronezh.kupiprodai.ru/pavlovskvoronezh_all/">Павловск</a>,
														<a title="Доска бесплатных объявлений Россошь" href="https://voronezh.kupiprodai.ru/rossosh_all/">Россошь</a>,
														<a title="Доска бесплатных объявлений Семилуки" href="https://voronezh.kupiprodai.ru/semiluki_all/">Семилуки</a>,
												</div>
												<a class="all" href="https://kupiprodai.ru/russia/">Все города</a>
										</div>
								</div>
						</div> -->

						<div id="info">
								<span>Доска для бесплатных объявлений электронных средств в Узбекистане. Приобрести или вывести электронные деньги легко и быстро. Здесь можно разместить объявление WebMony бесплатно и без регистрации в системе. Купить или продать WMZ в Ташкенте легко!</span>
								<p>Возможность отсортировать по характеристикам позволит выбрать самые удачные предложения в Ташкенте и в других регионах. Опубликовывайте и продавайте WMZ быстро! Подать объявление о покупке - и продавцы найдут Вас сами.</p>
						</div>
				</div>
				<div id="push"></div>
		</div>

		<?php include "footer.php"; ?>

		<!--noindex-->

		<!--/noindex-->
</body>

</html>