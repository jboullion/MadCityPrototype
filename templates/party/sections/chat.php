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

		if(! empty($message['timestamp'])){
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
			$type = 'send';
			$character_name = 'You';
			$content = '<%content%>';
		}

		echo '<div class="chat-message '.$type.'-chat">
					'.$content.'
					<span class="chat-info">'.$character_name.' &bull; <span class="timestamp">'.$timestamp.'</span></span>
				</div>';
	}


?>
<div id="party-chat" class="col-12">
	<h2>Chat</h2>

	<ul id="chat-nav" class="nav nav-tabs">
		<li class="nav-item active">
			<a class="nav-link" href="#chat-0">Party</a>
		</li>
		<?php 
			if(! empty($PARTY->players)){
				foreach($PARTY->players as $key => $player){

					//No talking to yourself
					if($_SESSION['user_id'] === $player['user_id']) continue;

					echo '<li class="nav-item">
								<a class="nav-link" href="#chat-'.$player['user_id'].'">'.$player['character_name'].'</a>	
							</li>';
				}
			}
		?>
	</ul>

	<div class="tab-content chat-panel">
		<div id="chat-0" class="tab-pane active">
			<div class="chat-wrapper">
				<?php mc_display_chat( $PARTY->party_id, $_SESSION['user_id'], 0); ?>
			</div>
			<form method="post" action="" class="player-chat-form">
				<textarea rows="3" class="player-chat" name="player_chat" class="form-control" maxlength="255"></textarea>
				<input type="hidden" class="party-id" name="party_id" value="<?php echo $PARTY->party_id; ?>" />
				<input type="hidden" class="send-id" name="send_id" value="<?php echo $_SESSION['user_id']; ?>" />
				<input type="hidden" class="receive-id" name="receive_id" value="0" />
				<input type="hidden" class="send-name" name="send_name" value="<?php echo $_SESSION['user_id'] == $PARTY->dm_id?'Game Master':$PARTY->getCharacterNameByUserID($_SESSION['user_id']); ?>" />
				<input type="hidden" class="receive-name" name="receive_name" value="Party" />
				<button type="submit" class="btn btn-primary submit-chat">Send</button>
			</form>
		</div>

		<?php 
			if(! empty($PARTY->players)){
				foreach($PARTY->players as $key => $player){

					//No talking to yourself
					if($_SESSION['user_id'] === $player['user_id']) continue;

					echo '<div id="chat-'.$player['user_id'].'" class="tab-pane">
						<div class="chat-wrapper">';
					
					mc_display_chat( $PARTY->party_id, $_SESSION['user_id'], $player['user_id']);

					echo '</div>
						<form method="post" action="" class="player-chat-form">
							<textarea rows="3" class="player-chat" name="player_chat" class="form-control" maxlength="255"></textarea>
							<input type="hidden" class="party-id" name="party_id" value="'.$PARTY->party_id.'" />
							<input type="hidden" class="send-id" name="send_id" value="'.$_SESSION['user_id'].'" />
							<input type="hidden" class="receive-id" name="receive_id" value="'.$player['user_id'].'" />
							<input type="hidden" class="send-name" name="send_name" value="'.$PARTY->getCharacterNameByUserID($_SESSION['user_id']).'" />
							<input type="hidden" class="receive-name" name="receive_name" value="'.$player['character_name'].'" />
							<button type="submit" class="btn btn-primary submit-chat">Send</button>
						</form>
					</div>';
				}
			}
		?>
	</div>
</div>
<script id="chat-template" type="text/template">
<?php 
	mc_display_message();
?>
</script>
<!-- Moment JS to help with timestamping. May move this to site footer -->
<script src="/js/moment.min.js" ></script>

<script>
	//TODO: This isn't great, but should be fine when we move to react
	var oldData = '';
	setInterval(function(){ 
		$.get( BASE_DIR+"api/party/get-chat", {party_id:party_id, user_id:user_id}, function( data ) {
			if(data){
				//updateChat(data);
			}
		});
	}, 5000);

	/*
	function updateChat(data){
		Object.keys(obj).forEach(function(key,index) {
			$chatWindows = $('.chat-'+key+' .chat-wrapper');
			// key: the name of the object key
			// index: the ordinal position of the key within the object 
		});
		$chatWindows.each(function(i){
			
			$('#chat-party')
		});
	}
	*/
</script>