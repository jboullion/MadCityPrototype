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