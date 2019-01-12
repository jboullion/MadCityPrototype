//used around the site for post calls and stuff
var BASE_DIR = '/';

// setup menu
jQuery(document).ready(function($){
	$menu = $('#menu');
	$shade = $('#menu-shade');
	$toggle = $('.menu-toggle');

	$numberInputs = $('.number-control');

	$actionModals = $('.action-modal');
	$actionContent = $('.action-content');
	$actionClose = $('.action-close');

	// menu toggle
	$toggle.click(function(e){
		console.log('click menu');
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
	$numberInputs.on('input', function(){
		return (this.value.length > this.maxLength)?this.value = this.value.slice(0, this.maxLength):false;
	});

	// prevent the action modals from closing when clicking on them
	$actionContent.click(function(e){
		e.stopPropagation();
	});

	// close all action modals
	$actionClose.click(function(e){
		$actionModals.removeClass('open');
	});

	// close a modal by clicking on the background
	$actionModals.click(function(e){
		$(this).removeClass('open');
	});

});


