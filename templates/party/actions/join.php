<div id="party-join-modal" class="action-modal">
	<div class="action-content">
		<form id="party-join-form" action="" method="post">
			<div class="action-title">
				Join Party
				<i class="fal fa-times-circle action-close"></i>
			</div>
			<div class="action-body">
				<input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>" />
				<table>
					<tr>
						<th>Search</th>
						<td><input type="text" id="party-search" name="party_search" class="form-control" required/></td>
					</tr>
				</table>
			</div>
			<div class="action-footer">
				<button type="submit" class="btn btn-outline-success">Create</button>
			</div>
		</form>
	</div>
</div>