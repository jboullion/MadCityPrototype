/**
 * Controls the actions on the party listing page
 */
jQuery(document).ready(function($){

	$body = $('body');
	$partyList = $('#party-list-target');

	$createParty = $('#create-party');
	$partyModal = $('#party-create-modal');
	$partyForm = $('#party-create-form');

	partyTemplate = $('#party-template').html();

	//TODO: need to setup a delete party
	//$deleteparty = $('#delete-party');

	// Open the Party modal
	$createParty.click(function(e){
		console.log('open create party');
		$partyModal.addClass('open');
	});


	// When the user submits a power to be added to their party
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
				$partyForm.find('.action-close').first().trigger('click');

				var newparty = JBTemplateEngine(partyTemplate, {
					party_id: result.party_id,
					party_name: dataObject.party_name,
					dm_id: dataObject.user_id,
					next_session: '',
					last_online: '',
				});

				$partyList.append(newparty);
			}else if(result.error != null){
				//inform the user on failure
				alert('Error: '+result.error);
			}

			$buttons.prop('disabled', false);
		}, 'json');
	});

});