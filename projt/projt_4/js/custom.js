

// slider gorisontal - carusel home_page
$(function() {
	$('.sl').slick({
		autoplay: false,
		autoplaySpeed: 2000,
		dots: true,
		arrows: false,
		pauseOnDotsHover: true,
	});
});

// Filter and mony - begunok - category
$( function() {
	$( "#slider-range" ).slider({
		step: 50,
		range: true,
		min: 0,
		max: 5000,
		values: [ 0, 3500 ],
		slide: function( event, ui ) {
			$( "#amount_min" ).val( ui.values[ 0 ] );
			$( "#price_max" ).val( ui.values[ 1 ] );
		}
	});
	$( "#amount_min" ).val( $( "#slider-range" ).slider( "values", 0 ) );
	$( "#price_max" ).val( $( "#slider-range" ).slider( "values", 1 ) );

	var slider = $( "#slider-range" );

	$( "#amount_min" ).on("change", function(){
		var values = slider.slider( "values" );
		var min = slider.slider( "option", "min" );
		if( !this.value || isNaN(this.value) ){
			slider.slider( "values", 0, min );
			this.value = '';
			return;
		}
		if( this.value > values[1] ){
			this.value = values[1];
		}
		if( this.value < min ){
			this.value = min;
		}
		slider.slider( "values", 0, this.value );
	}).val(function(){
		return slider.slider( "values", 0 );
	});

	$( "#price_max" ).on("change", function(){
		var values = slider.slider( "values" );
		var max = slider.slider( "option", "max" );
		if( !this.value || isNaN(this.value) ){
			slider.slider( "values", 1, max );
			this.value = '';
			return;
		}
		if( this.value > max ){
			this.value = max;
		}
		if( this.value < values[0] ){
			this.value = values[0];
		}
		slider.slider( "values", 1, this.value );
	}).val(function(){
		return slider.slider( "values", 1 );
	});

});

// slider vertical - carusel - product-page
$(function() {
	/*$('.ui-image-viewer').slick({
		// asNavFor: '.views-block',
		focusOnSelect: true,
		focusOnSelect: false,
		draggable: false,
		fade: true,
		arrows: false,
		cssEase: 'ease-in',
	});*/
	$('.views-block').slick({
		// asNavFor: '.ui-image-viewer',
		vertical: true,

		// autoplay: false,
		// autoplaySpeed: 300,

		slidesToShow: 3,
		slidesToScroll: 3,
		// draggable: false,
		arrows: true,
		cssEase: "ease-in",

		infinite: false,

		// focusOnChange: true,
		focusOnSelect: false,
		// pauseOnFocus: true,

		pauseOnDotsHover: false,
		// centerMode: true,
		// centerPadding: '0',

		swipe: false,
		swipeToSlide: false,
		touchMove: false,


		/*

		touchMove: false,
		dots: false,
		touchThreshold: false,
		pauseOnFocus: true,
		pauseOnDotsHover: true,
		*/
		/*responsive: [
		{
			breakpoint: 900,
			settings: {
				slidesToShow: 3
			}
		}
		]*/
	});

	
});
// $(function() {

//  var big_class_remove = $(".ui-image-viewer");

//  var slider_big = $(".ui-image-viewer .slick-current");
//  var slider_smail = $(".views-block .slick-current");

//  var big_img = $(".ui-image-viewer .sl__slide img");
//  var smail_img = $(".views-block .sl2__slide img");


	// var big_img_val = big_img.attr("src");

	// big_class_remove.remove();

	// var big_link_img = $("<img src='" + big_img_val + "'>");

	// var add_big = $("<div class='ui-image-viewer'></div>").append(big_link_img);

	// $(".bonus-credit").after(add_big);

//  var small_add_attr = slider_smail_img.attr("bigimg", big_img_link);

// });
$(function() {
		$('.views-block img').on('click', function() {
			var src = $(this).attr('bigimg');
			$('.bigimg').attr('src', src);
		});
});
	

// spiner val - product-page
$( function() {
	$( "#spinner-val" ).spinner({
		spin: function( event, ui ) {
			if ( ui.value > 99 ) {
				$( this ).spinner( "value", 1 );
				return false;
			} else if ( ui.value < 1 ) {
				$( this ).spinner( "value", 99 );
				return false;
			}
		}
	});
});


