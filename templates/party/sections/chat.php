<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/chat-functions.php'); ?>
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
								<a class="nav-link" href="#chat-'.$player['user_id'].'" data-id="'.$player['user_id'].'">'.$player['character_name'].'</a>	
							</li>';
				}
			}
		?>
	</ul>

	<div class="tab-content chat-panel">
		<div id="chat-0" class="tab-pane active">
			<div class="chat-wrapper" data-id="0">
				<?php mc_display_chat( $PARTY->party_id, $_SESSION['user_id'], 0); ?>
			</div>
			<form method="post" action="" class="player-chat-form">
				<textarea rows="3" class="player-chat" name="player_chat" class="form-control" maxlength="255"></textarea>
				<input type="hidden" class="party-id" name="party_id" value="<?php echo $PARTY->party_id; ?>" />
				<input type="hidden" class="send-id" name="send_id" value="<?php echo $_SESSION['user_id']; ?>" />
				<input type="hidden" class="receive-id" name="receive_id" value="0" />
				<input type="hidden" id="send_name=" class="send-name" name="send_name" value="<?php echo $_SESSION['user_id'] == $PARTY->dm_id?'Game Master':$PARTY->getCharacterNameByUserID($_SESSION['user_id']); ?>" />
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
						<div class="chat-wrapper"  data-id="'.$player['user_id'].'">';
					
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
var conn = new WebSocket('ws://localhost:8080');
conn.onopen = function(e) {
	//console.log("Connection established!");

	//we are connecting to this party's chat stream.
	chatSubscribe(<?php echo $PARTY->party_id;?>);
};



function chatSubscribe(channel) {
	conn.send(JSON.stringify({command: "subscribe", channel: channel}));
}

function chatSendMessage(data) {
	//console.log({command: "message", message: data});
	conn.send(JSON.stringify({command: "message", message: data}));
}

jQuery(document).ready(function(){
	var $playerChatForm = $('.player-chat-form');
	var character_name = $('#send_name').val();

	$playerChatForm.on("submit", function(event){
		event.preventDefault();

		var dataObject = $(this).serializeObject();
		var date = new Date();

		dataObject.timestamp = date.toMysqlFormat();
		dataObject.character_name = character_name;

		chatSendMessage(JSON.stringify(dataObject))

		//websocket.send(JSON.stringify(messageJSON));
		//conn.send(JSON.stringify(dataObject));
	});

	//What do we do with a message from the server?
	conn.onmessage = function(e) {
		//console.log(e.data);
	};
});
</script>
<script>  
	// function showMessage(messageHTML) {
	// 	$('#chat-0').append(messageHTML);
	// }

	// $(document).ready(function(){
	// 	var $playerChatForm = $('.player-chat-form');
	// 	var character_name = $('#send_name').val();

	// 	var websocket = new WebSocket("ws://madcity.local:8090/chat/php-socket.php"); 
	// 	websocket.onopen = function(event) { 
	// 		showMessage("<div class='chat-connection-ack'>Connection is established!</div>");		
	// 	}

	// 	websocket.onmessage = function(event) {
	// 		var Data = JSON.parse(event.data);
	// 		showMessage("<div class='"+Data.message_type+"'>"+Data.message+"</div>");
	// 		$('#chat-message').val('');
	// 	};

	// 	websocket.onerror = function(event){
	// 		showMessage("<div class='error'>Problem due to some Error</div>");
	// 	};

	// 	websocket.onclose = function(event){
	// 		showMessage("<div class='chat-connection-ack'>Connection Closed</div>");
	// 	};
		
	// 	$playerChatForm.on("submit", function(event){
	// 		event.preventDefault();

	// 		var dataObject = $(this).serializeObject();
	// 		var date = new Date();
	// 		var send_name = $()
	// 		var messageJSON = {
	// 			chat_user: character_name,
	// 			chat_message: dataObject.player_chat,
	// 			timestamp: date.toMysqlFormat()
	// 		};
	// 		websocket.send(JSON.stringify(messageJSON));
	// 	});
	// });
</script>

<script>
	// var host = 'ws://madcity.local:8090/chat/websockets.php';
	// var socket = new WebSocket(host);
	// socket.onmessage = function(e) {
	// 	document.getElementById('chat-0').innerHTML = e.data;
	// };
</script>

<!-- Socket.io to communicate chat -->
<!--
<script src="/js/socket.io.js" ></script>
<script>
	var socket = io('http://madcity.local/');
</script>
		-->