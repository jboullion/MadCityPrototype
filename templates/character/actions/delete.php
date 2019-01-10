<div id="delete-character-modal" class="action-modal">
	<div class="action-content">
		<form id="delete-character-form" action="" method="post">
			<div class="action-title">
				Delete Character
				<i class="far fa-times-circle action-close"></i>
			</div>
			<div class="action-body">
				<input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>" />
				<input type="hidden" id="delete-character-id" name="character_id" value="" />
				<table>
					<tr>
						<th>Name</th>
						<td id="delete-character-name"></td>
					</tr>
				</table>
			</div>
			<div class="action-footer">
				<button type="submit" class="btn btn-outline-danger float-left" id="delete-character">Delete</button>
				<button type="button" class="btn btn-outline-default action-close">Cancel</button>
			</div>
		</form>
	</div>
</div>