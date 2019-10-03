
// id для livitatiya
$(function(){

	// вычисляем высоту "sidebar-form"
	var totalHeight = 0;
	$("#sidebar-form").children().each(function(){
			totalHeight = totalHeight + $(this).outerHeight(true);
	});
	// задаем эл. эту высоту
	$("#sidebar-form").css("height",totalHeight);
	$("#sidebar-form").parent().css("min-height",totalHeight);

	// livitatiya для
	$("#sidebar-form").stick_in_parent({ offset_top: 82, offset_bottom: 82});

})



// popup
$(function(){
	$('.modal-link').magnificPopup({
		type: 'inline',

		fixedContentPos: true,
		fixedBgPos: true,

		overflowY: 'auto',

		closeBtnInside: true,

		preloader: true,
		callbacks: {
		  open: function() {
		    $('html').css('margin-right', '0');
		  }
		},
		midClick: true,
		removalDelay: 300,
		mainClass: 'my-mfp-zoom-in'
	});
});


// scrollTop - выч. область прокрутки
$(function(){
		if( $('#header').length && $('#header').css('display') != "none" ) {
				// console.log(1);
				$('#header').removeClass("scrolled");
				$(window).scroll(function() {
						// console.log(3);
						if ($(this).scrollTop() > 20) {
								$('#header').addClass("scrolled").fadeIn('fast');
						} else {
								$('#header').removeClass("scrolled").fadeIn('fast');
						};
				});
		}else {
			// console.log(2);
		}
});



// top btn nav active
$(function(){
		var nav__btn = $('.nav__btn').click(function(event) {
				$(this).toggleClass('menu-btn_active');
				$('.header__flex').toggleClass('active');
		})
		$(window).scroll().trigger('scroll');
});



// обрезать строку index.html
$(function(){
	// s7-block
	$(".s7-ourServices__text>p:first-of-type").text(function(i, text) {
			if (text.length >= 50) {
				text = text.substring(0, 185);
				var lastIndex = text.lastIndexOf(" ");       // позиция последнего пробела
				text = text.substring(0, lastIndex) + '...'; // обрезаем до последнего слова
			}
			$(this).text(text);
	});
	$('.s7-ourServices__text > p').not('.s7-ourServices__text p:first-of-type').remove();


	// s10-block
	$(".s10-ourBlog .s10-ourServices__text>p:first-of-type").text(function(i, text) {
			if (text.length >= 50) {
				text = text.substring(0, 285);
				var lastIndex = text.lastIndexOf(" ");       // позиция последнего пробела
				text = text.substring(0, lastIndex) + '...'; // обрезаем до последнего слова
			}
			$(this).text(text);
	});
	$('.s10-ourBlog .s10-ourServices__text > p').not('.s10-ourBlog .s10-ourServices__text p:first-of-type').remove();


	// s10-block
	// readmore
	// $('.s10-block .s10-ourServices__text').readmore({
	// 	maxHeight: 75,
	// 	// heightMargin: 14,
	// 	moreLink: '<div class="s7-ourServices__link"><a href="#" title="узнать подробнее">читать</a></div>',
	// 	lessLink: '<div class="s7-ourServices__link"><a href="#" title="узнать подробнее">cкрыть</a></div>'
	// });


	// s10-block
	// masonry
	// $('.readmore-js-toggle').on('click', function(){
	// 	$('.s10-ourBlog').masonry({
	// 	  itemSelector: '.s7-ourServices_items',
	// 	  columnWidth: 12,
	// 	  isResizable: false
	// 	});
	// })
	
});

// s7-block
$(function(){
	$('.s7-btn a').click(function(event) {
			event.preventDefault();
			$(this).find('span').toggleClass('hidden');
			$('.s7-ourServices_items-hidden').slideToggle();
	});
});


$(function(){
	// кусочек пазла, дом стоит на месте
	$('body').click(function() {
		$('body').css({
			"position": "static",
			"width": "auto",
			"left": "0px",
			"transition": "0.2s",
			"overflow": "visible"
		});
	});

});
