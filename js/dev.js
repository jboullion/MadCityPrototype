/**
 * Set a Cookie
 * @param string cname  Cookie Name
 * @param mixed cvalue  Cookie Value
 * @param int exdays How many days before expire
 */
function jbSetCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays*24*60*60*1000));
	var expires = "expires="+ d.toUTCString();
	document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

/**
 * Get a cookie
 * @param  string cname  Cookie Name
 * @return string        Cookie Value
 */
function jbGetCookie(cname) {
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for(var i = 0; i <ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length,c.length);
		}
	}
	return "";
}

/**
 * Delete a Cookie
 * @param string cname  Cookie Name
 */
function jbDeleteCookie(cname) {
	jbSetCookie(cname, '', -1);
}

/**
 * Replace variables in a string / template
 * 
 * @param string  tpl     This should be a string containing <%name%> variables that will be replaced by JS.
 * @param json    data    This is the data object
 * 
 * @return string         The updated string with the variables replaced
 * 
 * @usage
 * var newString = JBTemplateEngine(stringTpl, {
                    dataID: 1,
                    name: James
                })
 */
function JBTemplateEngine(tpl, data) {
	for(var key in data){
		var re = new RegExp("<%" + key + "%>", "gi");
		tpl = tpl.replace(re, data[key]);
	}
	return tpl;
}

/**
 * Clean all non numeric characters. Also keeping "."
 * usage: str.jbCleanNumber()
 */
String.prototype.jbCleanNumber = function() {
	var returnValue = this.replace(/[^0-9.-]/g,'');

	//let's make sure we do not return a NaN value
	if(isNaN(returnValue) || returnValue == ""){
		returnValue = 0;
	}

	return returnValue;
}


/**
 * Capitalize the first letter of a string
 * usage: str.capitalize()
 */
String.prototype.capitalize = function() {
	return this.charAt(0).toUpperCase() + this.slice(1);
}


/**
 * Create a default string function to allow replacing all characters in a string
 * 
 * @param string search What are we trying to replace
 * @param string replacement Replace it with what?
 */
String.prototype.replaceAll = function(search, replacement) {
	return this.replace(new RegExp(search, 'g'), replacement);
};

/**
 * Replace all non standard characters with a space
 * 
 * @param string this we are targeting itself
 */
String.prototype.sanitize = function() {
	return this.replaceAll('/[^a-zA-Z0-9]/', ' ');
};


/**
 * Use a number to get a random value bewteen that number and 0
 * usage: Number.random();
 */
Number.prototype.random = function(){
	var min = 1;
	var max = Math.floor(this);
	return Math.floor(Math.random() * (max - min + 1)) + min;
};

/**
 * Format a float as currency
 * usage: floatvalue.jbFormatMoney(0, '.', ',');
 */
