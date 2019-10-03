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
		$('.top-navigation').append('<div class="btnCloce">&#10006;</div>');
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



// #1 - ускорить YouTube
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



// form-s11
// $(function(){
//  $(".form-s11__input").on("click", function(){
//    $(this).prev(".form-s11__label").css("color", "red");
//  });
// });



// accordion: faq vLessons-s16
$(function(){
	var $uiAccordion = $('.js-ui-accordion');

	$uiAccordion.accordion({
		collapsible: true,
		heightStyle: 'content',
		active: false


	});
});


// ul li balance-s17
// $(function(){
//     $('.balance-s17__sList-Item').each(function(){
//       if( $(this).text().length > 168 ) $(this).css('line-height', '27px')
//     })
// });


// .news-s19__select
$( function() {
		$( ".speed-one" ).selectmenu();
});



// s20AddFile__fileWrap
// input:file
$( function() {

	'use strict';

	;( function ( document, window, index )
	{
		var inputs = document.querySelectorAll( '.inputfile' );
		Array.prototype.forEach.call( inputs, function( input )
		{
			var label	 = input.nextElementSibling,
				labelVal = label.innerHTML;

			input.addEventListener( 'change', function( e )
			{
				var fileName = '';
				if( this.files && this.files.length > 1 )
					fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
				else
					fileName = e.target.value.split( '\\' ).pop();

				if( fileName )
					label.querySelector( 'span' ).innerHTML = fileName;
				else
					label.innerHTML = labelVal;
			});

			// Firefox bug fix
			input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
			input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
		});
	}( document, window, 0 ));

});



// s20AddFile__addFile
// input:file
// $( function() {

// 	$('.s20AddFile__addFile').on('click', function(e){
// 		e.preventDefault();

// 		var button = $('.s20AddFile__addFile');
// 		var uniqueId = 'copy_' + parseInt(Math.random() * 99999);
// 		var copyBlock = $('.s20AddFile__fileWrap:eq(0)');
// 		var copyLink = $('.return-but:eq(0)');

// 		var cloneBlock = copyBlock
// 				.clone()
// 				.addClass('additional')
// 				.addClass('active')
// 				.attr('id', uniqueId + '_block');
// 		var cloneLink = copyLink
// 				.clone()
// 				.show()
// 				.attr('id', uniqueId + '_link');
// 		$( button ).before( cloneLink );
// 		$( button ).before( cloneBlock );

// 		cloneLink.one('click', function(){
// 			$(this).remove();
// 			$('#' + $(this).attr('id').replace('_link', '_block')).remove();
// 		});
// 	});

// });






// tooltip text 
$( function() {
	$( ".pricesb-box__text-vpliv" ).tooltip();
} );

// tooltip text 
$( function() {
	$( ".pricesb-box__text-vplivError" ).tooltip({
		classes: {
			"ui-tooltip": "ui-tooltipError"
		}
	});
} );




// Textarea
// jquery cod
$( function() {
	// autosize($('textarea'));
});

// textareaResizer.js 
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
}






// news-s23
//Повидение для кнопКИ "Читать полностью" (паказать контент при клике)
$(function(){
	$('.news-s23__toggle').on('click', function(e){
		e.preventDefault();
		var contentId = $(this).prev();

		if( $(this).hasClass('active') ){
			$(this).removeClass('active');
			$(contentId).removeClass('active');
		}else{
			$(this).addClass('active');
			$(contentId).addClass('active');
		}
	});

	// скрывает если меньше по ширине
	$(".news-s23__wrapText").each(function(){
		// if( $(this).height() < 175 )
		if( $(this).height() < 160 )
		{
			$(this).next().hide();
		}
	});
});




// popup s26
$(function(){
	$('.popup-with-zoom-anim').magnificPopup({
		type: 'inline',

		fixedContentPos: true,
		fixedBgPos: true,

		overflowY: 'auto',

		closeBtnInside: true,
		preloader: false,
		
		midClick: true,
		removalDelay: 300,
		mainClass: 'my-mfp-zoom-in'
	});
});



// s28-check__input-email_tel
// MASKED INPUT PLUGIN index
$(function(){
	 $(".s28-check__input-email_tel").mask("+9 (999) 999-99-99");
});




// ctrlPpnl-s8__list
$(function(){
	// $('.ctrlPpnl-s8__list').magnificPopup({
	// 	delegate: 'a',
	// 	type: 'image',
	// 	closeOnContentClick: true,
	// 	closeBtnInside: false,
	// 	fixedContentPos: true,
	// 	mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
	// 	image: {
	// 		verticalFit: true
	// 	},
	// 	zoom: {
	// 		enabled: true,
	// 		duration: 300 // don't foget to change the duration also in CSS
	// 	},
	// 	gallery: {
	// 		enabled: true
	// 	}

	// });

	// ctrlPpnl-s8__list
	$('.ctrlPpnl-s8__list').lightGallery({
		thumbnail:true,
		// animateThumb: false,
		thumbWidth: 80
		
	}); 


});





// http://localhost:3000/index.html
// скрипт от пропорции
// $(document).ready(function() {
// 	var win = $(window).width();
// 	// slider padding
// 	var wid = $(window).width();
// 	var mvid = $('.main').width();
// 	var pad = (wid - mvid) / 2;
// 	$('.ci').css({
// 		'padding-left': pad,
// 		'padding-right': pad
// 	});

// 	function setImgHeight() {
// 		// setHeight('image-popup-s8-margins img');
// 		// setHeight('ctrlPpnl-s8__list-inner');
// 	}
// 	$(window).resize(setImgHeight);
// 	setImgHeight();

// 	function setHeight(cname) {
// 		var w = $('.' + cname).width();
// 		var h = (w / 1.66);
// 		$('.' + cname).css('height', h);
// 	}
// });






// ***
$(function(){
	// document.styleSheets[0].disabled = true;
});