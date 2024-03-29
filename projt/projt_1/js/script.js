
$(document).ready(function(){
	$('.slide').slick({
		infinite: true,
		dots: false,
	slidesToShow: 2,
	slidesToScroll: 1,
	responsive: [
		{
			breakpoint: 882,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
				infinite: true,
				
			}
		},
		
		// You can unslick at a given breakpoint now by adding:
		// settings: "unslick"
		// instead of a settings object
	]
	 
	});
});

var loaderBr = function() {
	if( window.pageLoaded ) return;
	window.pageLoaded = true;
	$(".loader_inner").fadeOut();
	$(".loader").delay(400).fadeOut("slow");
};
$(window).load(loaderBr);
setTimeout(loaderBr, 5000);



// accordion: faq
$(function(){
	var $uiAccordion = $('.js-ui-accordion');

	$uiAccordion.accordion({
		collapsible: true,
		heightStyle: 'content',

		activate: function activate(event, ui) {
			var newHeaderId = ui.newHeader.attr('id');

			if (newHeaderId) {
				// history.pushState(null, null, `#${newHeaderId}`);
			}
		},

		create: function create(event, ui) {
			var $this = $(event.target);
			var $activeAccordion = $(window.location.hash);

			if ($this.find($activeAccordion).length) {
				$this.accordion('option', 'active', $this.find($this.accordion('option', 'header')).index($activeAccordion));
			}
		}
	});

	$(window).on('hashchange', function (event) {
		var $activeAccordion = $(window.location.hash);
		var $parentAccordion = $activeAccordion.parents('.js-ui-accordion');

		if ($activeAccordion.length) {
			$parentAccordion.accordion('option', 'active', $parentAccordion.find($uiAccordion.accordion('option', 'header')).index($activeAccordion));
		}
	});

});







