<div id="party-page">
	<div id="chat-0" class="">
		<div class="chat-wrapper" data-id="0">
			<?php mc_display_chat( $PARTY->party_id, $_SESSION['user_id'], $PARTY->receive_id); ?>
		</div>
		<?php mc_display_chat_form($PARTY, array('id' => $PARTY->receive_id, 'name' => 'Party')); ?>
	</div>
</div>
<!-- Moment JS to help with timestamping. May move this to site footer -->
<script src="/js/moment.min.js" ></script>

<script>
var conn = new WebSocket('ws://localhost:8080');
conn.onopen = function(e) {
	//console.log("Connection established!");
	// connect to party chat.
	chatSubscribe(<?php echo $PARTY->party_id;?>);
};

//What do we do with a message
conn.onmessage = function(e) {
	//console.log(e.data);
	var dataObject = JSON.parse(e.data);
	dataObject.type = 'receive';
	mcPasteMessage(dataObject, false);
};
</script>