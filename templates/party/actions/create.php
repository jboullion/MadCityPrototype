<div id="create-party-modal" class="action-modal">
	<div class="action-content">
		<form id="create-party-form" action="" method="post">
			<div class="action-title">
				Create Party
				<i class="far fa-times-circle action-close"></i>
			</div>
			<div class="action-body">
				<input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>" />
				<input type="hidden" name="dm_email" value="<?php echo $_SESSION['email']; ?>" />
				<table>
					<tr>
						<th>Name</th>
						<td><input type="text" id="create-party-name" name="party_name" class="form-control" maxlength="50" required /></td>
					</tr>
					<tr>
						<th>Password</th>
						<td>
							<input type="text" id="create-party-password" name="party_password" maxlength="30" class="form-control" />
							<small class="form-text text-muted">Optional</small>
						</td>
					</tr>
				</table>
			</div>
			<div class="action-footer">
				<button type="submit" class="btn btn-outline-success">Create</button>
			</div>
		</form>
	</div>
</div>
<?php 
/*
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