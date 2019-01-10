<div id="edit-party-modal" class="action-modal">
	<div class="action-content">
		<form id="edit-party-form" action="" method="post">
			<div class="action-title">
				Edit Party
				<i class="far fa-times-circle action-close"></i>
			</div>
			<div class="action-body">
				<input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>" />
				<input type="hidden" id="edit-party-id" name="party_id" value="" />
				<table>
					<tr>
						<th>Name</th>
						<td><input type="text" id="edit-party-name" name="party_name" class="form-control" maxlength="50" required /></td>
					</tr>
				</table>
			</div>
			<div class="action-footer">
				<button type="button" class="btn btn-outline-danger float-left" id="delete-party">Delete</button>
				<button type="submit" class="btn btn-outline-success">Edit</button>
			</div>
		</form>
	</div>
</div>
<?php 
/*

<tr>
	<th>Passphrase</th>
	<td>
		<input type="text" id="edit-party-password" name="party_password" maxlength="30" class="form-control" />
		<small class="form-text text-muted">Leave blank to keep</small>
	</td>
</tr>


// If you want to list users in the edit panel. I think we will remove users on the single party page instead
<script id="party-user-template" type="text/template">
	<div class="form-check">
		<input class="form-check-input position-static" type="checkbox" id="party-user-<%user_id%>" name="party_users[]" value="<%user_id%>" checked="checked" />
		<label class="form-check-label" for="party-user-<%user_id%>">
			<%user_email%>
		</label>
	</div>
</script>

<tr>
<th>Users</th>
<td id="edit-party-users">

</td>
</tr>


<tr>
	<th>Next Session</th>
	<td>
		<input type="date" />
	</td>
</tr>
<tr>
	<th>Description</th>
	<td>
		<textarea id="edit-party-description" name="party_description" maxlength="300"></textarea>
	</td>
</tr>
*/