(function($) {

	$( document ).ready(function() {

		/****************** Sticky header *************************/	
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


		/****************** Questionnaire *************************/
		var element=localStorage.getItem('mbb_element');
		if(element!=undefined) {
			$('.site').addClass(element);
		}

		var scoreInput=$('.form-group.score input');	
		if (scoreInput.length > 0) {
			scoreInput.change(function (e) { 
				var score=scoreInput.val();
				if(score < 5) {
					choixElement('feu');
				} else {
					choixElement('eau');
				}
			});

			//Pour le style : appliquer une classe au label quand l'input radio est checked
			$('input[type="radio"]').change(function(e) {
				var name=$(this).attr('name');
				console.log(name);
				$('label[for^="'+name+'"].radio-inline').removeClass('checked');
				if($(this).is(':checked')) {
					$(this).parent().addClass('checked');
				}
			});
		}

		function choixElement(element) {
			$('.form-group.element input').val(element);
			$('.form-group.reponse textarea').val($('.form-group.reponse_'+element+' textarea').val());
			localStorage.setItem('mbb_element',element);
			//$('.site').removeClass('eau feu terre air');
			//$('.site').addClass(element);
		}

		//Disable scroll to top on pagenav
		$(document).on( 'cf.pagenav', function (event, data) {
			$('html, body').stop();
			} );
		
		
	});

})( jQuery );


function mbb_post_form_submit( obj ) {
	if ( "complete" == obj.status ) {
		var element=localStorage.getItem('mbb_element');
		jQuery('.acf-block-questionnaire').addClass(element);
	}
    
}