// после загрузки веб-страницы
$(function() {

	// при нажатии на кнопку Обновить
	$("#reload-captcha").click(function() {
	// выводим новый код капча
		$('#img-captcha').attr('src','captcha.php?id='+Math.random()+'');
	});

	// при отправке формы contactForm на сервер (id="contactForm")
	$('#contactForm').submit(function(event) {
		// отменяем стандартное действие браузера
		event.preventDefault();
		// заводим переменную, которая будет говорить о том валидна форма или нет
		var formValid = true;
		// перебираем все элементы управления формы (input и textarea) 
		$('#contactForm input,textarea').each(function() {
			// проверяем является ли данный элемент капчей
			// если это так, то не выполняем его проверку
			if ($(this).attr('id') == 'text-captcha') { return true; }
			// находим предков, имеющих класс .form-group (для установления success/error)
			var formGroup = $(this).parents('.form-group');
			// находим glyphicon (иконка успеха или ошибки)
			var glyphicon = formGroup.find('.form-control-feedback');
			// выполняем валидацию данных с помощью HTML5 функции checkValidity
			if (this.checkValidity()) {
				// добавляем к formGroup класс .has-success и удаляем .has-error
				formGroup.addClass('has-success').removeClass('has-error');
				// добавляем к glyphicon класс .glyphicon-ok и удаляем .glyphicon-remove
				glyphicon.addClass('glyphicon-ok').removeClass('glyphicon-remove');
			} else {
				// добавляем к formGroup класс .has-error и удаляем .has-success
			formGroup.addClass('has-error').removeClass('has-success');
			// добавляем к glyphicon класс glyphicon-remove и удаляем glyphicon-ok
			glyphicon.addClass('glyphicon-remove').removeClass('glyphicon-ok');
			// если элемент не прошёл проверку, то отмечаем форму как не валидную 
			formValid = false;  
			}
		});
		// проверяем элемент, содержащий код капчи
		// получаем значение элемента input, который содержит код капчи
		var captcha = $("#text-captcha").val();
		// если количество символов в коде капчи не равно 6,
	// то отмечаем капчу как невалидную и не отправляем форму на сервер
		if (captcha.length!=6) {
		// получаем элемент, содержащий капчу
			inputCaptcha = $("#text-captcha");
		// находим предка, имеющего класс .form-group (для установления success/error)
			formGroupCaptcha = inputCaptcha.parents('.form-group');
		// находим glyphicon (иконка успеха или ошибки)
			glyphiconCaptcha = formGroupCaptcha.find('.form-control-feedback');
		// добавляем к formGroup класс .has-error и удаляем .has-success
			formGroupCaptcha.addClass('has-error').removeClass('has-success');
		// добавляем к glyphicon класс glyphicon-remove и удаляем glyphicon-ok
			glyphiconCaptcha.addClass('glyphicon-remove').removeClass('glyphicon-ok');
		}
		// если форма валидна и длина капчи равно 6 символам, то отправляем форму на сервер (AJAX)
		if (formValid && captcha.length==6) {
		//получаем имя, которое ввёл пользователь	
		var name = $("#name").val();
		//получаем email, который ввёл пользователь
			var email = $("#email").val();
		//получаем сообщение, которое ввёл пользователь
			var message = $("#message").val();
		//получаем капчу, которую ввёл пользователь
			var captcha = $("#text-captcha").val();

			// объект, посредством которого будем кодировать форму перед отправкой её на сервер
			var formData = new FormData();
			// добавить в formData значение 'name'=значение_поля_name
			formData.append('name', name);
			// добавить в formData значение 'email'=значение_поля_email
			formData.append('email', email);
			// добавить в formData значение 'message'=значение_поля_message
			formData.append('message', message);
			// добавить в formData значение 'captcha'=значение_поля_captcha
			formData.append('captcha', captcha);

		//отправляем данные на сервер (AJAX)
			$.ajax({
		//метод передачи запроса - POST
				type: "POST",
		//URL-адрес запроса 
				url: "process.php",
				//передаваемые данные - formData
				data: formData,
				// не устанавливать тип контента, т.к. используется FormData
				contentType: false,
				// не обрабатывать данные formData
				processData: false,
				// отключить кэширование результатов в браузере
				cache: false,
				//при успешном выполнении запроса
				success : function(data){

					// разбираем строку JSON, полученную от сервера
					var $data =  JSON.parse(data);
					// устанавливаем элементу, содержащему текст ошибки, пустую строку
					$('#error').text('');

					// если сервер вернул ответ success (данные получены)
					if ($data.result == "success") {
						//очищаем форму
						$('#contactForm input,textarea').each(function() {
							var formGroup = $(this).parents('.form-group');
							// находим glyphicon (иконка успеха или ошибки)
							var glyphicon = formGroup.find('.form-control-feedback');
							// добавляем к formGroup класс .has-success и удаляем .has-error
							formGroup.removeClass('has-success has-error');
							// добавляем к glyphicon класс .glyphicon-ok и удаляем .glyphicon-remove
							glyphicon.removeClass('glyphicon-remove glyphicon-ok');
						});
						// обновляем форму:
						$('#contactForm input,textarea').val('');
						$('#contactForm input,textarea').css('background-color','#fff')
						// выводим новый код капча
						$('#img-captcha').attr('src','captcha.php?id='+Math.random()+'');
						// отображаем модальное окно об успехе
						$('#successMessageModal').modal('show');
					}
					else if ($data.result == "invalidCaptcha") {
						// если сервер вернул ответ invalidcaptcha, то делаем следующее...
						// получаем элемент, содержащий капчу
						inputCaptcha = $("#text-captcha");
						// находим предка, имеющего класс .form-group (для установления success/error)
						formGroupCaptcha = inputCaptcha.parents('.form-group');
						// находим glyphicon (иконка успеха или ошибки)
						glyphiconCaptcha = formGroupCaptcha.find('.form-control-feedback');
						// добавляем к formGroup класс .has-error и удаляем .has-success
						formGroupCaptcha.addClass('has-error').removeClass('has-success');
						// добавляем к glyphicon класс glyphicon-remove и удаляем glyphicon-ok
						glyphiconCaptcha.addClass('glyphicon-remove').removeClass('glyphicon-ok');
						// выводим новый код капчи
						$('#img-captcha').attr('src', 'captcha.php?id=' + Math.random() + '');
						// устанавливаем полю, с помощью которого осуществляем ввод капчи пустое значение
						$("#text-captcha").val('');
					} else {
						// если сервер вернул ответ error, то делаем следующее...
						$('#error').text('Произошли ошибки при отправке формы на сервер.');
					}
				},
				error: function (request) {
					$('#error').text('Произошла ошибка ' + request.responseText + ' при отправке данных.');
				}        
			});
	}	 
	});
});

// main
// <ol> <li> list-style number vertical
// <ol class="discharge-preview cols" rel="2">
// As soon as the document structure has been loaded:
document.addEventListener( "DOMContentLoaded", function() {
		// For each html elem:
		elems = document.getElementsByTagName("*"); // OL and UL wanted: chose all (*) here and select later.
		for ( var e = 0; e < elems.length; e++ ) {
				// Check if elem is a list (ordered/unordered) and has class name "cols":
				if ( ( elems[e].tagName == "OL" || elems[e].tagName == "UL" ) && elems[e].className.search("cols") > -1 ) {
						// Collect list items and number of columns (from the rel attribute):
						var list = elems[e];
						var listItems = list.getElementsByTagName("LI");
						var Ncols = list.getAttribute("rel")*1; // *1 converts rel from string to int.
						// Determine total number of items, items per column and column width:
						var Ntotal = listItems.length;
						var Npercol = Math.ceil( Ntotal/Ncols );
						var colWidth = Math.floor( 100/Ncols )+"%";
						// For each column:
						for ( var c = 0; c < Ncols; c++ ) {
								// Create column div:
								var colDiv = document.createElement("DIV");
								colDiv.style.cssFloat = "left";
								colDiv.style.width = colWidth;
								// Add list items to column div:
								var i_start = c*Npercol;
								var i_end = Math.min( (c+1)*Npercol, Ntotal );
								for ( var i = i_start; i < i_end; i++ )
										colDiv.appendChild( listItems[0] ); // Using listItems[0] instead of listItems[i], because items are moved to colDiv!
								// Add column div to list:  
								list.appendChild( colDiv );
						}
				}
		}
} );

