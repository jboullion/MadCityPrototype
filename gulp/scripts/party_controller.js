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

	partyTemplate = $('#party-template').html();
	partyUserTemplate = $('#party-user-template').html();

	//TODO: need to setup a delete party
	//$deleteparty = $('#delete-party');

	// Open the Party modal
	$createParty.click(function(e){
		$partyModal.addClass('open');
	});


	// Open the Edit Equipment modal
	$body.on('click','.edit-party', function(e){
		e.preventDefault();
		e.stopPropagation();

		var party_id = $(this).data('id');
		var party_name = $(this).data('name');
/*
		var party_users = $(this).data('users');

		var userHTML = '';
		if(party_users && party_users.length > 0){
			for(var i = 0; i < party_users.length; i++){
				console.log(party_users[i].user_id);
				console.log(party_users[i].user_email);

				userHTML += JBTemplateEngine(partyUserTemplate, {
					user_id: party_users[i].user_id,
					user_email: party_users[i].user_email
				});
			}
		}
*/
		//attach data to party edit modal
		$('#edit-party-id').val(party_id);
		$('#edit-party-name').val(party_name);
		//$('#edit-party-users').html(userHTML);
		//$('#edit-party-description').val(party_obj.description);

		$editPartyModal.addClass('open');

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
				$partyForm.find('.action-close').first().trigger('click');

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
				$editPartyForm.find('.action-close').first().trigger('click');

				console.log(result.party.party_name);
				console.log(result.party);
				console.log(partyTemplate);
				var updatedParty = JBTemplateEngine(partyTemplate, {
					party_id: result.party.party_id,
					party_name: result.party.party_name,
					dm_email: result.party.dm_email,
					next_session: '',
					last_online: '',
				});

				console.log(updatedParty);

				$('#party-'+result.party.party_id).replaceWith(updatedParty);
			}else if(result.error != null){
				//inform the user on failure
				alert('Error: '+result.error);
			}

		}, 'json').done(function() {
			$buttons.prop('disabled', false);
		});;
	});

});