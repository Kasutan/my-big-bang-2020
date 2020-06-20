(function($) {

	$( document ).ready(function() {
		var width=$(window).width();

		/****************** Sticky header *************************/	
		var siteHeader=$('.site-header');
		var siteContent=$('.site-main');
		var mainNavigation=$('.main-navigation');
		var headerTop=0;
		var headerBottom=0;
		updateHeaderPosition();


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

		});
		

		//Si on permet au visiteur de masquer la topbar
		//var topbar = $('.topbar');
		//updateHeaderPosition()

		function updateHeaderPosition() {
			headerTop=siteHeader.offset().top;
			headerBottom=headerTop + siteHeader.outerHeight(); // inclut la topbar si elle est présente
			document.documentElement.style.setProperty('--header-bottom', headerBottom); //utile pour positionner le menu mobile
		}


		/****************** Affichage Questionnaire mobile******************/
		var ouvrirQ = $('#ouvrir-questionnaire');
		var fermerQ = $('#fermer-questionnaire');
		var voletQ = $('#questionnaire');
		var overlay = $('.overlay');
		var blocQ= $('.acf-block-questionnaire');
		if(width < 768 && ouvrirQ.length > 0) {
			voletQ.css('left',width);
			ouvrirQ.click(function(e) {
				e.preventDefault();
				overlay.toggleClass('toggled');
				$('.acf-block-questionnaire .titre, .acf-block-questionnaire .ouvrir ').slideUp(500);
				voletQ.show();
				voletQ.animate(
					{ left: 0.1*width },
					500
				);
			});

			fermerQ.click(function(e) {
				$('.acf-block-questionnaire .titre, .acf-block-questionnaire .ouvrir ').slideDown(500);
				voletQ.animate(
					{left: width},
					500,
					function() {
						voletQ.hide();
						blocQ.toggleClass('toggled');
						overlay.toggleClass('toggled');
					}
				);
			})
		}



		/****************** Réponses Questionnaire *************************/
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
			$('.form-group.reponse textarea').val($('.reponse_'+element).html());
			$('#element').html(element);
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

	/****************** Mots qui défilent au scroll *************************/
	
	//Only Use the IntersectionObserver if it is supported
	if ('IntersectionObserver' in window) {
		const config = {
			rootMargin: '50px 20px 75px 30px',
			//threshold: [0, 0.25, 0.75, 1]
		};

			
		observerMots = new IntersectionObserver((entries) => {
			entries.forEach(entry => {
				if (entry.intersectionRatio > 0) {
					var mot=entry.target;
					var motTop=$(entry.target).offset().top;
					var motWidth=mot.scrollWidth;

					$(window).scroll(function () { // scroll event
						var windowTop = $(window).scrollTop(); // returns number
						var windowBottom=window.innerHeight+windowTop;
						var scrollMots=motWidth * (windowBottom - motTop) / (window.innerHeight - 260); //Longueur d'avancement dans la portion de fenêtre où les mots sont visibles + marge pour le sticky header
						mot.style.setProperty('--scroll-mots', scrollMots);
					});
				} 
			}, config);
		});

		const mots=document.querySelectorAll('.mots');
		mots.forEach(elem => {
			observerMots.observe(elem);
		});

	} 

	/****************** Carrousel de logos presse *************************/


	$(".acf-block-presse .owl-carousel").owlCarousel({
		center: true,
		loop:true,
		nav : true,
		dots : false,
		margin : 40,
		autoplay:true,
		autoplayTimeout:2000,
		autoplayHoverPause:true,
		responsive : {
			// breakpoint from 0 up
			0 : {
				items:1,
			},
			// breakpoint from 768px (md) up
			768 : {
				items : 3,
			},
			// breakpoint from 960px  (lg) up
			960 : {
				items : 5,
			},
		},
	});

	/****************** Carrousel de profils *************************/


	$(".acf-block-profils .owl-carousel").owlCarousel({
		center: false,
		loop:true,
		nav : true,
		dots : false,
		autoplay:true,
		autoplayTimeout:5000,
		autoplaySpeed:1500,
		autoplayHoverPause:true,
		items:1,
	});

})( jQuery );


//Fonction de callback saisie en BO dans les réglages du Caldera Form
function mbb_post_form_submit( obj ) {
	if ( "complete" == obj.status ) {
		var element=localStorage.getItem('mbb_element');
		jQuery('.acf-block-questionnaire').addClass(element+ ' resultat');
		lottie.loadAnimation({
			container: document.getElementById('lottie'), // the dom element that will contain the animation
			renderer: 'svg',
			loop: true,
			autoplay: true,
			path: '/wp-content/themes/my-big-bang-2020/animations/'+element+'.json' // the path to the animation json
		});
		jQuery('#lottie').fadeIn();
	}
    
}