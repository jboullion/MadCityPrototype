<div id="remove-player-modal" class="action-modal">
	<div class="action-content">
		<form id="remove-player-form" action="" method="post">
			<div class="action-title">
				Remove Player?
				<i class="far fa-times-circle action-close"></i>
			</div>
			<div class="action-body">
				<input type="hidden" id="remove-player-id" name="user_id" value="" />
				<input type="hidden" id="remove-party-id" name="party_id" value="<?php echo $PARTY->party_id; ?>" />
				<h5>Are you sure you want to remove this player?</h5>
			</div>
			<div class="action-footer">
				<button type="submit" class="btn btn-outline-danger float-left" id="remove-player">Remove</button>
				<button type="button" class="btn btn-outline-default action-close">Close</button>
			</div>
		</form>
	</div>
</div>
