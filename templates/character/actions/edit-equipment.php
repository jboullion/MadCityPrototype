<?php 

?>
<div id="edit-equipment-modal" class="action-modal">
	<div class="action-content">
		<form id="edit-equipment-form" action="" method="post">
			<div class="action-title">
				Edit Power
				<i class="fal fa-times-circle action-close"></i>
			</div>
			<div class="action-body">

				<input type="hidden" name="character_id" value="<?php echo $CHARACTER->character_id; ?>" />
				<input type="hidden" name="user_id" value="<?php echo $CHARACTER->user_id; ?>" />
				<input type="hidden" id="edit-equipment-key" name="equipment_key" value="" />
				<table>
					<tr>
						<th>Name</th>
						<td><input type="text" id="edit-equipment-name" name="name" class="form-control" /></td>
					</tr>
					<tr>
						<th>Slot</th>
						<td>
							<?php 
								$CHARACTER->displaySelect('slots', 'equipment-slot', 'slot');
							?>
						</td>
					</tr>
					<tr>
						<th>Bonus</th>
						<td>
							<?php 
								$CHARACTER->displaySelect('levels', 'equipment-bonus', 'bonus');
							?>
						</td>
					</tr>
					<tr>
						<th>Stat</th>
						<td>
							<?php 
								$CHARACTER->displaySelect('combinedstats', 'equipment-stat', 'stat');
							?>
						</td>
					</tr>
					<tr>
						<th>Description</th>
						<td><textarea id="edit-equipment-desc" name="desc" class="form-control" maxlength="200"></textarea></td>
					</tr>
				</table>

			</div>
			<div class="action-footer">
				<button type="button" class="btn btn-outline-danger float-left" id="delete-equipment">Delete</button>
				<!--  <button type="button" class="btn btn-outline-default action-close">Close</button> -->				
				<button type="submit" class="btn btn-outline-success">Edit</button>
			</div>
		</form>
	</div>
</div>