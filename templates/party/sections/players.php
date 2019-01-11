<div id="party-players" class="col-12">
	<h2 class="text-center">Players</h2>

	<?php $PARTY->displayPlayers(); ?>

	<?php if($PARTY->dm_id == $_SESSION['user_id']): ?>
		<button id="add-player" class="btn btn-default no-print w-100"><i class="far fa-plus"></i> Add Player</button>
	<?php endif; ?>
</div>