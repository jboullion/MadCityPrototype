// setup menu
$(document).ready(function(){
	$menu = $('#menu');
	$shade = $('#menu-shade');
	$toggle = $('.menu-toggle');

	// menu toggle
	$toggle.click(function(e){
		$menu.toggleClass('open');
		$shade.toggleClass('open');
	});

	// background shade when menu is open
	$shade.click(function(e){
		$menu.removeClass('open');
		$shade.removeClass('open');
	});

	// force the number input to be limited to it's max length
	// input[type=number]...optional if you decide this is useful on all number inputs 
	$('.number-control').on('input', function(){
		return (this.value.length > this.maxLength)?this.value = this.value.slice(0, this.maxLength):false;
	});
});