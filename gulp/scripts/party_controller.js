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
		console.log('Edit Party');
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

			console.log(result.user);

			var newPlayer = JBTemplateEngine(playerTemplate, {
				party_id: party_id,
				user_id: result.player.user_id,
				user_name: result.player.user_name,
				user_email: result.player.user_email,
				character_id: result.player.character_id,
				character_name: result.player.character_name
			});

			console.log(newPlayer);

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