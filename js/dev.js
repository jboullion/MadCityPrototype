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
		var power = $(this).data('object');
		var key = $(this).data('key');

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
					name: dataObject.name,
					damage: dataObject.damage,
					effect: dataObject.effect
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
		var powerObject = $(this).serializeObject();
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

				$editedPower.data('object', powerObject);
				$editedPower.find('.type span').html(powerObject.type);
				$editedPower.find('.name').html(powerObject.name);
				$editedPower.find('.damage').html(powerObject.damage);
				$editedPower.find('.effect').html(powerObject.effect);

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
				//reset form and close form on success
				$equipmentForm.trigger("reset");
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

			$buttons.prop('disabled', false);
		}, 'json');
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
				$editEquipmentForm.trigger("reset");
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

			$buttons.prop('disabled', false);
		}, 'json');
	});

	// delete a equipment
	$deleteEquipment.click(function(e){
		e.preventDefault();

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

			$buttons.prop('disabled', false);
		}, 'json');
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
				$characterForm.trigger("reset");
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
	
	var auth2 = gapi.auth2.getAuthInstance();

	if (auth2.isSignedIn.get()) {
		//var profile = auth2.currentUser.get().getBasicProfile();
		console.log('Google Logout');

		auth2.signOut().then(function () {
			jbDeleteCookie('google-idtoken');
			jbDeleteCookie('email');
			
			//disconnect from the server and then redirect to homepage
			$.post( BASE_DIR+"rest/user/logout", {email:email}, function( result ) {
				if(result.success){
					window.location.href = window.location.protocol+"//"+window.location.hostname;
				}else{
					console.log(result);
				}
			});
		});
	}else{

		if(email){
			console.log('Mad City Logout');
			//disconnect from the server and then redirect to homepage
			$.post( BASE_DIR+"rest/user/logout", {email:email}, function( result ) {
				jbDeleteCookie('email');

				if(result.success){
					window.location.href = window.location.protocol+"//"+window.location.hostname;
				}else{
					console.log(result);
				}
			});
		}
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

