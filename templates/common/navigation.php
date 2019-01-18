<div id="left-nav" class="">
	<h1>Mad City</h1>
	<?php
		/*
		<div id="user-info">
			<a href="#" onclick="jbSignOut(event, '<?php echo $_SESSION['email']; ?>');" class="btn btn-default">Sign out</a>
		</div>

		<div class="menu-toggle d-print-none">
			<i class="far fa-ellipsis-v"></i>
		</div>
		*/
	?>

	<div id="players">
		<div id="player-list-target" class="">
			<?php 
				if(! empty($PARTY->players)){
					foreach($PARTY->players as $player){
						//No talking to yourself
						if($_SESSION['user_id'] == $player['user_id']) continue;

						$player_name = $player['user_id'] !== $PARTY->dm_id?'<i class="far fa-shield"></i> '.$player['character_name']:'<i class="far fa-crown"></i> Game Master';
						
						echo '<div href="#" id="player-'.$player['user_id'].'" class="player">
								<div class="w-100">
									<h5 class="mb-1">'.$player_name.'</h5>
									<small>'.$player['user_name'].'</small>
								</div>
							</div>';
					}
				}
			?>
		</div>

		<?php if($PARTY->dm_id == $_SESSION['user_id']): ?>
			<button id="add-player" class="btn btn-primary no-print w-100"><i class="far fa-plus"></i> Add Player</button>
		<?php endif; ?>
	</div>
</div>
<?php //require_once('menu.php'); 