<?php 
	function mc_display_chat($party_id, $send_id, $receive_id){
		global $PDO;

		try{
			//Could not get bind params to work on this query for some reason
			$select = "SELECT * FROM chat 
						WHERE ( receive_id = ? AND send_id = ? )
							OR ( receive_id = ? AND send_id = ? )
							AND party_id = ?";

			$stmt = $PDO->prepare($select);
			$stmt->execute( 
				array( $send_id, $receive_id, $receive_id, $send_id, $party_id	)
			);

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
			}else{
				$type = 'receive';
			}

			$character_name = $message['send_name'];
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

	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a class="nav-link" href="#chat-party">Party</a>
		</li>
		<?php 
			if(! empty($PARTY->players)){
				foreach($PARTY->players as $key => $player){

					//No talking to yourself
					if($_SESSION['user_id'] === $player['user_id']) continue;

					echo '<li class="nav-item '.($key===0?'active':'').'">
								<a class="nav-link" href="#chat-player-'.$key.'">'.$player['character_name'].'</a>	
							</li>';
				}
			}
		?>
	</ul>

	<div class="tab-content chat-panel">
		<div id="chat-party" class="tab-pane"></div>

		<?php 
			if(! empty($PARTY->players)){
				foreach($PARTY->players as $key => $player){

					//No talking to yourself
					if($_SESSION['user_id'] === $player['user_id']) continue;

					echo '<div id="chat-player-'.$key.'" class="tab-pane '.($key===0?'fade in active':'').'">
						<div class="chat-wrapper">';
					
					mc_display_chat( $PARTY->party_id, $_SESSION['user_id'], $player['user_id']);

					echo '</div>
						<form method="post" action="" class="player-chat-form">
							<textarea rows="3" class="player-chat" name="player_chat" class="form-control" maxlength="255"></textarea>
							<input type="hidden" class="party-id" name="party_id" value="'.$PARTY->party_id.'" />
							<input type="hidden" class="send-id" name="send_id" value="'.$_SESSION['user_id'].'" />
							<input type="hidden" class="receive-id" name="receive_id" value="'.$player['user_id'].'" />
							<button class="btn btn-primary submit-chat">Send</button>
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