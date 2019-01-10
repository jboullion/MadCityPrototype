<div id="join-party-modal" class="action-modal">
	<div class="action-content">
		<form id="join-party-form" action="" method="post">
			<div class="action-title">
				Join Party
				<i class="far fa-times-circle action-close"></i>
			</div>
			<div class="action-body">
				<input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>" />
				<table>
					<tr>
						<th>Search</th>
						<td><input type="text" id="join-party-search" name="party_search" class="form-control" required/></td>
					</tr>
				</table>
				<ul class="list-group">
				</ul>
			</div>
			<div class="action-footer">
				<button type="submit" class="btn btn-outline-success">Create</button>
			</div>
		</form>
	</div>
</div>
<script id="party-join-template" type="text/template">
	<li class="list-group-item join-search-result" data-id="<%party_id%>"><%party_name%></li>
</script>
