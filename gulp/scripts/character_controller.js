/**
 * Controls the actions and tracks the data on the character page
 */
jQuery(document).ready(function($){

	$body = $('body');
	$characterSheet = $('#character-sheet');
	$inputSaves = $('.character-save');

	$rollers = $('.roller');
	$rollerModal = $('#roller-modal');
	$mutate = $('.mutate');
	$mutateModal = $('#mutate-modal');

	// Power
	$addPower = $('#add-power');
	$powerModal = $('#power-modal');
	$powerForm = $('#power-form');
	$powerTable = $('#power-table tbody');
	//$editPowerBtn = $('.edit-power');
	$editPowerModal = $('#edit-power-modal');
	$editPowerForm = $('#edit-power-form');
	$editPowerKey = $('#edit-power-key');
	$deletePower = $('#delete-power');
	powerTemplate = $('#power-template').html();

	// Equipment
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

	// Open the Power modal
	$addPower.click(function(e){
		$powerModal.addClass('open');
	});

	// Open the Edit Power modal
	$body.on('click','.edit-power', function(e){
		var power = $(this).parent().data('object');
		var key = $(this).parent().data('key');

		if(power.level){
			var level = power.level;
		}else{
			var level = 1;
		}
		
		//setup all the data from this power
		$('#edit-power-level').val(level);
		$('#edit-power-type').val(power.type);
		$('#edit-power-name').val(power.name);
		$('#edit-power-damage').val(power.damage);
		$('#edit-power-effect').val(power.effect);
		$('#edit-power-desc').val(power.desc);
		$editPowerKey.val(key);

		$editPowerModal.addClass('open');

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

		$.post( BASE_DIR+"rest/character/powers/add", dataPost, function( result ) {

			if(result.success != null){
				//reset form and close form on success
				$powerForm.trigger("reset");
				$powerForm.find('.action-close').first().trigger('click');

				var newPower = JBTemplateEngine(powerTemplate, {
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

	// Handle the user editing a power
	$editPowerForm.submit(function(e){
		e.preventDefault();

		var $buttons = $(this).find('button');
		var dataPost = $(this).serializeArray();
		var dataObject = $(this).serializeObject();
		var editKey = $editPowerKey.val();
		
		//prevent double submission
		$buttons.prop('disabled', true);

		$.post( BASE_DIR+"rest/character/powers/edit", dataPost, function( result ) {

			if(result.success != null){
				//TODO: This is where React is going to be amazing. Now I have to do so bullshit to update the table, but React would do that automagically

				//reset form and close form on success
				$editPowerForm.trigger("reset");
				$editPowerForm.find('.action-close').first().trigger('click');

				var $editedPower = $('#power-'+editKey);

				$editedPower.data('object', dataObject);
				$editedPower.find('.type span').html(dataObject.type);
				$editedPower.find('.name').html(dataObject.name);

			}else if(result.error != null){
				//inform the user on failure
				alert('Error: '+result.error);
			}

			$buttons.prop('disabled', false);
		}, 'json');
	});

	// delete a power
	$deletePower.click(function(e){
		e.preventDefault();

		var deleteKey = $editPowerKey.val();
		var dataObject = $editPowerForm.serializeObject();
		
		//prevent double submission
		var $buttons = $editPowerForm.find('button');
		$buttons.prop('disabled', true);

		$.post( BASE_DIR+"rest/character/powers/delete", {delete_key:deleteKey, user_id: dataObject.user_id, character_id: dataObject.character_id}, function( result ) {

			if(result.success != null){
				//reset form and close form on success
				$editPowerForm.trigger("reset");
				$editPowerForm.find('.action-close').first().trigger('click');
				
				$('#power-'+deleteKey).fadeOut('normal');

			}else if(result.error != null){
				//inform the user on failure
				alert('Error: '+result.error);
			}

			$buttons.prop('disabled', false);
		}, 'json');
	});

});