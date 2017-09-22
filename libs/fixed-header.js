(function(window, document, $, undefined){

	"use strict";
	var $window = $(window);
	var $body = $('body');
	var $mainDrawing = $('#mainDrawing');
	var $detailsAnchor = $('#detailsAnchor');
	var $top_nav = $('.top-nav');

	var $movingCar1 = $('#movingCar1');
	var $movingCar2 = $('#movingCar2');
	var $movingCar3 = $('#movingCar3');
	var $movingCar4 = $('#movingCar4');
	var $movingCar5 = $('#movingCar5');
	var $movingCar6 = $('#movingCar6');
	var $movingCar7 = $('#movingCar7');
	var $movingCar8 = $('#movingCar8');
	var $street = $('#movingCarBlock');

	var firstMessage = $('#firstMessage');
	var lines = new Array();
		lines = $(lines);
	firstMessage.children(':not(#goDown)').each(function(){
		lines.push(this);
	});

	var scrolled;

	$window.on('load scroll', function(event){
		var navHeight= $top_nav.height();
			scrolled = Math.max(0, $window.scrollTop());
		var detailsTop = ($detailsAnchor.offset().top-navHeight)-($mainDrawing.height()*0.25);
		var navSetOpacity = 0;

		// NAV
		if (scrolled > detailsTop) {
			$body.addClass('fixed-header');
			navSetOpacity = (scrolled - detailsTop < navHeight) ? (scrolled-detailsTop)/navHeight : 1;
		}
		else {
			$body.removeClass('fixed-header');
			navSetOpacity = 1;
		}
		$top_nav.css({
			'opacity' : navSetOpacity
		});


		// CAR

		
		if ($('#movingCar1').length != 0){
			var carTop = $movingCar1.offset().top;
			var carLeft = 0;
			var streetTop = $street.offset().top;
			var streetHeight = $street.height();
			var streetMax = streetTop+streetHeight;
			var spaceheight = $window.height();
			if (scrolled+spaceheight > streetTop) {
	//			carLeft = ((scrolled+600)-streetTop)/streetHeight;
				carLeft = ((scrolled+spaceheight)-streetTop)/spaceheight;
			}
			$movingCar1.css({
				'left' : (carLeft*100)-20+'%'
			});
			$movingCar2.css({
				'left' : (carLeft*110)-43+'%'
			});
			$movingCar3.css({
				'left' : (carLeft*100.4)-65+'%'
			});
			$movingCar4.css({
				'left' : (carLeft*90)-30+'%'
			});
			$movingCar5.css({
				'left' : (carLeft*93)-25+'%'
			});
			$movingCar6.css({
				'left' : (carLeft*103)-37+'%'
			});
			$movingCar7.css({
				'left' : (carLeft*105.4)-62+'%'
			});
			$movingCar8.css({
				'left' : (carLeft*97)-55+'%'
			});
		}
	});

	/**** Functions********************************************************/
	function userAgent(iOs){
		// if iOs parameter is present detect if user agent is iOs.
		if(iOs) {
			if(navigator.userAgent.match(/(iPad|iPhone|iPod)/i))
				return true;
			else
				return false;
		// else detect the user agent
		} else {
			if(navigator.userAgent.match(/iPod/i))
				return 'iPod';
			if(navigator.userAgent.match(/iPhone/i))
				return 'iPhone';
			else if(navigator.userAgent.match(/iPad/i))
				return 'iPad';
			else
				return false;
		}
	}



	$window.on('load resize', function(event){
		if ($window.height() > firstMessage.height()) {
			firstMessage.outerHeight($window.height());
			var lastItem = lines.last();
			var newPadding = $window.height()-(lastItem.offset().top + lastItem.outerHeight());
			firstMessage.css('padding', newPadding/2+"px 30px");
		}
	});
	$window.on('scroll', function(event){
		var maxHeight = firstMessage.height()/2;
			lines.eq(0).css('opacity',1);
		if((scrolled < maxHeight)){
			lines.filter(':gt(0)').each(function(){
				$(this).css('opacity',scrolled/($(this).offset().top/2));
			});
//				scrolled = Math.max(0, $window.scrollTop());
		} else {
			lines.each(function(){
				$(this).css('opacity', 1);
			});
		}
	});
})(window, document, jQuery);
