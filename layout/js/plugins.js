$(function () {
	
	'use strict';
	$('[placeholder]').focus(function () {
		$(this).attr('data-text', $(this).attr('placeholder'));
		$(this).attr('placeholder', '');
		}).blur(function () {
			$(this).attr('placeholder', $(this).attr('data-text'));
		});

	$('input').each(function () {
		if($(this).attr('required')=='required'){
			$(this).after('<span class="astrisk">*</span>');
		}
	});
	
	// Show Password

	var passField = $('.password');

	$('.show-pass').hover(
		function () {
			passField.attr('type','text');
	}, function(){
			passField.attr('type','password');
	});
	$('.confirm').click(function () {
		return confirm('Are You sure ?');
	});
});