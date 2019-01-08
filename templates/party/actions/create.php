<div id="party-create-modal" class="action-modal">
	<div class="action-content">
		<form id="party-create-form" action="" method="post">
			<div class="action-title">
				Create Party
				<i class="fal fa-times-circle action-close"></i>
			</div>
			<div class="action-body">
				<input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>" />
				<table>
					<tr>
						<th>Name</th>
						<td><input type="text" id="party-create-name" name="party_name" class="form-control" maxlength="50" required /></td>
					</tr>
					<tr>
						<th>Password</th>
						<td>
							<input type="text" id="party-create-password" name="party_password" maxlength="30" class="form-control" />
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