// main
// <ol> <li> list-style number vertical
// $(function(){

// 	var setState = function() {
// 		if( width > 900) {
// 			$( '#discharge-preview > div' ).css( {
// 				width: "50%"
// 			} );
// 		} else {
// 			$( '#discharge-preview > div' ).css( {
// 				width: "100%"
// 			} );
// 		}
// 	}
// 	var width = $(window).width();
// 	setTimeout(function() {
// 		$( window ).resize(function() {
// 			width = $(window).width();
// 			setState();
// 		})
// 	}, 100);

// });





// js html file
// jQuery(document).ready(function() {
// 	jQuery(".main_gall li a").fancybox();
// });

jQuery(document).ready(function() {
	$(".fancybox").fancybox({
		helpers: {
			overlay: {
				locked: true
			}
		}
	});
});



// prices popup blue
// jQuery(document).ready(function() {
// 	jQuery(".btn-button_order a").fancybox();
// });

$(document).ready(function() {
	$("#orderPopup").fancybox({
		maxWidth	: 646,
		maxHeight	: 600,
		fitToView	: false,
		width		: '70%',
		height		: 'auto',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});
});

$(document).ready(function() {
	$("#orderPopup2").fancybox({
		maxWidth	: 646,
		fitToView	: false,
		width		: '70%',
		height		: 'auto',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});
});
// popupVoicesLiving-hidden
// popupVoicesRobot-hidden




$(document).ready(function(){
	$(".f_mnu").on("click","a", function (event) {
			//отменяем стандартную обработку нажатия по ссылке
			event.preventDefault();

			//забираем идентификатор бока с атрибута href
			var id  = $(this).attr('href'),

			//узнаем высоту от начала страницы до блока на который ссылается якорь
			top = $(id).offset().top;
			
			//анимируем переход на расстояние - top за 1500 мс
			$('body,html').animate({scrollTop: top-60}, 1500);
		});
});



$(document).ready(function(){
	$(".main_mnu").on("click","a", function (event) {
			//отменяем стандартную обработку нажатия по ссылке
			event.preventDefault();

			//забираем идентификатор бока с атрибута href
			var id  = $(this).attr('href'),

			//узнаем высоту от начала страницы до блока на который ссылается якорь
			top = $(id).offset().top;
			
			//анимируем переход на расстояние - top за 1500 мс
			$('body,html').animate({scrollTop: top-60}, 1500);
		});
});



// Cache selectors
var lastId,
topMenu = $("#menu-center"),
topMenuHeight = topMenu.outerHeight()+150,
		// All list items
		menuItems = topMenu.find("a"),
		// Anchors corresponding to menu items
		scrollItems = menuItems.map(function(){
			var item = $($(this).attr("href"));
			if (item.length) { return item; }
		});

// Bind click handler to menu items
// so we can get a fancy scroll animation
menuItems.click(function(e){
	var href = $(this).attr("href"),
	offsetTop = href === "#" ? 0 : $(href).offset().top-topMenuHeight+1;
	$('html, body').stop().animate({ 
		scrollTop: offsetTop
	}, 300);
	e.preventDefault();
});

// Bind to scroll
$(window).scroll(function(){
	// Get container scroll position
	var fromTop = $(this).scrollTop()+topMenuHeight;

	// Get id of current scroll item
	var cur = scrollItems.map(function(){
		if ($(this).offset().top < fromTop)
		return this;
	});
	// Get the id of the current element
	cur = cur[cur.length-1];
	var id = cur && cur.length ? cur[0].id : "";

	if (lastId !== id) {
		lastId = id;
		 // Set/remove active class
		 menuItems
		 	.parent().removeClass("active")
		 	.end().filter("[href='#"+id+"']").parent().addClass("active");
	}                   
});


// scroll-top
$(window).scroll(function() {
	if ($(this).scrollTop() > 1){
		$('.page_head').addClass("sticky");
	}
	else{
		$('.page_head').removeClass("sticky");
	}
});


$(".navbar-toggle").click(function(){
	$(".main_mnu ul").toggleClass("expand");
});



// BEGIN JIVOSITE CODE {literal}
(function(){ var widget_id = 'q9oCSLS68Z';
	var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();
// {/literal} END JIVOSITE CODE









































































