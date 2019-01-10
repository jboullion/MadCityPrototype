<?php 

?>
<div id="edit-equipment-modal" class="action-modal">
	<div class="action-content">
		<?php echo $CHARACTER->view?'<div id="edit-equipment-form">':'<form id="edit-equipment-form" action="" method="post">'; ?>
			<div class="action-title">
				Edit Power
				<i class="far fa-times-circle action-close"></i>
			</div>
			<div class="action-body">

				<?php if(!$CHARACTER->view): ?>
					<input type="hidden" name="character_id" value="<?php echo $CHARACTER->character_id; ?>" />
					<input type="hidden" name="user_id" value="<?php echo $CHARACTER->user_id; ?>" />
					<input type="hidden" id="edit-equipment-key" name="equipment_key" value="" />
				<?php endif; ?>

				<table>
					<tr>
						<th>Name</th>
						<td><input type="text" id="edit-equipment-name" name="name" class="form-control" maxlength="30" <?php echo $CHARACTER->disabled(); ?> /></td>
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
						<td><textarea id="edit-equipment-desc" name="desc" class="form-control" maxlength="200" <?php echo $CHARACTER->disabled(); ?>></textarea></td>
					</tr>
				</table>

			</div>
			<div class="action-footer">
				<?php if($CHARACTER->view): ?>
					<button type="button" class="btn btn-outline-default action-close">Close</button>
				<?php else: ?>
					<button type="button" class="btn btn-outline-danger float-left" id="delete-equipment">Delete</button>
					<button type="submit" class="btn btn-outline-success">Edit</button>
				<?php endif; ?>
			</div>
		
		<?php echo $CHARACTER->view?'</div>':'</form>'; ?>
	</div>
</div>