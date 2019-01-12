<div id="party-players" class="col-12 col-md-4">
	<h2>Players</h2>

	<?php $PARTY->displayPlayers(); ?>

	<?php if($PARTY->dm_id == $_SESSION['user_id']): ?>
		<button id="add-player" class="btn btn-primary no-print w-100"><i class="far fa-plus"></i> Add Player</button>
	<?php endif; ?>
</div>