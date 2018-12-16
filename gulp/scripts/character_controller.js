/**
 * Controls the actions and tracks the data on the character page
 */
jQuery(document).ready(function($){
	$characterSheet = $('#character-sheet');
	$inputSaves = $('.character-save');

	$rollers = $('.roller');
	$rollerModal = $('#roller-modal');
	$mutate = $('.mutate');
	$mutateModal = $('#mutate-modal');
	$info = $('.info');
	$infoModal = $('#info-modal');

	$addPower = $('#add-power');
	$powerModal = $('#power-modal');
	$powerForm = $('#power-form');
	$powerTable = $('#power-table tbody');
	Tpower = $('#power-template').html();

	$addEquipment = $('#add-equipment');
	$equipmentModal = $('#equipment-modal');

	$increment = $('.increment');
	$decrement = $('.decrement');

	$actionDice = $('.action-dice');
	$actionDiceResult = $('#dice-result');


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
		$('#'+target).val(currentVal).trigger('change');
	});

	// Decrement a related value
	$decrement.click(function(e){
		var target = $(this).data('target');
		var currentVal = parseInt($('#'+target).val().jbCleanNumber()) - 1;
		if(currentVal < 0){
			currentVal = 0;
		}
		$('#'+target).val(currentVal).trigger('change');

	});

	// Roll a die!
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

	// Submit our character sheet to our update function to save
	$characterSheet.submit(function(e){
		e.preventDefault();

		var data = $(this).serializeArray();

		$.post( BASE_DIR+"rest/character/update", data, function( result ) {
			//console.log(result);
		}, 'json');

	});


	// Any time an input element with the 'save' class is changed we will save our character
	$inputSaves.change(function(e){
		$characterSheet.trigger('submit');
	});


	// When the user submits a power to be added to their character
	$powerForm.submit(function(e){
		e.preventDefault();

		var $buttons = $(this).find('button');
		var dataPost = $(this).serializeArray();
		var dataObject = $(this).serializeObject();

		//prevent double submission
		$buttons.prop('disabled', true);

		$.post( BASE_DIR+"rest/character/power", dataPost, function( result ) {

			if(result.success != null){
				//reset form and close form on success
				$powerForm.trigger("reset");
				$powerForm.find('.action-close').first().trigger('click');

				var newPower = JBTemplateEngine(Tpower, {
					key: $powerTable.find('tr').length,
					object: JSON.stringify(dataObject),
					type: dataObject.type,
					name: dataObject.name
				});

				$powerTable.append(newPower);
			}else if(result.error != null){
				//inform the user on failure
				alert('Error: '+result.error);
			}

			$buttons.prop('disabled', false);
		}, 'json');
	});

});