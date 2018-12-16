<?php 

?>
<div id="edit-power-modal" class="action-modal">
	<div class="action-content">
		<form id="edit-power-form" action="" method="post">
			<div class="action-title">
				Edit Power
				<i class="fal fa-times-circle action-close"></i>
			</div>
			<div class="action-body">

				<input type="hidden" name="character_id" value="<?php echo $CHARACTER->character_id; ?>" />
				<input type="hidden" name="user_id" value="<?php echo $CHARACTER->user_id; ?>" />
				<input type="hidden" id="edit-power-key" name="power_key" value="" />
				<table>
					<tr>
						<th>Level</th>
						<td><input type="number" id="edit-power-level" name="level" class="form-control number-control" pattern="[0-9]{3}" min="0" max="10" maxlength="1" /></td>
					</tr>
					<tr>
						<th>Type</th>
						<td><input type="text" id="edit-power-type" name="type" class="form-control" /></td>
					</tr>
					<tr>
						<th>Name</th>
						<td><input type="text" id="edit-power-name" name="name" class="form-control" /></td>
					</tr>
					<tr>
						<th>Damage</th>
						<td><input type="number" id="edit-power-damage" name="damage" class="form-control number-control" pattern="[0-9]{3}" min="0" max="100" maxlength="3" /></td>
					</tr>
					<tr>
						<th>Effect</th>
						<td><input type="text" id="edit-power-effect" name="effect" class="form-control" /></td>
					</tr>
					<tr>
						<th>Description</th>
						<td><textarea id="edit-power-desc" name="desc" class="form-control" maxlength="200"></textarea></td>
					</tr>
				</table>

			</div>
			<div class="action-footer">
				<button type="button" class="btn btn-outline-danger float-left" id="delete-power">Delete</button>
				<!--  <button type="button" class="btn btn-outline-default action-close">Close</button> -->				
				<button type="submit" class="btn btn-outline-success">Edit</button>
			</div>
		</form>
	</div>
</div>