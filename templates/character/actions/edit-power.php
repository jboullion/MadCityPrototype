<?php 

?>
<div id="edit-power-modal" class="action-modal">
	<div class="action-content">
		<?php echo $CHARACTER->view?'<div id="edit-power-form">':'<form id="edit-power-form" action="" method="post">'; ?>
			<div class="action-title">
				Edit Power
				<i class="far fa-times-circle action-close"></i>
			</div>
			<div class="action-body">

				<input type="hidden" name="character_id" value="<?php echo $CHARACTER->character_id; ?>" />
				<input type="hidden" name="user_id" value="<?php echo $CHARACTER->user_id; ?>" />
				<input type="hidden" id="edit-power-key" name="power_key" value="" />
				<table>
					<tr>
						<th>Name</th>
						<td><input type="text" id="edit-power-name" name="name" class="form-control" maxlength="30" required <?php echo $CHARACTER->disabled(); ?>/></td>
					</tr>
					<tr>
						<th>Type</th>
						<td>
							<?php 
								$CHARACTER->displaySelect('types', 'edit-power-type', 'type');
							?>
						</td>
					</tr>
					<tr>
						<th>Damage</th>
						<td>
							<?php 
								$CHARACTER->displaySelect('damage', 'edit-power-damage', 'damage');
							?>
						</td>
					</tr>
					<tr>
						<th>Effect</th>
						<td>
							<?php 
								$CHARACTER->displaySelect('effects', 'edit-power-effect', 'effect');
							?>
						</td>
					</tr>
					<tr>
						<th>Stat</th>
						<td>
							<?php 
								$CHARACTER->displaySelect('combinedstats', 'edit-power-stat', 'stat');
							?>
						</td>
					</tr>
					<tr>
						<th>Duration</th>
						<td>
							<?php 
								$CHARACTER->displaySelect('levels', 'edit-power-duration', 'duration');
							?>
						</td>
					</tr>
					<tr>
						<th>Description</th>
						<td><textarea id="edit-power-desc" name="desc" class="form-control" maxlength="200" <?php echo $CHARACTER->disabled(); ?>></textarea></td>
					</tr>
				</table>

			</div>
			<div class="action-footer">
				<?php if($CHARACTER->view): ?>
					<button type="button" class="btn btn-outline-default action-close">Close</button>
				<?php else: ?>
					<button type="button" class="btn btn-outline-danger float-left" id="delete-power">Delete</button>
					<button type="submit" class="btn btn-outline-success">Edit</button>
				<?php endif; ?>
			</div>
		<?php echo $CHARACTER->view?'</div>':'</form>'; ?>
	</div>
</div>