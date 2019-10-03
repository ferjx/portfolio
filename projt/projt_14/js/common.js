$(function() {

	// top-menu-btn
	$('.menu-btn').on('click', function() {
		$(this).toggleClass('menu-btn_active');
		$('.header').toggleClass('menu-nav_active');
		$('.hide-menu').toggle();
	});
	$('.hide-menu').on('click', function() {
		$('.menu-btn').toggleClass('menu-btn_active');
		$('.header').toggleClass('menu-nav_active');
		$(this).toggle();
	});


	// Initiate Pretty Dropdowns
	$('#spell').prettyDropdown({
		afterLoad: function() {
			console.log('Spells are ready!');
		}
	});


	// tabs
	$( "#tabs-form" ).tabs();


	// accordion
	$( "#accordion" ).accordion({
		collapsible: true,
		// clearStyle: true,
		active: false,
		beforeActivate: function(event, ui) {
		 // The accordion believes a panel is being opened
		 if (ui.newHeader[0]) {
			var currHeader  = ui.newHeader;
			var currContent = currHeader.next('.ui-accordion-content');
		 // The accordion believes a panel is being closed
		} else {
			var currHeader  = ui.oldHeader;
			var currContent = currHeader.next('.ui-accordion-content');
		}
		 // Since we've changed the default behavior, this detects the actual status
		 var isPanelSelected = currHeader.attr('aria-selected') == 'true';

		 // Toggle the panel header
		 currHeader.toggleClass('ui-corner-all',isPanelSelected).toggleClass('accordion-header-active ui-state-active ui-corner-top',!isPanelSelected).attr('aria-selected',((!isPanelSelected).toString()));

		// Toggle the panel icon
		currHeader.children('.ui-icon').toggleClass('ui-icon-triangle-1-e',isPanelSelected).toggleClass('ui-icon-triangle-1-s',!isPanelSelected);

		 // Toggle the panel content
		 currContent.toggleClass('accordion-content-active',!isPanelSelected)    
		 if (isPanelSelected) { currContent.slideUp(); }  else { currContent.slideDown(); }

		return false; // Cancels the default action
		}	
	});


	// tooltip
	$( document ).tooltip({
    track: true
  });


	// modal-link
	$('.modal-link').fancybox({
		closeBtn: false,
		padding: 0
	});


	// exit popup
	function setCookie(c_name, value, exdays) {
			var exdate = new Date();
			exdate.setDate(exdate.getDate() + exdays);
			var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
			document.cookie = c_name + "=" + c_value;
	}

	function getCookie(c_name) {
			var i, x, y, ARRcookies = document.cookie.split(";");
			for (i = 0; i < ARRcookies.length; i++) {
					x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
					y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
					x = x.replace(/^\s+|\s+$/g, "");
					if (x == c_name) {
							return unescape(y);
					}
			}
	}

	var exitPopup = window.location.pathname;

	if ( exitPopup.indexOf('index') !== -1 ) {
		if( !getCookie('popup_show') ){
				setCookie('popup_show', 1);

				window.setTimeout(function() {
						$('#exit').remove();
				}, 60000);

				$(document).one('mouseleave', function(e){
						if (e.clientY < 0 && $('#exit').length) {
								$('#exit').fancybox({
									closeBtn: false,
									padding: 0
								}).trigger('click');
						}
				});
		}
	}


});
