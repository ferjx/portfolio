// scroll-bar
(function($){
	$(window).on("load",function(){
		$(".textImg").mCustomScrollbar({
			theme:"my-theme",
			scrollButtons:{
				enable:true
			}
		});
	});
})(jQuery);





// input auto width domain-bases.html
$(function(){
		$.fn.textWidth = function(text, font) {
				if (!$.fn.textWidth.fakeEl) $.fn.textWidth.fakeEl = $('<span>').hide().appendTo(document.body);
				
				$.fn.textWidth.fakeEl.text(text || this.val() || this.text() || this.attr('placeholder')).css('font', font || this.css('font'));
				
				return $.fn.textWidth.fakeEl.width();
		};
		$('.s10_inputForm').on('input', function() {
				var inputWidth = $(this).textWidth() + 50;
				$(this).css({
						width: inputWidth
				})
		}).trigger('input');
		function inputWidth(elem, minW, maxW) {
				elem = $(this);
		}
		var targetElem = $('.s10_inputForm');
		inputWidth(targetElem);
});




// обрезать строку index.html, blog.html
$(function(){
	// s2-card__text
	$(".s2-card__text>p:nth-child(2)").text(function(i, text) {
			if (text.length >= 50) {
				text = text.substring(0, 40);
				var lastIndex = text.lastIndexOf(" ");       // позиция последнего пробела
				text = text.substring(0, lastIndex) + '...'; // обрезаем до последнего слова
			}
			$(this).text(text);
	});
	$('.s2-card__text > p').not('.s2-card__text p:nth-child(-n+2)').remove();





	// s4-blog__text
	// срезаем длину текста
	$(".s4-block .s4-block__items p:first-of-type").text(function(i, text) {
			if (text.length >= 50) {
				text = text.substring(0, 479);
				var lastIndex = text.lastIndexOf(" ");       // позиция последнего пробела
				text = text.substring(0, lastIndex) + '...'; // обрезаем до последнего слова
			}
			$(this).text(text);
	});
	// удаляем последние блоки
	$('.s4-block .s4-block__items p').not('.s4-block .s4-block__items p:first-of-type, .s4-block .s4-block__items:last-of-type p').remove();



	

	
	function block4S() {
		var lBlockNav = 0,
				positionSidebar = 0,
				rBlockContent = 0,
				positionContent = 0,
				resultContent = 306;

		if ($(window).width() >= 993){

				// L block
				lBlockNav 			= $('.content .sidebar__nav').outerHeight();
				positionSidebar = $(".content .sidebar__nav").position();
				if(positionSidebar) {
					 positionSidebar = parseInt(positionSidebar.top * 2);
				}

				// R block
				rBlockContent 	= $('.s4-block .s4-block__items:first-of-type').outerHeight();
				positionContent = $(".s4-block .s4-block__items:first-of-type").position();
				if(positionContent) {
					 positionContent = parseInt(positionContent.top * 2);
				}

				lBlockNav 			= parseInt(lBlockNav + positionSidebar);
				rBlockContent 	= parseInt((rBlockContent + positionContent) * 9);

				var	lastBlockElemtH2	= $('.s4-block .s4-block__items:first-of-type .s4-blog__title').outerHeight();
				var	lastBlockElemtDat	= $('.s4-block .s4-block__items:first-of-type .time ').outerHeight();
				var	lastBlockElemtLin	= $('.s4-block .s4-block__items:first-of-type .s2-card__link ').outerHeight();
				var elemtsResult 			= lastBlockElemtH2 + lastBlockElemtDat + lastBlockElemtLin;

				// result
				resultContent 				= Math.abs((lBlockNav - rBlockContent) + elemtsResult);
				if(resultContent >= 306) {
					resultContent = 306;
				}
		}

		// устанавливаем высоту контент
		$('.s4-block .s4-block__items:last-of-type .s4-blog__text').css({
			"min-height" : resultContent,
			"max-height" : resultContent,
			"height" : 100 + "%",
			'overflow' : 'hidden'
		});
	};

	if( $(".s4-block").length ){
		$(window).resize(block4S).trigger('resize');
	};


	// s5-news__items
	// readmore
	$('.s5-news .s4-blog__text').readmore({
		maxHeight: 100,
		// heightMargin: 14,
		moreLink: '<a href="#" class="s2-card__link">Подробнее</a>',
		lessLink: '<a href="#" class="s2-card__link">Скрыть</a>'
	});
});



// index.html btn-card open-close
$(function(){
		var sizeHeightCardLi = $(".s2-card li").outerHeight(true);

		if ($(window).width() >= 577) {
			if( $(".s2-card li").length >= 3 ) {
					$('.s2-card').css({
						"height" : sizeHeightCardLi,
						// "marginBottom" : "20px",
						"overflow" : "hidden"
					})
			}
		}else if ($(window).width() <= 576) {
				sizeHeightCardLi *= 2;
				$('.s2-card').css({
					"height" : sizeHeightCardLi,
					// "marginBottom" : "20px",
					"overflow" : "hidden"
					// "background" : "red"
				})
		}

		$(".cardBtn-opp").on("click", function(e) {
				e.preventDefault();

				if( $(".s2-card").css("overflow") == "hidden" ) {
						$('.s2-card').removeAttr("style");
						$(this > "span").addClass("cardBtn-close");
						$(this).html("скрыть новости");
				}else {
						$('.s2-card').css({
							"height" : sizeHeightCardLi,
							// "marginBottom" : "20px",
							"overflow" : "hidden"
						})
						$(this).html("<span>все новости</span>");
				}
		});
});



