(function($) {

	$( document ).ready(function() {	
		var siteHeader=$('.site-header');
		var siteContent=$('.site-main');
		var mainNavigation=$('.main-navigation');
		var headerTop=0;
		var headerBottom=0;
		updateHeaderPosition();


		$(window).scroll(function () { // scroll event
			var windowTop = $(window).scrollTop(); // returns number
			if (windowTop > headerTop) {
				siteHeader.addClass('sticky');
				mainNavigation.addClass('sticky');
				siteContent.css('margin-top',siteHeader.outerHeight());
			} else {
				siteHeader.removeClass('sticky');
				mainNavigation.removeClass('sticky');
				siteContent.css('margin-top',0);
			}
		});
		

		//Si on permet au visiteur de masquer la topbar
		//var topbar = $('.topbar');
		//updateHeaderPosition()

		function updateHeaderPosition() {
			headerTop=siteHeader.offset().top;
			headerBottom=headerTop + siteHeader.outerHeight(); // inclut la topbar si elle est présente
			document.documentElement.style.setProperty('--header-bottom', headerBottom); //utile pour positionner le menu mobile
		}

		
		
	});

})( jQuery );

