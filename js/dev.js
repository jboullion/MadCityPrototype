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
	setCookie(cname, '', -1);
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
	var re = /<%([^%>]+)?%>/g, match;
	while(match = re.exec(tpl)) {
		tpl = tpl.replace(match[0], data[match[1]])
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
 * Create a default string function to allow replacing all characters in a string
 */
String.prototype.replaceAll = function(search, replacement) {
	return this.replace(new RegExp(search, 'g'), replacement);
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

//hack to close address bar on mobile devices right away if not launching from the home screen
window.scrollTo(0,1);

//used around the site for post calls and stuff
var BASE_DIR = '/madcity/';

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