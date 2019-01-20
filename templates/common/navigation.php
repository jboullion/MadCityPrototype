<?php 
	/**
	 * Return a player nav link based on a player array
	 * 
	 * @param array $player An array of player information taked from the DB
	 * @return HTML The HTML string for a player nav link 
	 */
	function get_player_link($player){
		
		return '<div href="#" id="player-'.$player['user_id'].'" class="nav-link player w-100 '.($player['user_id'] === 0?'active':'').'">
				<h5 class="player-name">'.$player['character_name'].'</h5>
			</div>';
	}
?>
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
					$party_player = array(
						'user_id' => 0, 
						'character_name' => 'Party'
					);

					$dm_link = '';
					$player_link = '';
					$other_links = '';

					foreach($PARTY->players as $player){
						//No talking to yourself
						//if($_SESSION['user_id'] == $player['user_id']) continue;

						if($_SESSION['user_id'] == $player['user_id']){
							$player_link = get_player_link($player);
							continue;
						}

						if($player['user_id'] == $PARTY->dm_id){
							$player['character_name'] = '<i class="far fa-crown"></i> Game Master';
							$dm_link = get_player_link($player);
							continue;
						}

						$other_links .= get_player_link($player);
					}

					// Display our link in the appropriate order
					echo get_player_link($party_player);
					echo $dm_link;
					echo $other_links;
					echo $player_link;
				}
			?>
		</div>

		<?php if($PARTY->dm_id == $_SESSION['user_id']): ?>
			<button id="add-player" class="btn btn-primary no-print w-100"><i class="far fa-plus"></i> Add Player</button>
		<?php endif; ?>
	</div>
</div>
<script>
	/*
jQuery(document).ready(function($){
	//TODO: Might setup a different page for all menu options so they are all always in memory
	$firstPage = $('.page.first');
	$secondPage = $('.page.second');

	$navLinks = $('.nav-link');

	$navLinks.click(function(e){
		$firstPage.addClass('turning');
		setTimeout(() => {
			$firstPage.removeClass('turning');
		}, 1000);
		//$firstPage = $secondPage.removeClass('second').addClass('first');
	});
	
});
*/
</script>