// hide-show top navigation
$(document).ready(function() {

	var win = $(window).width();
	// hide-show top navigation
	$('.logo-block__icon-bar').click(function() {
		var w = $(window).width();
		$('.top-navigation').css({
			"left": "0px",
			"transition": "0.2s"
		});
		$('body').css({
			"transition": "0.4s",
			"position": "absolute",
			"width": w,
			"left": '280px',
			"overflow": "hidden"
		});
		$('.hide-menu').show();
		$('.top-navigation').append('<div class="btnCloce"><span>&#10006;</span></div>');
		// $('.btnCloce').show();

		$('.btnCloce').click(function() {
			$('.top-navigation').css({
				"left": '-280px',
				"transition": "0.2s"
			});
			$('body').css({
				"position": "static",
				"width": "auto",
				"left": "0px",
				"transition": "0.2s",
				"overflow": "visible"
			});
			$('.hide-menu').hide();
			$('.btnCloce').remove();
		});
	});

	$('.hide-menu').click(function() {
		$('.top-navigation').css({
			"left": '-280px',
			"transition": "0.2s"
		});
		$('body').css({
			"position": "static",
			"width": "auto",
			"left": "0px",
			"transition": "0.2s",
			"overflow": "visible"
		});
		$('.hide-menu').hide();
		$('.btnCloce').remove();
	});
	$('.top-navigation__link').click(function() {
		$('.top-navigation').css({
			"left": "-280px",
			"transition": "0.2s"
		});
		var w = $(window).width();
		$('body').css({
			"position": "static",
			"width": "auto",
			"left": "0px",
			"transition": "0.2s",
			"overflow": "visible"
		});
		$('.hide-menu').hide();
		$('.btnCloce').remove();
	});

	// на всякий пожарный. скрипт от дома
	$('.mobile-button').click(function(e) {
		var w = $(window).width();
		$('header nav').css({
			"left": "0px",
			"transition": "0.5s"
		});
		$('body').css({
			"transition": "0.5s",
			"position": "absolute",
			"width": w,
			"left": '280px',
			"overflow": "hidden"
		});
		e.stopPropagation();
	});

	// кусочек пазла, дом стоит на месте
	$('body').click(function() {
		$('header nav').css({
			"left": '-280px',
			"transition": "0.2s"
		});
		$('body').css({
			"position": "static",
			"width": "auto",
			"left": "0px",
			"transition": "0.2s",
			"overflow": "visible"
		});
	});
});



// ускорить YouTube
'use strict';
function r(f){/in/.test(document.readyState)?setTimeout('r('+f+')',9):f()}
r(function(){
		if (!document.getElementsByClassName) {
				// Поддержка IE8
				var getElementsByClassName = function(node, classname) {
						var a = [];
						var re = new RegExp('(^| )'+classname+'( |$)');
						var els = node.getElementsByTagName("*");
						for(var i=0,j=els.length; i<j; i++)
								if(re.test(els[i].className))a.push(els[i]);
						return a;
				}
				var videos = getElementsByClassName(document.body,"youtube");
		} else {
				var videos = document.getElementsByClassName("youtube");
		}
 
		var nb_videos = videos.length;
		for (var i=0; i<nb_videos; i++) {
				// Находим постер для видео, зная ID нашего видео
				videos[i].style.backgroundImage = 'url(http://i.ytimg.com/vi/' + videos[i].id + '/sddefault.jpg)';
 
				// Размещаем над постером кнопку Play, чтобы создать эффект плеера
				var play = document.createElement("div");
				play.setAttribute("class","play");
				videos[i].appendChild(play);
 
				videos[i].onclick = function() {
						// Создаем iFrame и сразу начинаем проигрывать видео, т.е. атрибут autoplay у видео в значении 1
						var iframe = document.createElement("iframe");
						var iframe_url = "https://www.youtube.com/embed/" + this.id + "?autoplay=1&autohide=1";
						if (this.getAttribute("data-params")) iframe_url+='&'+this.getAttribute("data-params");
						iframe.setAttribute("src",iframe_url);
						iframe.setAttribute("frameborder",'0');
 
						// Высота и ширина iFrame будет как у элемента-родителя
						iframe.style.width  = this.style.width;
						iframe.style.height = this.style.height;
 
						// Заменяем начальное изображение (постер) на iFrame
						this.parentNode.replaceChild(iframe, this);
				}
		}
});// #1 - ускорить YouTube




// accordion: faq vLessons-s16
$(function(){
	var $uiAccordion = $('.js-ui-accordion');

	$uiAccordion.accordion({
		collapsible: true,
		heightStyle: 'content',
		active: false
	});
});


// Textarea
// contacts.html
// Растяжка текстовых полей по вертикали
var minH=100;// Минимальная высота поля
var startH=0;
var startY=0;
var textarea=null;
var oldMouseMove=null;
var oldMouseUp=null;
function textareaResizer(e){
		if (e == null) { e = window.event }
		if (e.preventDefault) {
				e.preventDefault();
		}; 
		resizer = (e.target != null) ? e.target : e.srcElement;
		textarea = document.getElementById(
			resizer.id.substr(0,resizer.id.length-8)
		);
		startY=e.clientY;
		startH=textarea.offsetHeight;
		oldMouseMove=document.onmousemove; 
		oldMouseUp=document.onmouseup;
		document.onmousemove=textareaResizer_moveHandler;
		document.onmouseup=textareaResizer_cleanup;
		return false;
}
function textareaResizer_moveHandler(e){
	if (e == null) { e = window.event } 
	if (e.button<=1){
		 curH=(startH+(e.clientY-startY));
		 if (curH<minH) curH=minH;
		 textarea.style.height=curH+'px';
		 return false;
	}
}
function textareaResizer_cleanup(e) {
	document.onmousemove=oldMouseMove;
	document.onmouseup=oldMouseUp;
};