// Tabs - product-page
$(function() {
	$( "#tabs-index3" ).tabs();
});


// slider gorisontal 1 - main-goods - index
$(function() {
	$('.sl4').slick({
		// autoplay: true,
		// autoplaySpeed: 2000,
		dots: false,
		arrows: true,

		slidesToShow: 4,
		slidesToScroll: 4,
		// draggable: false,
		cssEase: "ease-in",

		// infinite: false,

		// focusOnChange: true,
		focusOnSelect: false,
		// pauseOnFocus: true,

		pauseOnDotsHover: false,
		// centerMode: true,
		// centerPadding: '0px',

		swipe: true,
		swipeToSlide: true,
		touchMove: true,
	});



$(window).on('resize', function(){
	if( $(this).width() < 880 ) {
		$('.sl4').slick('slickSetOption', 'slidesToShow', 1);
		$('.sl4').slick('slickSetOption', 'SlidesToScroll', 1);
	}else
	if( $(this).width() < 900 ) {
		$('.sl4').slick('slickSetOption', 'slidesToShow', 2);
		$('.sl4').slick('slickSetOption', 'SlidesToScroll', 2);
	}else
	if( $(this).width() < 1200 ) {
		$('.sl4').slick('slickSetOption', 'slidesToShow', 3);
		$('.sl4').slick('slickSetOption', 'SlidesToScroll', 3);
	}else
	if( $(this).width() < 1200 ) {
		$('.sl4').slick('slickSetOption', 'slidesToShow', 4);
		$('.sl4').slick('slickSetOption', 'SlidesToScroll', 4);
	}

});

$(window).triggerHandler('resize');

});



// slider gorisontal 1 - Story-main-in - index
$(function() {
	$('.sl5').slick({
		// autoplay: true,
		// autoplaySpeed: 2000,
		dots: false,
		arrows: true,

		slidesToShow: 4,
		slidesToScroll: 1,
		// draggable: false,
		cssEase: "ease-in",

		// infinite: false,

		// focusOnChange: true,
		focusOnSelect: false,
		// pauseOnFocus: true,

		pauseOnDotsHover: false,
		// centerMode: true,
		// centerPadding: '0px',

		swipe: true,
		swipeToSlide: true,
		touchMove: true,
	});

});



// slider gorisontal 2 - nano-main-goods - product-page
$(function() {
	$('.sl3').slick({
		// autoplay: true,
		// autoplaySpeed: 2000,
		dots: false,
		arrows: true,

		slidesToShow: 5,
		slidesToScroll: 5,
		// draggable: false,
		cssEase: "ease-in",

		// infinite: false,

		// focusOnChange: true,
		focusOnSelect: false,
		// pauseOnFocus: true,

		pauseOnDotsHover: false,
		centerMode: false,
		centerPadding: '0px',

		swipe: true,
		swipeToSlide: true,
		touchMove: true,
	});

});


$(function() {
	// popup-block index
	$(".nav-header-right li:first").on("click", function(e) {
	  $(".popup-block, .singup").css("display", "block");
	e.preventDefault();
	});
	$(".popap-log-account .close-but").on("click", function() {
	  $(".popup-block, .singup").css("display", "none");
	});

  $(".nav-header-right li:last").on("click", function(e) {
    $(".popup-block, .registration").css("display", "block");
   e.preventDefault();
  });
  $(".popap-log-account .close-but").on("click", function() {
    $(".popup-block, .registration").css("display", "none");
  });

  $(".phone-bold a, .tell-you a").on("click", function(e) {
    $(".popup-block, .callback").css("display", "block");
    e.preventDefault();
  });
  $(".popap-log-account .close-but").on("click", function() {
    $(".popup-block, .callback").css("display", "none");
  });


	// basket-sapping index
	$(".basket, .lev-in a.level-check").on("click", function(e) {
		$(".basket-sapping").slideToggle(500);
		e.stopPropagation();
		$("html").on("click", function() {
			$(".basket-sapping").hide();
		});
	});



	// Main-promise index
	$(".flying-button a").on("click", function(e) {
		$("html, body").animate({
			scrollTop: 0,
		},1000);
			e.preventDefault();
	});



	// MASKED INPUT PLUGIN index
	jQuery(function() {
	   $(".phone").mask("(99) 999-99-99");
	});



});


/*TIMERS*/