Number.prototype.jbFormatMoney = function(c, d, t){
	var n = this, 
		c = isNaN(c = Math.abs(c)) ? 2 : c, 
		d = d == undefined ? "." : d, 
		t = t == undefined ? "," : t, 
		s = n < 0 ? "-" : "", 
		i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
		j = (j = i.length) > 3 ? j % 3 : 0;

	return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

/**
 * Round a number to X decimals
 * @param  int 		decimals  	The number of decimals to round to
 * @return Number           	the resulting rounded number
 */
Number.prototype.round = function(decimals){
	var multiplier = Math.pow(10, decimals || 0);
	return Math.round(this * multiplier) / multiplier;
}

/**
 * Take a form and convert it into a Object for easy manipulation
 * 
 * @link https://stackoverflow.com/a/23315254
 * @link http://jsfiddle.net/akhildave/sxGtM/5002/
 */
$.fn.serializeObject = function() {
	var o = {};
	var a = this.serializeArray();
	$.each(a, function() {
		if (o[this.name] !== undefined) {
			if (!o[this.name].push) {
				o[this.name] = [o[this.name]];
			}
			o[this.name].push(this.value || '');
		} else {
			o[this.name] = this.value || '';
		}
	});
	return o;
};


/**
 * Reset a form element after the close animation completes
 * @param element $formElement The jQuery form element
 */
function resetForm($formElement){
	$formElement.find('.action-close').first().trigger('click');

	setTimeout(function(){
		$formElement.trigger("reset");
	}, ANIMATION_DURATION);
}

/**
 * 
 */
function confirmDelete($message){
	return confirm($message);
}

/**
 * @link https://davidwalsh.name/javascript-debounce-function
 */ 
function debounce(func, wait, immediate) {
	var timeout;
	return function() {
		var context = this, args = arguments;
		var later = function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		};
		var callNow = immediate && !timeout;
		clearTimeout(timeout);
		timeout = setTimeout(later, wait);
		if (callNow) func.apply(context, args);
	};
};
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

	/*
	$rollers = $('.roller');
	$rollerModal = $('#roller-modal');
	$mutate = $('.mutate');
	$mutateModal = $('#mutate-modal');
	*/

	$deleteCharacterModal = $('#delete-character-modal');
	$deleteCharacterForm = $('#delete-character-form');

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
	/*
	$rollers.click(function(e){
		$rollerModal.addClass('open');
	});

	// Open the mutate modal
	$mutate.click(function(e){
		$mutateModal.addClass('open');
	});
	*/

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

	// OPEN delete charater modal
	$body.on('click','.delete-character', function(e){
		e.preventDefault();
		e.stopPropagation();

		var character_id = $(this).data('id');
		var character_name = $(this).data('name');

		//attach data to party edit modal
		$('#delete-character-id').val(character_id);
		$('#delete-character-name').html(character_name);

		$deleteCharacterModal.addClass('open');

		return false;
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
				resetForm($editPowerForm);

				$('#power-'+deleteKey).fadeOut(ANIMATION_DURATION, function() {
					// Animation complete.
					$(this).remove();
				});

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
				resetForm($editEquipmentForm);
				
				$('#equipment-'+deleteKey).fadeOut('normal');

			}else if(result.error != null){
				//inform the user on failure
				alert('Error: '+result.error);
			}

		}, 'json').done(function() {
			$buttons.prop('disabled', false);
		});;
	});


	// DELETE Character
	$deleteCharacterForm.submit(function(e){
		e.preventDefault();

		if (! confirmDelete("Are you sure you want to delete this character?")) return false;

		var $buttons = $(this).find('button');
		var dataPost = $(this).serializeArray();
		var dataObject = $(this).serializeObject();

		//prevent double submission
		$buttons.prop('disabled', true);

		$.post( BASE_DIR+"rest/character/delete", dataPost, function( result ) {

			if(result.success != null){
				//reset form and close form on success
				resetForm($deleteCharacterForm);

				$('#character-'+dataObject.character_id).fadeOut(ANIMATION_DURATION, function() {
					// Animation complete.
					$(this).remove();
				});
			}else if(result.error != null){
				//inform the user on failure
				alert('Error: '+result.error);
			}

		}, 'json').done(function() {
			$buttons.prop('disabled', false);
		});;

		return false;
	});
});
/**
 * Controls the actions on the character listing page
 */
jQuery(document).ready(function($){

	$body = $('body');
	$characterList = $('#character-list-target');

	$addCharacter = $('#add-character');
	$characterModal = $('#character-modal');
	$characterForm = $('#character-form');

	//TODO: need to setup a delete character
	//$deleteCharacter = $('#delete-character');

	characterTemplate = $('#character-template').html();


	// Open the Power modal
	$addCharacter.click(function(e){
		$characterModal.addClass('open');
	});


	// When the user submits a power to be added to their character
	$characterForm.submit(function(e){
		e.preventDefault();

		var $buttons = $(this).find('button');
		var dataPost = $(this).serializeArray();
		var dataObject = $(this).serializeObject();

		//prevent double submission
		$buttons.prop('disabled', true);

		$.post( BASE_DIR+"rest/character/create", dataPost, function( result ) {

			if(result.success != null){
				//reset form and close form on success
				resetForm($characterForm);
				$characterForm.find('.action-close').first().trigger('click');

				var newCharacter = JBTemplateEngine(characterTemplate, {
					character_id: result.character_id,
					type: '', //TODO: This might need to be more dynamic
					name: dataObject.character_name
				});

				$characterList.append(newCharacter);
			}else if(result.error != null){
				//inform the user on failure
				alert('Error: '+result.error);
			}

			$buttons.prop('disabled', false);
		}, 'json');
	});

});
/**
 * Controls the actions on the party listing page
 */
