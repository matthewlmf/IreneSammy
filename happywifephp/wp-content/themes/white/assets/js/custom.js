jQuery(document).ready( function () {
	jQuery('#site-navigation li').find('ul').hide();
		jQuery('#site-navigation li').hover(
			function(){
				
				jQuery(this).find('> ul').slideDown('fast');
			},
			function(){
				jQuery(this).find('ul').hide();
			});	
		
		jQuery('.menu-toggle').toggle(function() {
				jQuery('#site-navigation ul.menu').slideDown();
				jQuery('#site-navigation div.menu').fadeIn();
			},
			function() {
				jQuery('#site-navigation ul.menu').hide();
				jQuery('#site-navigation div.menu').hide();
		});
	
	});//end ready
	
//For Slider

jQuery(document).ready(function(){
		jQuery('.bxslider').bxSlider( {
		mode: 'fade',
		speed: 700,
		captions: true,
		nextSelector: '#slider-next',
		prevSelector: '#slider-prev',
		nextText: '<i class="fa fa-angle-right"></i>',
		prevText: '<i class="fa fa-angle-left"></i>',
		minSlides: 1,
		maxSlides: 1,
		adaptiveHeight: true,
		//slideWidth: 1090, 
		auto: true,
		preloadImages: 'all',
		pause: 5000,
		onSliderLoad: function(first) {
			first++;
			jQuery('.bxslider li:nth-child('+first+') img').transition({
										transform: 'scale(1.0) rotate(0deg)' 
			},4000,'ease');
		},
		onSlideAfter: function(element,old,cur) {
			cur++;
			old++;
			jQuery('.bxslider li:nth-child('+cur+') img').transition({
										transform: 'scale(1.0) rotate(0deg)' 
			},4000,'ease');
			jQuery('.bxslider li:nth-child('+old+') img').transition({
										transform: 'scale(1.1)' 
			},2000,'ease');	
		},
		autoHover: true } );
		
		
});	