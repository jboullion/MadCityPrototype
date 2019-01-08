/**
 * Controls the actions and tracks the data on the character page
 */

//Prevent the user from hitting enter and submitting the form
$(window).keydown(function(event){
	if(event.keyCode == 13) {
		event.preventDefault();
		return false;
	}
});

jQuery(document).ready(function($){
	ANIMATION_DURATION = 300;

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

	$editPowerModal = $('#edit-power-modal');
	$editPowerForm = $('#edit-power-form');
	$editPowerKey = $('#edit-power-key');

	$deletePower = $('#delete-power');

	powerTemplate = $('#power-template').html();

	// Equipment
	$addEquipment = $('#add-equipment');
	$equipmentModal = $('#equipment-modal');
	$equipmentForm = $('#equipment-form');
	$equipmentTable = $('#equipment-table tbody');

	$editEquipmentModal = $('#edit-equipment-modal');
	$editEquipmentForm = $('#edit-equipment-form');
	$editEquipmentKey = $('#edit-equipment-key');

	$deleteEquipment = $('#delete-equipment');

	equipmentTemplate = $('#equipment-template').html();

	$increment = $('.increment');
	$decrement = $('.decrement');

	$diceToggle = $('#dice-toggle');
	$diceShelf = $('#dice-shelf');
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

	$diceToggle.click(function(e){
		$diceShelf.toggleClass('open');
	});

	// Open the Edit Power modal
	$body.on('click','.edit-power', function(e){
		var power = $(this).data('object');
		var key = $(this).data('key');

		/*
		if(power.level){
			var level = power.level;
		}else{
			var level = 1;
		}
		*/

		//setup all the data from this power
		$('#edit-power-name').val(power.name);
		$('#edit-power-type').val(power.type);
		$('#edit-power-stat').val(power.stat);
		$('#edit-power-damage').val(power.damage);
		$('#edit-power-effect').val(power.effect);
		$('#edit-power-duration').val(power.duration);
		$('#edit-power-desc').val(power.desc);
		$editPowerKey.val(key);

		$editPowerModal.addClass('open');
	});


	// Open the Edit Equipment modal
	$body.on('click','.edit-equipment', function(e){
		var equipment = $(this).data('object');
		var key = $(this).data('key');


		//setup all the data from this equipment
		$('#edit-equipment-slot').val(equipment.slot);
		$('#edit-equipment-name').val(equipment.name);
		$('#edit-equipment-bonus').val(equipment.bonus);
		$('#edit-equipment-stat').val(equipment.stat);
		$('#edit-equipment-desc').val(equipment.desc);
		$editEquipmentKey.val(key);

		$editEquipmentModal.addClass('open');
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

		console.log(dataObject);

		//prevent double submission
		$buttons.prop('disabled', true);

		$.post( BASE_DIR+"rest/character/powers/add", dataPost, function( result ) {

			if(result.success != null){
				//reset form and close form on success
				resetForm($powerForm);
				$powerForm.find('.action-close').first().trigger('click');

				var newPower = JBTemplateEngine(powerTemplate, {
					key: $powerTable.find('tr').length,
					object: JSON.stringify(dataObject),
					type: dataObject.type,
					name: dataObject.name,
					damage: dataObject.damage,
					effect: dataObject.effect
				});

				$powerTable.append(newPower);

			}else if(result.error != null){
				//inform the user on failure
				alert('Error: '+result.error);
			}

		}, 'json').done(function() {
			$buttons.prop('disabled', false);
		});;
	});

	// Handle the user editing a power
	$editPowerForm.submit(function(e){
		e.preventDefault();

		var $buttons = $(this).find('button');
		var dataPost = $(this).serializeArray();
		var powerObject = $(this).serializeObject();
		var editKey = $editPowerKey.val();

		//prevent double submission
		$buttons.prop('disabled', true);

		$.post( BASE_DIR+"rest/character/powers/edit", dataPost, function( result ) {

			if(result.success != null){
				//reset form after animation completes
				resetForm($editPowerForm);
				$editPowerForm.find('.action-close').first().trigger('click');

				var $editedPower = $('#power-'+editKey);

				$editedPower.data('object', powerObject);
				$editedPower.find('.type span').html(powerObject.type);
				$editedPower.find('.name').html(powerObject.name);
				$editedPower.find('.damage').html(powerObject.damage);
				$editedPower.find('.effect').html(powerObject.effect);

			}else if(result.error != null){
				//inform the user on failure
				alert('Error: '+result.error);
			}

		}, 'json').done(function() {
			$buttons.prop('disabled', false);
		});;
	});

	// delete a power
	$deletePower.click(function(e){
		e.preventDefault();

		if (! confirmDelete("Are you sure you want to delete this power?")) return false;

		var deleteKey = $editPowerKey.val();
		var dataObject = $editPowerForm.serializeObject();
		
		//prevent double submission
		var $buttons = $editPowerForm.find('button');
		$buttons.prop('disabled', true);

		$.post( BASE_DIR+"rest/character/powers/delete", {delete_key:deleteKey, user_id: dataObject.user_id, character_id: dataObject.character_id}, function( result ) {

			if(result.success != null){
				//reset form and close form on success
				$editPowerForm.find('.action-close').first().trigger('click');

				resetForm($editPowerForm);

				$('#power-'+deleteKey).fadeOut(ANIMATION_DURATION);

			}else if(result.error != null){
				//inform the user on failure
				alert('Error: '+result.error);
			}

		}, 'json').done(function() {
			$buttons.prop('disabled', false);
		});;
	});


	// Handle the equipment form submission
	$equipmentForm.submit(function(e){
		e.preventDefault();

		var $buttons = $(this).find('button');
		var dataPost = $(this).serializeArray();
		var equipmentObject = $(this).serializeObject();

		//prevent double submission
		$buttons.prop('disabled', true);

		$.post( BASE_DIR+"rest/character/equipment/add", dataPost, function( result ) {

			if(result.success != null){
				//reset form after animation completes
				resetForm($equipmentForm);
				
				//close form on success
				$equipmentForm.find('.action-close').first().trigger('click');

				var newEquipment = JBTemplateEngine(equipmentTemplate, {
					key: $equipmentTable.find('tr').length,
					object: JSON.stringify(equipmentObject),
					slot: equipmentObject.slot.capitalize(),
					name: equipmentObject.name,
					bonus: equipmentObject.bonus,
					stat: equipmentObject.stat.capitalize()
				});

				$equipmentTable.append(newEquipment);

			}else if(result.error != null){
				//inform the user on failure
				alert('Error: '+result.error);
			}

		}, 'json').done(function() {
			$buttons.prop('disabled', false);
		});;
	});

	// Handle the user editing a equipment
	$editEquipmentForm.submit(function(e){
		e.preventDefault();

		var $buttons = $(this).find('button');
		var dataPost = $(this).serializeArray();
		var equipmentObject = $(this).serializeObject();
		var editKey = $editEquipmentKey.val();

		//prevent double submission
		$buttons.prop('disabled', true);

		$.post( BASE_DIR+"rest/character/equipment/edit", dataPost, function( result ) {

			if(result.success != null){
				//TODO: This is where React is going to be amazing. Now I have to do so bullshit to update the table, but React would do that automagically

				//reset form and close form on success
				resetForm($editEquipmentForm);
				$editEquipmentForm.find('.action-close').first().trigger('click');

				var $editedEquipment = $('#equipment-'+editKey);

				$editedEquipment.data('object', equipmentObject);
				$editedEquipment.find('.slot span').html(equipmentObject.slot);
				$editedEquipment.find('.name').html(equipmentObject.name);
				$editedEquipment.find('.bonus').html('+'+equipmentObject.bonus+' '+equipmentObject.stat);
				//$editedEquipment.find('.desc').html(equipmentObject.desc);

			}else if(result.error != null){
				//inform the user on failure
				alert('Error: '+result.error);
			}

		}, 'json').done(function() {
			$buttons.prop('disabled', false);
		});;
	});

	// delete a equipment
	$deleteEquipment.click(function(e){
		e.preventDefault();

		if (! confirmDelete("Are you sure you want to delete this equipment?")) return false;

		var deleteKey = $editEquipmentKey.val();
		var dataObject = $editEquipmentForm.serializeObject();
		
		//prevent double submission
		var $buttons = $editEquipmentForm.find('button');
		$buttons.prop('disabled', true);

		$.post( BASE_DIR+"rest/character/equipment/delete", {delete_key:deleteKey, user_id: dataObject.user_id, character_id: dataObject.character_id}, function( result ) {

			if(result.success != null){
				//reset form and close form on success
				$editEquipmentForm.trigger("reset");
				$editEquipmentForm.find('.action-close').first().trigger('click');
				
				$('#equipment-'+deleteKey).fadeOut('normal');

			}else if(result.error != null){
				//inform the user on failure
				alert('Error: '+result.error);
			}

		}, 'json').done(function() {
			$buttons.prop('disabled', false);
		});;
	});

});