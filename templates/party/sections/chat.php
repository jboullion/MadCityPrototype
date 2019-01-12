<?php 
	function mc_display_chat($your_id, $other_id){
		global $PDO;

		try{
			//Could not get bind params to work on this query for some reason
			$select = "SELECT * FROM chat 
						WHERE ( receive_id = ? AND send_id = ? )
							OR ( receive_id = ? AND send_id = ? )";

			$stmt = $PDO->prepare($select);
			$stmt->execute( 
				array( $your_id, $other_id, $other_id, $your_id	)
			);

			$chat = $stmt->fetchAll();

			if(! empty($chat)){
				foreach($chat as $message){
					echo '<div class="chat-message '.($message['send_id'] === $_SESSION['user_id']?'your':'other').'-chat">
							'.$message['content'].'
							<span class="chat-info">Hain &bull; '.date( "F j, Y, g:i a", strtotime($message['timestamp'])).'</span>
						</div>';
				}

				echo '<div class="clearfix"></div>';
			}

		}catch(PDOException $e){
			//error_log($e->getMessage(), 0);
		}
	}

	
?>
<div id="party-chat" class="col-12">
	<h2>Chat</h2>

	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a class="nav-link active" href="#">Party</a>
		</li>
		<li class="nav-item dropdown">
			<a class="nav-link" href="#">Player 1</a>	
		</li>
		<li class="nav-item">
			<a class="nav-link" href="#">Player 2</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="#">Game Master</a>
		</li>
	</ul>

	<div class="tab-content chat-panel">
		<div id="home" class="tab-pane fade in active">
			<?php 
				$other_id = 15;
				mc_display_chat(16, $other_id);
			?>
		</div>
		<div id="menu1" class="tab-pane fade">
		</div>
		<div id="menu2" class="tab-pane fade">
		</div>
	</div>
	<form method="post" action="" id="player-chat-form">
		<textarea rows="3" id="player-chat" name="player_chat" class="form-control" maxlength="255"></textarea>
		<button id="submit-chat" class="btn btn-primary">Send</button>
	</form>
</div>