jQuery(document).ready(function($){

	$body = $('body');
	$partyList = $('#party-list-target');

	$createParty = $('#create-party');
	$partyModal = $('#create-party-modal');
	$partyForm = $('#create-party-form');

	$editPartyModal = $('#edit-party-modal');
	$editPartyForm = $('#edit-party-form');
	$editPartyID = $('#edit-party-id');

	$deleteParty = $('#delete-party');

	$playerList = $('#player-list-target');

	$addPlayer = $('#add-player');
	$addPlayerModal = $('#add-player-modal');
	$addPlayerForm = $('#add-player-form');
	addPlayerPartyID = $('#add-player-party-id').val();
	addPlayerUserID = $('#add-player-user-id').val();

	$addPlayerSearch = $('#add-player-search');
	$addPlayerSearchTarget = $('#add-player-search-target');


	$removePlayerModal = $('#remove-player-modal');
	$removePlayerForm = $('#remove-player-form');
	$removePlayerID = $('#remove-player-id');

	partyTemplate = $('#party-template').html();
	playerTemplate = $('#player-template').html();
	playerSearchTemplate = $('#player-search-template').html();


	// OPEN Create Party modal
	$createParty.click(function(e){
		$partyModal.addClass('open');
	});

	// OPEN Add Player modal
	$addPlayer.click(function(e){
		$addPlayerModal.addClass('open');
	});
	
	// ADD user to party
	// $('.add-user-to-party').click(function(){
	// 	console.log('wtf?');
	// });

	// OPEN Edit Party modal
	$body.on('click','.edit-party', function(e){
		e.preventDefault();
		e.stopPropagation();

		var party_id = $(this).data('id');
		var party_name = $(this).data('name');

		//attach data to party edit modal
		$('#edit-party-id').val(party_id);
		$('#edit-party-name').val(party_name);

		$editPartyModal.addClass('open');

		return false;
	});

	// OPEN Remove Player modal
	$body.on('click','.remove-player', function(e){
		e.preventDefault();
		e.stopPropagation();

		var user_id = $(this).data('id');

		//attach data to party edit modal
		$removePlayerID.val(user_id);
		$removePlayerModal .addClass('open');

		return false;
	});


	// CREATE party
	$partyForm.submit(function(e){
		e.preventDefault();

		var $buttons = $(this).find('button');
		var dataPost = $(this).serializeArray();
		var dataObject = $(this).serializeObject();

		//prevent double submission
		$buttons.prop('disabled', true);

		$.post( BASE_DIR+"rest/party/create", dataPost, function( result ) {

			if(result.success != null){
				//reset form and close form on success
				resetForm($partyForm);

				var newparty = JBTemplateEngine(partyTemplate, {
					party_id: result.party_id,
					party_name: dataObject.party_name,
					dm_email: dataObject.dm_email,
					next_session: '',
					last_online: '',
				});

				$partyList.append(newparty);
			}else if(result.error != null){
				//inform the user on failure
				alert('Error: '+result.error);
			}

		}, 'json').done(function() {
			$buttons.prop('disabled', false);
		});;
	});


	// EDIT party
	$editPartyForm.submit(function(e){
		e.preventDefault();

		var $buttons = $(this).find('button');
		var dataPost = $(this).serializeArray();
		//var dataObject = $(this).serializeObject();

		//prevent double submission
		$buttons.prop('disabled', true);

		$.post( BASE_DIR+"rest/party/edit", dataPost, function( result ) {

			if(result.success != null){
				//reset form and close form on success
				resetForm($editPartyForm);

				var updatedParty = JBTemplateEngine(partyTemplate, {
					party_id: result.party.party_id,
					party_name: result.party.party_name,
					dm_email: result.party.dm_email,
					next_session: '',
					last_online: '',
				});

				$('#party-'+result.party.party_id).replaceWith(updatedParty);
			}else if(result.error != null){
				//inform the user on failure
				alert('Error: '+result.error);
			}

		}, 'json').done(function() {
			$buttons.prop('disabled', false);
		});;
	});


	// DELETE PARTY
	$deleteParty.click(function(e){
		e.preventDefault();

		if (! confirmDelete("Are you sure you want to delete this party?")) return false;

		var party_id = $editPartyID.val();
		var dataObject = $editPartyForm.serializeObject();
		
		//prevent double submission
		var $buttons = $editEquipmentForm.find('button');
		$buttons.prop('disabled', true);

		$.post( BASE_DIR+"rest/party/delete", {party_id: party_id, user_id: dataObject.user_id, party_password: dataObject.party_password}, function( result ) {

			if(result.success != null){
				//reset form and close form on success
				resetForm($editPartyForm);
	
				$('#party-'+party_id).fadeOut('normal');

			}else if(result.error != null){
				//inform the user on failure
				alert('Error: '+result.error);
			}

		}, 'json').done(function() {
			$buttons.prop('disabled', false);
		});;
	});

	// SEARCH Player
	var searchPlayer = debounce(function(search) {
		// All the taxing stuff you do

		if(search.length > 2){

			var dataPost = $addPlayerForm.serializeArray();

			$.get( BASE_DIR+"rest/party/search", dataPost, function( result ) {

				$addPlayerSearchTarget.html('');

				if(result.success != null && result.users.length > 0){
					
					for(var i = 0; i < result.users.length; i++){

						var newPlayer = JBTemplateEngine(playerSearchTemplate, {
							character_id: result.users[i].character_id,
							character_name: result.users[i].character_name,
							user_id: result.users[i].user_id,
						});

						$addPlayerSearchTarget.append(newPlayer);

					}

				}else if(result.error != null){
					//inform the user on failure
					//alert('Error: '+result.error);
					htmlResult = '<li class="list-group-item">'+result.error+'</li>';
					$addPlayerSearchTarget.html(htmlResult);
				}

			}, 'json');

		}
	}, 250);

	$addPlayerSearch.keyup(function(e){
		searchPlayer($(this).val());
	});
	

	// REMOVE Player
	$removePlayerForm.submit(function(e){
		e.preventDefault();

		var $buttons = $(this).find('button');
		var dataPost = $(this).serializeArray();
		var dataObject = $(this).serializeObject();

		//prevent double submission
		$buttons.prop('disabled', true);

		$.post( BASE_DIR+"rest/party/remove", dataPost, function( result ) {

			if(result.success != null){
				//reset form and close form on success
				resetForm($removePlayerForm);

				$('#player-'+dataObject.user_id).fadeOut(ANIMATION_DURATION, function() {
					// Animation complete.
					$(this).remove();
				});
			}else if(result.error != null){
				//inform the user on failure
				alert('Error: '+result.error);
			}

		}, 'json').done(function() {
			$buttons.prop('disabled', false);
		});;
	});
});

