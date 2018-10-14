$(document).ready(function() {


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



$(window).load(function() {

	$(".loader_inner").fadeOut();
	$(".loader").delay(400).fadeOut("slow");

});

});

// accordion: faq
$(function(){
  const $uiAccordion = $('.js-ui-accordion');

  $uiAccordion.accordion({
    collapsible: true,
    heightStyle: 'content',

    activate: (event, ui) => {
      const newHeaderId = ui.newHeader.attr('id');

      if (newHeaderId) {
        history.pushState(null, null, `#${newHeaderId}`);
      }
    },

    create: (event, ui) => {
      const $this = $(event.target);
      const $activeAccordion = $(window.location.hash);

      if ($this.find($activeAccordion).length) {
        $this.accordion('option', 'active', $this.find($this.accordion('option', 'header')).index($activeAccordion));
      }
    }
  });

  $(window).on('hashchange', event => {
    const $activeAccordion = $(window.location.hash);
    const $parentAccordion = $activeAccordion.parents('.js-ui-accordion')

    if ($activeAccordion.length) {
      $parentAccordion.accordion('option', 'active', $parentAccordion.find($uiAccordion.accordion('option', 'header')).index($activeAccordion));
    }
  });

})
