// LazyLoad
$(function(){
	var lazyLoadInstance = new LazyLoad({
		elements_selector: ".lazy"
		// ... more custom settings?
	});
});




// reset nav anhor menu
history.replaceState(null, null, ' ');
var navbarDefaultHeight = $('.navbar-default').height();
function scrollToAnchor(aid){
		$('html,body').animate({scrollTop: $(aid).offset().top-navbarDefaultHeight},'slow');
}
$(".link-yak").click(function() {
	$('.link-yak').parent().removeClass('active');
	$(this).parent().addClass('active');
	scrollToAnchor($(this).attr('href'));
});




// scroll-bar
;(function($){
	$(window).on("load",function(){
		$(".textImg").mCustomScrollbar({
			theme:"my-theme",
			// theme:"dark",
			// axis:"y",
			// setHeight: false,
			// setTop: 0,
			scrollbarPosition: "outside",
			// autoHideScrollbar: false,
			scrollButtons:{
				enable: true
			}
		});
	});
})(jQuery);


// top-menu
$(function(){
	$(".navbar-toggle").on("click", function(){
		$(".collapse").toggle();
	})
});



// owl
$(function(){
	// Using_external_libraries_#15
	var owl = $('.Using_external_libraries_15');
	owl.owlCarousel({
			loop: false,
			nav: true,
			margin: 10,
			responsiveClass: true,
			// mouseDrag: true,
			// touchDrag: true,
			// interval : false,
			responsive:{
					0: {
							items: 1,
							nav:true
					},
					768: {
							items: 2,
							nav:false
					}, 
					1200: {
							items: 3,
							nav:false
					}
			}
	});
	owl.on('mousewheel', '.owl-stage', function (e) {
			if (e.deltaY>0) {
					owl.trigger('next.owl');
			} else {
					owl.trigger('prev.owl');
			}
			e.preventDefault();
	});
});


// a target
function externalLinks() {
 links = document.getElementsByTagName("a");
 for (i=0; i<links.length; i++) {
	 link = links[i];
	 if (link.getAttribute("href") && link.getAttribute("rel") == "external")
	 link.target = "_blank";
 }
}
window.onload = externalLinks;



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


$(function(){
	// doska
	$('.doska a.textImg').on('click', function(e){
		e.preventDefault();
		e.stopPropagation();
		e.stopImmediatePropagation();

		alert("Ссылка по запросу");

	});

	// jivo_api
	$('.jivo_link').on('click', function(e){
		e.preventDefault();
	});

	
});