$playerList = $('#player-list-target');

function addPlayer(element){	
	var $button = $(element);
	var character_id = $button.data('id');
	var user_id = $button.data('user');
	var party_id = $('#add-player-party-id').val();


	//prevent double submission
	$button.prop('disabled', true);

	$.post( BASE_DIR+"rest/party/add", {party_id:party_id, character_id:character_id, user_id:user_id}, function( result ) {

		if(result.success != null){
			//reset form and close form on success
			//resetForm($addPlayerForm);

			var newPlayer = JBTemplateEngine(playerTemplate, {
				party_id: party_id,
				user_id: result.player.user_id,
				user_name: result.player.user_name,
				user_email: result.player.user_email,
				character_id: result.player.character_id,
				character_name: result.player.character_name
			});

			$playerList.append(newPlayer);
			$button.parents('.list-group-item').fadeOut(ANIMATION_DURATION, function() {
				// Animation complete.
				$(this).remove();
			});
		}else if(result.error != null){
			//inform the user on failure
			alert('Error: '+result.error);
			$button.prop('disabled', false);
		}else{
			$button.prop('disabled', true);
		}

	}, 'json');
}
var deferredPrompt;
//var addToHomeScreenBtns = document.querySelector('.action-dice');

//Does this browser support service workers?
if('serviceWorker' in navigator){
	
	//register our service worker
	navigator.serviceWorker
		.register('/serviceWorker.js')
		.then(function(){
			//console.log('Service Worker Registered');
		});
}

// Prevent the browser from automatically offering to put the app on the homescreen
window.addEventListener('beforeinstallprompt', function(event){
	//console.log('Before Install');
	event.preventDefault();
	deferredPrompt = event;
	return false;
});

/*
// https://developers.google.com/web/fundamentals/app-install-banners/
if(addToHomeScreenBtns){
	//Prompt the user to add this to their home screen
	addToHomeScreenBtns.addEventListener('click',function(){
		
		if(deferredPrompt){
			deferredPrompt.prompt();

			deferredPrompt.userChoice.then(function(choiceResult){
				console.log(choiceResult);

				if(choiceResult.outcome === 'dismissed'){
					console.log('Cancel add to home screen');
				}else{
					console.log('Add to homescreen');
				}
			});

			deferredPrompt = null;
		}
	});
}
*/

/**
 * Sign In Function from Google Docs for Google Auth
 * 
 * @link https://developers.google.com/identity/sign-in/web/sign-in
 * @param {*} googleUser The object from the google signin callback
 */
