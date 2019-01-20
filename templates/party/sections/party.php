<div id="party-page">
	<div id="chat-0" class="tab-pane active">
		<div class="chat-wrapper" data-id="0">
			<?php mc_display_chat( $PARTY->party_id, $_SESSION['user_id'], 0); ?>
		</div>
		<?php mc_display_chat_form($PARTY, array('id' => 0, 'name' => 'Party')); ?>
	</div>
</div>