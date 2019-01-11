<div id="add-player-modal" class="action-modal">
	<div class="action-content">
		<form id="add-player-form" action="" method="post">
			<div class="action-title">
				Add Player
				<i class="far fa-times-circle action-close"></i>
			</div>
			<div class="action-body">
				<input type="hidden" id="add-player-party-id" name="party_id" value="<?php echo $PARTY->party_id; ?>" />
				<input type="hidden" id="add-player-user-id" name="user_id" value="<?php echo $_SESSION['user_id']; ?>" />
				<table>
					<tr>
						<th>Search</th>
						<td>
							<input type="text" id="add-player-search" name="player_search" class="form-control" required/>
							<small class="form-text text-muted">Search by Character Name</small>
						</td>
					</tr>
				</table>
				<ul id="add-player-search-target" class="list-group">
				</ul>
			</div>
			<div class="action-footer">
				<button type="button" class="btn btn-outline-default action-close">Close</button>
			</div>
		</form>
	</div>
</div>
<script id="player-search-template" type="text/template">
	<li class="list-group-item"><%character_name%> <button type="button" onclick="addPlayer(this)" class="btn btn-outline-success add-user-to-party float-right" data-id="<%character_id%>" data-user="<%user_id%>" >Add</button></li>
</script>
<script id="player-template" type="text/template">
<?php 
	$party = array(
		'party_id' => '<%party_id%>',
		'user_id' => '<%user_id%>',
		'user_name' => '<%user_name%>',
		'user_email' => '<%user_email%>',
		'character_name' => '<%character_name%>'
	);

	$PARTY->displayPlayer($party, true);
?>
</script>
