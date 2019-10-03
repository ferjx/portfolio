// $( function() {
// 	// _bxslider_ #8
// 	$('.bxslider8').bxSlider({
// 	  pagerCustom: '#bx-pager8'
// 	});
// } );


// nav - scrollBarr 
(function($){
  $(window).on("load",function(){
    $(".banner-nav-ineer_scroll").mCustomScrollbar({
      theme:"my-theme",
      scrollButtons:{
        enable:true
      }
    });
  });
})(jQuery);


// nav - calendar
$( function() {
  var disabledDays = [0, 6];
  $('.datepicker').datepicker({
      onRenderCell: function (date, cellType) {
          if (cellType == 'day') {
              var day = date.getDay(),
                  isDisabled = disabledDays.indexOf(day) != -1;

              return {
                  disabled: isDisabled
              }
          }
      }
  })
} );

$(function() {
	$('#countries-link').on('click', function(e){
	  e.preventDefault();
	  $('#countries-radio').toggle();
	})
});

// owl-carousel head
$(function() {
  $('.Basic_demos_6').owlCarousel({
      animateOut: 'slideOutDown',
      animateIn: 'bounce',
      mouseDrag: false,
      
      items:1,
      loop:false,
      dots: false,
      center:true,
      margin:10,
      URLhashListener:true,
      autoplayHoverPause:true,
      startPosition: 'URLHash'
  });
});

// owl-carousel operator
$('.Using_built-in_plugins_12').owlCarousel({
    items:1,
    loop:false,
    center:true,
    margin:10,
    responsiveClass:true
})

// owl-carousel
$(function() {

});