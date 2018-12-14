//hack to close address bar on mobile devices right away if not launching from the home screen
window.scrollTo(0,1);

// setup menu
$(document).ready(function(){
	$menu = $('#menu');
	$shade = $('#menu-shade');
	$toggle = $('.menu-toggle');

	$rollers = $('.roller');
	$rollerModal = $('#roller-modal');
	$mutate = $('.mutate');
	$mutateModal = $('#mutate-modal');
	$info = $('.info');
	$infoModal = $('#info-modal');

	$addPower = $('#add-power');
	$powerModal = $('#power-modal');

	$addEquipment = $('#add-equipment');
	$equipmentModal = $('#equipment-modal');

	$actionModals = $('.action-modal');
	$actionContent = $('.action-content');
	$actionClose = $('.action-close');

	$increment = $('.increment');
	$decrement = $('.decrement');

	$numberInputs = $('.number-control');

	$actionDice = $('.action-dice');
	$actionDiceResult = $('#dice-result');

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

	// Open the roller modal
	$rollers.click(function(e){
		$rollerModal.addClass('open');
	});

	// Open the mutate modal
	$mutate.click(function(e){
		$mutateModal.addClass('open');
	});

	// Open the Info modal
	$info.click(function(e){
		$infoModal.addClass('open');
	});

	// Open the Power modal
	$addPower.click(function(e){
		$powerModal.addClass('open');
	});

	// Open the Equipment modal
	$addEquipment.click(function(e){
		$equipmentModal.addClass('open');
	});

	// Increment a related value
	$increment.click(function(e){
		var target = $(this).data('target');
		var currentVal = parseInt($('#'+target).val().jbCleanNumber()) + 1;
		if(currentVal < 0){
			currentVal = 0;
		}
		$('#'+target).val(currentVal);
	});

	// Decrement a related value
	$decrement.click(function(e){
		var target = $(this).data('target');
		var currentVal = parseInt($('#'+target).val().jbCleanNumber()) - 1;
		if(currentVal < 0){
			currentVal = 0;
		}
		$('#'+target).val(currentVal);
	});

	// Roll a die!
	var rolling = false;
	var rollingTimer = null;
	$actionDice.click(function(e){
		e.preventDefault();
		e.stopPropagation();
		rolling = true;

		//clear our timer so we are not closing results while they are still clicking
		if(rollingTimer){
			clearTimeout(rollingTimer);
		}
		var value = parseInt($(this).data('value'));
		$actionDiceResult.css('left', $(this).position().left).addClass('open').find('span').html(value.random());
		
		//hide the dice results after a delay
		rollingTimer = setTimeout(function(){ 
			$actionDiceResult.removeClass('open');
		}, 2000);
	});

	
});