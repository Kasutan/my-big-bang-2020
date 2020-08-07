(function($) {

	$( document ).ready(function() {
		var width=$(window).width();
		/****************** Sous menu mobile *************************/	
		if(width<768) {
			var liensParents=$('.menu-item-has-children > a, .page_item_has_children > a');
			liensParents.click(function(e){
				if(!$(this).hasClass('focus-smenu')) {
					e.preventDefault();
					liensParents.removeClass('focus-smenu');
					$(this).addClass('focus-smenu');

				}
			});
			$('.sub-menu a').click(function(){
				$('#site-navigation').removeClass('toggled');
				$('#site-navigation ul.menu').attr('aria-expanded','false');
				$('#site-navigation button.menu-toggle').attr('aria-expanded','false');
			});
		}
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
			voletQ.css('right',-1*width);
			ouvrirQ.click(function(e) {
				e.preventDefault();
				overlay.toggleClass('toggled');
				$('.acf-block-questionnaire .titre, .acf-block-questionnaire .ouvrir ').slideUp(500);
				voletQ.show();
				voletQ.animate(
					{ right: 0 },
					500
				);
			});

			fermerQ.click(function(e) {
				$('.acf-block-questionnaire .titre, .acf-block-questionnaire .ouvrir ').slideDown(500);
				voletQ.animate(
					{right: -1*width},
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

		var elementInput=$('.form-group.question_element input');	
		if (elementInput.length > 0) {
			elementInput.change(function (e) { 
				var newElement=$('.form-group.question_element input:checked').val();
				console.log(newElement);
				choixElement(newElement);
			});

			//Pour le style : appliquer une classe au label quand l'input radio est checked
			$('input[type="radio"]').change(function(e) {
				var name=$(this).attr('name');
				$('label[for^="'+name+'"].radio-inline').removeClass('checked');
				if($(this).is(':checked')) {
					$(this).parent().addClass('checked');
				}
			});
		}

		function choixElement(element) {
			$('.form-group.element input').val(element);
			$('.form-group.reponse_element textarea').val($('.reponse_'+element).html());
			$('#element').html(element);
			localStorage.setItem('mbb_element',element);
			$('.site').removeClass('eau feu terre air');
			$('.site').addClass(element);
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

		/****************** Sliders coachs *************************/
		var flecheSlider=$('.fleche-coach');
		flecheSlider.click(function (e) { 
			var slider=$('#coachs');
			var active=parseInt(slider.attr('data-active'));
			var derniere=parseInt(slider.attr('data-nombre'));
			var direction=parseInt($(this).attr("data-direction"));
			var newSlide=active+direction;
			var slideWidth=$('.coach').outerWidth();
			if(newSlide >= 0 && newSlide < derniere) {
				var newLeft=-1 * newSlide * slideWidth;
				slider.css('left',newLeft);
				slider.attr('data-active',newSlide);
			}
		});

		/****************** Sliders reservation session *************************/
		var flecheSession=$('.fleche-session');
		if(flecheSession.length >0) {
			var slider=$('#sessions');
			var sliderWrapper=$('.sessions-wrapper');
			var derniere=parseInt(slider.attr('data-nombre'));
			var slideWidth=$('.session').outerWidth()+parseInt($('.session').css('margin-right'));

			//au chargement, ajouter la classe actif au premier bouton
			$('.navigation > button:first-of-type').addClass('actif');


			flecheSession.click(function (e) { 
				var active=parseInt(slider.attr('data-active'));
				var direction=parseInt($(this).attr("data-direction"));
				var newSlide=active+direction;
				bougeSession(newSlide);
				var type=$('.sessions').find(`[data-session='${newSlide+1}']`).attr('data-type');
				repereBouton(type);
			});
	
			$('.navigation > button').on('click touchend',function(e) {
				var newSlide=parseInt($(this).attr('data-left'))-1;
				bougeSession(newSlide);
				$('.navigation > button').removeClass('actif');
				$(this).addClass('actif');
			});
		}

		function bougeSession(newSlide) {
			if(newSlide >= 0 && newSlide < derniere) {
				var newLeft=-1 * newSlide * slideWidth;
				if(width>768) { //en desktop on change la position du slider
					slider.css('left',newLeft);
				} else { // en mobile on utilise le scroll horizontal
					$(sliderWrapper).animate({
						scrollLeft : -1*newLeft},
						300
					);
				}
				slider.attr('data-active',newSlide);
			}
		}
		

		function repereBouton(type) {
			$('.navigation > button').removeClass('actif');
			$('.navigation').find(`[data-type='${type}']`).addClass('actif');
		}

		

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
						var scrollMots=motWidth * (windowBottom - motTop) / (window.innerHeight - 160); //Longueur d'avancement dans la portion de fenêtre où les mots sont visibles + marge pour le sticky header
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

	if(width >= 768) {
		$(".acf-block-presse .owl-carousel").owlCarousel({
			center: true,
			loop:true,
			nav : false,
			dots : false,
			margin : 40,
			autoplay:true,
			autoplayTimeout:6000,
			autoplaySpeed:2000,
			autoplayHoverPause:true,
			items:1
		});
	}
	

	/****************** Carrousel de profils *************************/


	$(".acf-block-profils .owl-carousel").owlCarousel({
		center: false,
		loop:true,
		nav : true,
		dots : false,
		autoplay:true,
		autoplayTimeout:5000,
		autoplaySpeed:1500,
		navSpeed:1500,
		autoplayHoverPause:true,
		items:1,
	});

	/****************** Carrousel single studio *************************/


	$(".single-studio .owl-carousel").owlCarousel({
		center: false,
		loop:true,
		nav : true,
		dots : true,
		autoplay:true,
		autoplayTimeout:3000,
		autoplaySpeed:1500,
		autoplayHoverPause:true,
		items:1,
	});

	/****************** Onglets carte/liste studios *************************/
	var toggleListe=$('#toggle-liste');
	var toggleCarte=$('#toggle-carte');
	var listeStudios=$('#liste');
	var carteStudios=$('#carte');
	$(toggleListe).click(function(){
		if($(toggleListe).hasClass('inactif')) {
			toggleListe.toggleClass('inactif');
			toggleCarte.toggleClass('inactif');
			toggleListe.attr('aria-hidden',false);
			toggleCarte.attr('aria-hidden',true);
			listeStudios.fadeIn();
			carteStudios.fadeOut();
		}
	});
	$(toggleCarte).click(function(){
		if($(toggleCarte).hasClass('inactif')) {
			toggleListe.toggleClass('inactif');
			toggleCarte.toggleClass('inactif');
			toggleListe.attr('aria-hidden',true);
			toggleCarte.attr('aria-hidden',false);
			listeStudios.fadeOut();
			carteStudios.fadeIn();
		}
	});

	/****************** Filtre / recherche liste studio *************************/
	var searchInput=$("#studios-search");
	if(searchInput.length>0) {
		var optionsListe = {
			valueNames: [ 'nom', 'ville', 'code_postal' ]
		};
		var liste = new List('studios', optionsListe); //id du *container* de la liste ul.list
		$('#button-studios-search').click(function(){
			var top=$('#liste').offset().top - 100;
			$('html, body').animate({
				scrollTop: top
			}, 'slow');
		});
		liste.on('updated', function(liste) {
			if (liste.matchingItems.length > 0) {
				$('.no-result').slideUp()
			} else {
				$('.no-result').slideDown()
			}
		});
	}
	}); //fin document ready

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