/*function drawArc(angle, color, canvas){
  var context = canvas.getContext('2d');
  context.clearRect(0, 0, canvas.width, canvas.height);
  var lineWidth = 2;
  if( !angle ) return;

  var x = canvas.width / 2;
  var y = canvas.height / 2;
  var radius = (canvas.width-lineWidth) / 2;
  var x1=(Math.PI/180)*270;
  var x2=(Math.PI/180)*(angle-90);
  var counterClockwise = false;

  context.beginPath();
  context.arc(x, y, radius, x1, x2, counterClockwise);
  context.lineWidth = lineWidth;
  context.strokeStyle = color;


  context.stroke();
  context.closePath();
}

function GetRemainedTime(time){
  var realDate = new Date();
  time = parseInt(time);
	var currentTime=realDate.getTime();
	var remainedTime={"date":{}, "active":false};

	var sec=Math.ceil((time - currentTime)/1000);

	if(sec >= 0){
		remainedTime.active=true;
	}else{
		sec=0;
	}

	var d=parseInt(sec / 86400);
	sec-=d * 86400;

	var h=parseInt(sec / 3600);
	sec-=h * 3600;

	var m=parseInt(sec / 60);
	sec-=m * 60;

	var dateEnd=new Date();
	dateEnd.setTime(time);

  var titleNumDay=GetTrueTitleNum(d);
  var titleNumHou=GetTrueTitleNum(h);
  var titleNumMin=GetTrueTitleNum(m);
  var titleNumSec=GetTrueTitleNum(sec);
  var titleVariantsDay = {"1":"День", "2-4":"Дня", "5-10":"Дней"};
  var titleVariantsHou = {"1":"Час", "2-4":"Часа", "5-10":"Часов"};

  remainedTime.date["d_num"] = StrLeftPad(d, 2, 0);
  remainedTime.date["d_title"] = titleVariantsDay[titleNumDay];
  remainedTime.date["h_num"] = StrLeftPad(h, 2, 0);
  remainedTime.date["h_title"] = titleVariantsHou[titleNumHou];
  remainedTime.date["m_num"] = StrLeftPad(m, 2, 0);
  remainedTime.date["m_title"] = "мин";
  remainedTime.date["s_num"] = StrLeftPad(sec, 2, 0);
  remainedTime.date["s_title"] = "сек";

	return remainedTime;
};

function StrLeftPad(value, num, pad){
	value=value.toString();

	if(num > value.length){
		var padArray=new Array((num - value.length) + 1);
		value=padArray.join(pad) + value;
	}

	return value;
};

function GetTrueTitleNum(num){
	var titleNum="1";

	if(num.toString().match(/(11|12|13|14|15|16|17|18|19)$/) || num.toString().match(/[567890]$/)){
		titleNum="5-10";
	}else
	if(num.toString().match(/[234]$/)){
		titleNum="2-4";
	}

	return titleNum;
}

function showTimer(canvas){
  var remainedInfo = GetRemainedTime(canvas.getAttribute("time"));
  var station = canvas.parentNode.querySelector("span");
  var value = "";
  var angle = 0;

  switch(canvas.getAttribute("type")){
    case "days":
      value = '<b>'+ remainedInfo.date.d_num +'</b> ' + remainedInfo.date.d_title;
      angle = 360 / 30 * remainedInfo.date.d_num;
    break;
    case "hours":
      value = '<b>'+ remainedInfo.date.h_num +'</b> ' + remainedInfo.date.h_title;
      angle = 360 / 24 * remainedInfo.date.h_num;
    break;
    case "minutes":
      value = '<b>'+ remainedInfo.date.m_num +'</b> ' + remainedInfo.date.m_title;
      angle = 360 / 60 * remainedInfo.date.m_num;
    break;
    case "seconds":
      value = '<b>'+ remainedInfo.date.s_num +'</b> ' + remainedInfo.date.s_title;
      angle = 360 / 60 * remainedInfo.date.s_num;
    break;
  }
  drawArc(angle, "#c6202b", canvas);

  station.innerHTML = value;
}

function showTimers(){
  var canvasTime = document.querySelectorAll(".time canvas");
  for(var i=0; i<canvasTime.length; i++){
    showTimer(canvasTime[i]);
  }
}

setInterval(showTimers, 1000);
*/
/*END TIMERS*/










