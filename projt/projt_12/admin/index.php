<?php 
	session_start(); 
	
	// проверка авторизации
  if( $_SESSION["login_ok"] != 1 ){
      header("Location: login.php");
      exit;
  }

  $link = mysqli_connect("localhost", "porfeus2", "dm9UDDdy88ds9", "porfeus2_uzbablo");

  // проверка ошибки конекта бд
  if (mysqli_connect_errno()) {
  		echo "Ошибка коннекта бд: %s\n", mysqli_connect_error();
  		exit;
  }

  if( !empty($_GET["id"]) && !empty($_GET["ok"]) ){
      mysqli_query($link, "UPDATE `doska` SET `ok` = 1 WHERE `id` = ".$_GET["id"]);
  };

  if( !empty($_GET["id"]) && !empty($_GET["del"]) ){
      mysqli_query($link, "DELETE FROM `doska` WHERE `id` = ".$_GET["id"]);
  };

  // $cities = [
  //      "Ташкент" => "Ташкенте",
  //      "Андижанская область" => "Андижанской области",
  // ];

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	
</body>
</html>


<!DOCTYPE html>
<html lang="ru">
	
	<head>
		<meta charset="UTF-8">
		<title>Tables</title>
		<!-- Bootstrap -->
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
		<link href="assets/styles.css" rel="stylesheet" media="screen">
		<link href="assets/DT_bootstrap.css" rel="stylesheet" media="screen">
		<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="vendors/flot/excanvas.min.js"></script><![endif]-->
		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<script src="vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
	</head>
	
	<body>
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container-fluid">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
					 <span class="icon-bar"></span>
					 <span class="icon-bar"></span>
					</a>
					<a class="brand" href="#">Админка</a>
					<div class="nav-collapse collapse">
						<ul class="nav pull-right">
							<li class="dropdown">
								<a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> 
									<i class="icon-user"></i> admin <i class="caret"></i>
								</a>
								<ul class="dropdown-menu">
									<li>
										<a tabindex="-1" href="login.php?logout=1">Выйти</a>
									</li>
								</ul>
							</li>
						</ul>
						<ul class="nav">
							<li class="">
								<a href="#">Объявления</a>
							</li>
						</ul>
					</div>
					<!--/.nav-collapse -->
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span3" id="sidebar">
					<ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
						<?php
							// вывести все
							function countItems_lng_all(){
								global $link;
								$query = mysqli_query($link, 'SELECT count(*) FROM `doska`');
								$fetch = mysqli_fetch_assoc($query);
								return $fetch["count(*)"];
							};

							// вывести отдельно
							function countItems_lng($category){
								global $link;
								$query = mysqli_query($link, 'SELECT count(*) FROM `doska` WHERE `ok` = ' . $category);
								$fetch = mysqli_fetch_assoc($query);
								return $fetch["count(*)"];
							};

							// выдергиваем url для жирнасти текста
							$path = pathinfo($_SERVER["REQUEST_URI"]);

						?>
						<li>
							<a href="index.php" <?php if( $path['extension'] == 'php' ) echo ' style="font-weight: bold"'; ?>><span class="badge badge-info pull-right"><?php echo countItems_lng_all() ?></span> Все объявления</a>
						</li>
						<li>
							<a href="index.php?filter=1" <?php if( $_GET['filter'] == '1' ) echo ' style="font-weight: bold"'; ?>><span class="badge badge-success pull-right"><?php echo countItems_lng("1") ?></span> Опубликовано</a>
						</li>
						<li>
							<a href="index.php?filter=0" <?php if( $_GET['filter'] == '0' ) echo ' style="font-weight: bold"'; ?>><span class="badge badge-danger pull-right"><?php echo countItems_lng("0") ?></span> Ожидают модерации</a>
						</li>
					</ul>
				</div>
				<!--/span-->
				<div class="span9" id="content">

					<div class="row-fluid">
						<!-- block -->
						<div class="block">
							<div class="navbar navbar-inner block-header">
								<div class="muted pull-left">Таблицы данных</div>
							</div>
							<div class="block-content collapse in">
								<div class="span12">
									
									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
										<thead>
											<tr>
												<th>Название</th>
												<th>Текст</th>
												<th>id</th>
												<th>Опубликовать</th>
												<th>Удалить</th>
											</tr>
										</thead>
										<tbody>

											<?php
												if ( $_GET["filter"] == '0' ){
													$query = mysqli_query( $link, "SELECT * FROM `doska` WHERE `ok` = 0" );
												}else if ( $_GET["filter"] == '1' ){
													$query = mysqli_query( $link, "SELECT * FROM `doska` WHERE `ok` = 1" );
												}else{
													$query = mysqli_query($link, "SELECT * FROM `doska` WHERE 1");
												}

												while ( $row = mysqli_fetch_assoc($query) ):
											?>
													<tr class="odd gradeX">
														<td><?php echo $row["title"]; ?></td>
														<td><?php echo $row["text"]; ?></td>
														<td><?php echo $row["id"]; ?></td>
														<td>
														<?php
															if ( $row["ok"] != 1 ) {
														?>
															<a href="index.php?id=<?php echo $row["id"]; ?>&ok=1" class="btn btn-success btnClick">опубликовать</a>
														<?php
															} else {
																echo '<div class="text-success" style="text-align: center;">опубликовано</div>';
															}
															 
														?>
														</td>
														<td class="center">
															<a href="index.php?id=<?php echo $row["id"]; ?>&del=1" class="btn btn-danger btnClick" onclick="if(!confirm('Удалить?')) return false">удалить</a>
														</td>
													</tr>
											<?php
												endwhile;
											?>

										</tbody>
									</table>
								</div>
							</div>
						</div>
						<!-- /block -->
					</div>

				</div>
			</div>
			<hr>
			<footer>
				<p>&copy; uzbablo.com</p>
			</footer>
		</div>
		<!--/.fluid-container-->

		<!-- <script src="vendors/jquery-3.3.1.min.js"></script> -->
		<script src="vendors/jquery-1.9.1.js"></script>
		<!-- <script src="vendors/jquery-1.11.4.min.js"></script> -->
		<!-- <script src="vendors/jquery-1.12.1.min.js"></script> -->
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script src="vendors/datatables/js/jquery.dataTables.min.js"></script>


		<script src="assets/scripts.js"></script>
		<script src="assets/DT_bootstrap.js"></script>


		<script type="text/javascript" src="vendors/datatables/js/jquery.dataTables.min.js"></script>
		
		<script>
			$(function() {

				// $('.btn-success.btnClick').on('click', function(){
				// 	var altText = confirm("Удалить?")
				// 	if( altText == true ) {
				// 		$(this).val("index.php?id=123&ok=1");
				// 	} else {
				// 		$(this).val("");
				// 	}
				// });

				// $('.btn-danger.btnClick').on('click', function(){
				// 	var altText = confirm("Удалить?")
				// 	if( altText == true ) {
				// 		$(this).val("index.php?id=123&del=1");
				// 	} else {
				// 		$(this).val("");
				// 	}
				// });

			});
		</script>
	</body>

</html>