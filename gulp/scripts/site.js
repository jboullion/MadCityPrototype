// setup menu
$(document).ready(function(){
	$body = $('body');
	$menu = $('#menu');
	$toggle = $('.menu-toggle');

	$toggle.click(function(e){
		$menu.toggleClass('open');
		$body.toggleClass('open');
	});
});