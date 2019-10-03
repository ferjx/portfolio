
// slider gorisontal 2
$(function() {
	$('.sl3').slick({
		// autoplay: true,
		// autoplaySpeed: 2000,
		dots: false,
		arrows: true,

		slidesToShow: 1,
		slidesToScroll: 1,
		// draggable: false,
		cssEase: "ease-in",

		// infinite: false,

		// focusOnChange: true,
		focusOnSelect: true,
		// pauseOnFocus: true,

		pauseOnDotsHover: false,
		centerMode: true,
		centerPadding: '0px',

		swipe: true,
		swipeToSlide: true,
		touchMove: true,
	});

});
