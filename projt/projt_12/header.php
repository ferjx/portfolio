<?php 
	$selectCity = $_GET["region"];
	$cities = [
		"Россия" => "России",
		"Москва" => "Москвe",
		"Санкт-Петербург" => "Санкт-Петербургe",
		"Нижний Новгород" => "Нижнийм Новгородe",
		"Краснодар" => "Краснодарскe",
		"Новосибирск" => "Новосибирскe",
		"Екатеринбург" => "Екатеринбургe",
		"Челябинск" => "Челябинскe",
		"Красноярск" => "Красноярскe",
		"Тюмень" => "Тюменьe",
		"Ростов-на-Дону" => "Ростове-на-Дону",
		"Уфа" => "Уфe",
		"Саратов" => "Саратовe",
		"Казань" => "Казанe",
		"Самара" => "Самарe",
		"Сочи" => "Сочи",
		"Омск" => "Омскe",
		"Барнаул" => "Барнаулe",
		"Пермь" => "Перми",
		"Ижевск" => "Ижевскe",
		"Кемерово" => "Кемеровe",
		"Волгоград" => "Волгоградe",
		"Владивосток" => "Владивостокe",
		"Ставрополь" => "Ставрополe",
		"Воронеж" => "Воронежe",
	];
	if( empty($selectCity) ) $selectCity = "Россия";



	
	// echo "<pre>";
	// var_dump($selectCity);
	// echo "</pre>";
?>
<div id="line">
	<a class="left_link" href="index.php">Доска объявлений в <?= $cities[$selectCity]; ?></a>
	<!-- <a id="user_link" class="right_link" href="https://kupiprodai.ru/login/">Войти </a> --> 
	<a id="add_link" class="right_link" href="add.php">Подать объявление</a>
	<!-- <a id="favor_link" class="right_link" href="/favorite.php"><span class="favorites_all"></span> Избранное</a> -->
</div>

<div id="top">
	<a href="index.php"><img id="logo" src="images/logo.gif" width="214" height="42" alt="" title="" /></a>
	<div id="region_current">
		<br />
		<a id="region_area" href="index.php">в <?= $cities[$selectCity]; ?></a>
	</div>
	<a id="add" href="add.php">Подать объявление</a>
</div>

<div>
	<form method="GET" action="index.php">
		<div id="head">
			<div id="main_search">
				<div class="blue">
				  <?php
				  $category
				  ?>
					<select class="cat_form" name="category" id="cat_id">
						<option value="">Выбрать</option>
						<option value="building" <?php if( $_GET["category"] == "building" ) echo " selected"; ?> >Недвижимость</option>
						<option value="business" <?php if( $_GET["category"] == "business" ) echo " selected"; ?> >Бизнес и промышленность</option>
						<option value="cars" <?php if( $_GET["category"] == "cars" ) echo " selected"; ?> >Транспорт</option>
						<option value="huckster" <?php if( $_GET["category"] == "huckster" ) echo " selected"; ?> >Купля, продажа</option>
						<option value="services" <?php if( $_GET["category"] == "services" ) echo " selected"; ?> >Услуги</option>
						<option value="job" <?php if( $_GET["category"] == "job" ) echo " selected"; ?> >Работа</option>
						<option value="education" <?php if( $_GET["category"] == "education" ) echo " selected"; ?> >Образование</option>
						<option value="society" <?php if( $_GET["category"] == "society" ) echo " selected"; ?> >Общество</option>
					</select>
					<?php
					?>
				</div>

				<!-- category -->
				<script>
				  $(function() {
					  $('#cat_id').change(function(){
						var val = $( this ).val();
						if( val == 'webmoney' )
						{
						  $('#category_add').html(
							'<select class="select_long" name="category_add"><option value="">Выбрать</option><option <?php if( $_GET["category_add"] == "WMZ" ) echo " selected"; ?>>WMZ</option><option <?php if( $_GET["category_add"] == "WMR" ) echo " selected"; ?>>WMR</option><option <?php if( $_GET["category_add"] == "WME" ) echo " selected"; ?>>WME</option></select>'
						  );
						} else if( val == 'crypto' )
						{

						  $('#category_add').html(
							'<select class="select_long" name="category_add"><option value="">Выбрать</option><option <?php if( $_GET["category_add"] == "Bitcoin" ) echo " selected"; ?> >Bitcoin</option><option <?php if( $_GET["category_add"] == "Ethereum" ) echo " selected"; ?> >Ethereum</option><option <?php if( $_GET["category_add"] == "Litcoin" ) echo " selected"; ?> >Litcoin</option><option <?php if( $_GET["category_add"] == "Monero" ) echo " selected"; ?> >Monero</option><option <?php if( $_GET["category_add"] == "Dash" ) echo " selected"; ?> >Dash</option></select>'
						  );
						} else
						{
						  $('#category_add').html('');
						}

					  });
					  $('#cat_id').triggerHandler('change');
				  });


				</script>

				<div class="grey">
					<input class="search_form" type="text" size="25" name='search' value="<?= $_GET['search'] ?>" placeholder="" />
				</div>
				<!-- search -->
				<div class="grey">
					<?php
					  $region = mysqli_query($link, "SELECT DISTINCT `region` FROM `doska` WHERE 1 AND `ok` = 1");
					?>
					<select class="cat_form" name="region" id="citysel">
						<option class="region_title" value="">Вся Россия</option>
						<?php
						  while ( $cat = mysqli_fetch_assoc($region) ) {
							?>
							  <option value="<?= $cat["region"]; ?>" <?php if( $_GET["region"] == $cat["region"] ) echo " selected"; ?> ><?php echo $cat["region"] ?></option>
							<?php
						  };
						?>
					</select>
				</div>
				<!-- region -->
				<div id="button">
					<input class="search_button" type="submit" value="Найти" />
				</div>
				<!-- submit -->
			</div>


			<div class="metro" style="display:none" id="metrodiv">
				<select id="metro_id" name="metro_id">
				</select>
			</div>

			<fieldset class="dop_search">
				<select class="select_long" name="category_type">
				  <option value="">Выбрать</option>
				  <option <?php if( $_GET["category_type"] == "Купить" ) echo " selected"; ?> >Купить</option>
				  <option <?php if( $_GET["category_type"] == "Продать" ) echo " selected"; ?>>Продать</option>
				</select>
				<!-- category_type -->
				
				<div id="category_add">
				</div>
				<!-- category_add -->
			</fieldset>
			<div class="search_save">
			</div>
		</div>

		<div id="help">
			<div id="first">
				<span class="question">Что Вы ищете?</span>
				<span class="example">Например: Транспорт</span>
			</div>
			<div id="second">
				<span class="question">Уточнить</span>
				<span class="example">Например: Продам</span>
			</div>
			<div id="third">
				<span class="question">Регион поиска</span>
				<span class="example">Например: Москва</span>
			</div>
		</div>
	</form>
</div>