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