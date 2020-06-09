(function($) {

	$( document ).ready(function() {

		/****************** Sticky header *************************/	
		var siteHeader=$('.site-header');
		var siteContent=$('.site-main');
		var mainNavigation=$('.main-navigation');
		var headerTop=0;
		var headerBottom=0;
		updateHeaderPosition();

		/****************** Mots qui défilent au scroll *************************/
		var mots=$('.mots');
		var motsTop=mots.offset().top;

		$(window).scroll(function () { // scroll event
			var windowTop = $(window).scrollTop(); // returns number
			var windowBottom=window.innerHeight+windowTop;
			if (windowTop > headerTop) {
				siteHeader.addClass('sticky');
				mainNavigation.addClass('sticky');
				siteContent.css('margin-top',siteHeader.outerHeight());
			} else {
				siteHeader.removeClass('sticky');
				mainNavigation.removeClass('sticky');
				siteContent.css('margin-top',0);
			}

			if (windowBottom > motsTop) {
				scrollMots=(windowBottom - motsTop) / (window.innerHeight - 260); //Proportion d'avancement dans la portion de fenêtre où les mots sont visibles
				document.documentElement.style.setProperty('--scroll-mots', scrollMots); 
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
		

		/****************** Sliders mobile *************************/
		var flecheSlider=$('.fleche-slider');
		flecheSlider.click(function (e) { 
			var slider=$(this).parents('.slider-container').find('.slider');
			var active=parseInt(slider.attr('data-active'));
			var derniere=parseInt(slider.attr('data-nombre'));
			var direction=parseInt($(this).attr("data-direction"));
			var newSlide=active+direction;
			if(newSlide >= 0 && newSlide < derniere) {
				var newLeft=-1 * newSlide * slider.width();
				slider.css('left',newLeft);
				slider.attr('data-active',newSlide);
			}
			if(newSlide===0) {
				slider.parents('.slider-container').find('.fleche-slider.gauche').hide();
			} else {
				slider.parents('.slider-container').find('.fleche-slider.gauche').show('slow');
			}
			if(newSlide===derniere-1) {
				slider.parents('.slider-container').find('.fleche-slider.droite').hide();
			} else {
				slider.parents('.slider-container').find('.fleche-slider.droite').show('slow');
			}
		});

		
	});

})( jQuery );


//Fonction de callback saisie en BO dans les réglages du Caldera Form
function mbb_post_form_submit( obj ) {
	if ( "complete" == obj.status ) {
		var element=localStorage.getItem('mbb_element');
		jQuery('.acf-block-questionnaire').addClass(element+ ' resultat');
	}
    
}

/*
lottie.loadAnimation({
	container: document.getElementById('lottie'), // the dom element that will contain the animation
	renderer: 'svg',
	loop: true,
	autoplay: true,
	path: '/wp-content/themes/my-big-bang-2020/animations/feu.json' // the path to the animation json
});*/