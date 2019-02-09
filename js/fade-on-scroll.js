// JavaScript Document

function LoadFadeOnScrollHandler() {
	'use strict';
	console.log('loading');
	$(window).scroll(function() {
		var windowBottom = $(this).scrollTop() + $(this).innerHeight();
		$(".fade-on-scroll").each(function() {
			
			var objectTop = $(this).offset().top;
			
			// fade smoothly as object moves into view
			var buffer = 50;
			
			if (((objectTop + buffer) <= windowBottom) && ($(this).css("opacity")==0)) {
				$(this).stop().animate({top: '0px', opacity: '1'}, 500);
			}
			else if (((objectTop) > windowBottom) && ($(this).css("opacity")==1)) {
				$(this).stop().css({top: '5rem', opacity: '0'});
			}
		});
	}).scroll();
}

if (typeof(jQuery) !== 'undefined') {
	$ = jQuery;
}
var fadeOnScrollLoaded = setInterval(function() {
	if (typeof($) === 'undefined') {
		return;
	}
	clearInterval(fadeOnScrollLoaded);
	LoadFadeOnScrollHandler();
}, 16);