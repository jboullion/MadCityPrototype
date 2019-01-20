<?php 
/**
 * Display chat log between two users
 */
function mc_display_chat($party_id, $send_id, $receive_id){
	global $PDO;

	try{
		//Could not get bind params to work on this query for some reason
		if($receive_id !== 0){
			$select = "SELECT * FROM chat 
						WHERE ( send_id = ? AND receive_id = ? )
							OR ( receive_id = ? AND send_id = ? )
							AND party_id = ?
						ORDER BY timestamp ASC";
			
			$stmt = $PDO->prepare($select);
			$stmt->execute( 
				array( $send_id, $receive_id, $send_id, $receive_id, $party_id	)
			);

		}else{
			$select = "SELECT * FROM chat 
						WHERE party_id = ? AND receive_id = 0 
						ORDER BY timestamp ASC";

			$stmt = $PDO->prepare($select);
			$stmt->execute( 
				array( $party_id )
			);
		}


		$chat = $stmt->fetchAll();

		if(! empty($chat)){
			foreach($chat as $message){
				mc_display_message($message);
			}

			echo '<input type="hidden" id="chat-timestamp-'.$receive_id.'" value="'.$message['timestamp'].'" />';
			echo '<div class="clearfix"></div>';
		}

	}catch(PDOException $e){
		//error_log($e->getMessage(), 0);
	}
}

/**
 * Display a single chat message. 
 * 
 * @param array $message an array of the message retrieved from the DB
 */
function mc_display_message($message = array()){

	if( ! empty($message['timestamp']) ){
		$timestamp = date( "F j, Y, g:i a", strtotime($message['timestamp']));

		if($message['send_id'] === $_SESSION['user_id']){
			//Sent message
			$type = 'send';
			$character_name = 'You';
		}else{
			$type = 'receive';
			$character_name = $message['send_name'];
		}

		$content = $message['content'];
	}else{
		$timestamp = '<%timestamp%>';
		$type = '<%type%>';
		$character_name = '<%character_name%>';
		$content = '<%content%>';
	}

	echo '<div class="chat-message '.$type.'-chat">
				'.$content.'
				<span class="chat-info">'.$character_name.' &bull; <span class="timestamp">'.$timestamp.'</span></span>
			</div>';
}

/**
 * Display a chat form
 * 
 * @param Party $PARTY The current Party object
 * @param array $receiver An array of the user_id and the receiver name
 */
function mc_display_chat_form($PARTY, $receiver) {
	//<textarea rows="3" class="player-chat" name="player_chat" maxlength="255"></textarea>
	//<button type="submit" class="btn btn-primary submit-chat">Send</button>
	/*
	<button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<span class="sr-only">Actions</span>
	</button>
	<div class="dropdown-menu">
		<a class="dropdown-item" href="#">Action</a>
		<a class="dropdown-item" href="#">Another action</a>
		<a class="dropdown-item" href="#">Something else here</a>
		<div role="separator" class="dropdown-divider"></div>
		<a class="dropdown-item" href="#">Separated link</a>
	</div>
	*/
	echo '<div class="player-form-wrapper">
			<form method="post" action="" class="player-chat-form">
				<div class="input-group">
					<input type="text" class=" player-chat" name="player_chat" placeholder="Message">
					<div class="input-group-append">
						<button type="button" class="btn btn-outline-primary submit-chat">Send</button>
					</div>
				</div>
				<input type="hidden" class="party-id" name="party_id" value="'.$PARTY->party_id.'" />
				<input type="hidden" class="send-id" name="send_id" value="'.$_SESSION['user_id'].'" />
				<input type="hidden" class="receive-id" name="receive_id" value="'.$receiver['id'].'" />
				<input type="hidden" id="send_name=" class="send-name" name="send_name" value="'.($_SESSION['user_id'] == $PARTY->dm_id?'Game Master':$PARTY->getCharacterNameByUserID($_SESSION['user_id'])).'" />
				<input type="hidden" class="receive-name" name="receive_name" value="'.$receiver['name'].'" />
			</form>
		</div>';
}