function googleSignIn(googleUser) {
	var profile = googleUser.getBasicProfile();
	var id_token = googleUser.getAuthResponse().id_token;
	var data = {
		email:profile.getEmail(),
		id_token:id_token
	};

	//set a cookie with this token so we can check it at a later time on the server
	jbSetCookie('google-idtoken', id_token, 1);
	jbSetCookie('email', profile.getEmail(), 1);

	//let our server know we are loggin in and redirect to character page
	jbUserFormSend('google-signin', data, $signinForm);

	// console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
	// console.log('Name: ' + profile.getName());
	// console.log('Image URL: ' + profile.getImageUrl());
	// console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.

}

/**
 * Sign Out Function from Google Docs for Google Auth
 * 
 * @link https://developers.google.com/identity/sign-in/web/sign-in
 */
function jbSignOut(e, email) {
	e.preventDefault();
	
	if(gapi.auth2){
		var auth2 = gapi.auth2.getAuthInstance();

		if (auth2.isSignedIn.get()) {
			//var profile = auth2.currentUser.get().getBasicProfile();
	
			auth2.signOut().then(function () {
				auth2.disconnect();
				jbDeleteSession(email);
			});
		}else{
			jbDeleteSession(email);
		}
	}else{
		jbDeleteSession(email);
	}

	return false;
}

/**
 * Delete a user's session and inform the server
 * 
 * @param string email Email address of user to log out
 */
function jbDeleteSession(email){
	jbDeleteCookie('google-idtoken');
	jbDeleteCookie('email');

	if(email){
		//disconnect from the server and then redirect to homepage
		jQuery.post( BASE_DIR+"rest/user/logout", {email:email}, function( result ) {
			if(result.success){
				window.location.href = window.location.protocol+"//"+window.location.hostname;
			}else{
				console.log(result);
			}
		});
	}
}

/**
 * We are calling this as the callback from the Google platform
 * 
 * @link https://stackoverflow.com/questions/30945798/html-php-google-single-sign-on-signout-will-throw-cannot-read-property-getauth
 */
function onLoad() {
	gapi.load('auth2', function() {
		gapi.auth2.init();
	});

}


/**
 * Send data to our rest API and respond accordingly
 * 
 * @param string script The name of the script to post to
 * @param object data the object you would like to send to the server 
 * @param jQueryElement $form the form sending the information that will also reciece the error notices
 */
function jbUserFormSend(script, data, $form){
	$.post( BASE_DIR+"rest/user/"+script, data, function( result ) {
		if(result.success){

			//redirect should occur on the server level, until we move to React
			if('forgot-form' == $form[0].id){
				$form.find('.alert-danger').addClass('hidden');
				$form.find('.alert-success').html(result.success).removeClass('hidden');
			}else{
				jbSetCookie('email', data.email, 1);
				window.location.href = window.location.protocol+"//"+window.location.hostname+"/character/";
			}

		}else if(result.error){
			$form.find('.alert-danger').html(result.error).removeClass('hidden');
		}else{
			$form.find('.alert-danger').html('Unknown Error').removeClass('hidden');
		}

		if('forgot-form' == $form[0].id){
			$form.find('.btn-primary').html('Get New Password').prop('disabled', false);
		}
	}, 'json');
}

/**
 * Controls the actions and tracks the data on the character page
 */
jQuery(document).ready(function($){
	$body = $('body');
	$loginForms = $('.login-form');

	$signinForm = $('#signin-form');
	$signinBtns = $('.signin-btn');

	$signupForm = $('#signup-form');
	$signupBtns = $('.signup-btn');

	$forgotForm = $('#forgot-form');
	$forgotBtns = $('.forgot-btn');

	// Submit our character sheet to our update function to save
	$signinForm.submit(function(e){
		e.preventDefault();

		var data = $(this).serializeArray();

		jbUserFormSend('signin', data, $signinForm);

	});

	// Submit our character sheet to our update function to save
	$signupForm.submit(function(e){
		e.preventDefault();

		var data = $(this).serializeArray();

		jbUserFormSend('signup', data, $signinForm);

	});

	// Submit our character sheet to our update function to save
	$forgotForm.submit(function(e){
		e.preventDefault();

		var data = $(this).serializeArray();
		$forgotForm.find('.btn-primary').html('<i class="fal fa-circle-notch fa-spin"></i>').prop('disabled', true);

		jbUserFormSend('forgot', data, $forgotForm);
	});

	$signinBtns.click(function(e){
		$loginForms.removeClass('open');
		$signinForm.addClass('open');
	});

	$signupBtns.click(function(e){
		$loginForms.removeClass('open');
		$signupForm.addClass('open');
	});

	$forgotBtns.click(function(e){
		$loginForms.removeClass('open');
		$forgotForm.addClass('open');
	});

});

