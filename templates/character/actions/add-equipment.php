<?php 

?>
<div id="equipment-modal" class="action-modal">
	<div class="action-content">
		<div class="action-title">
			Add Equipment
			<i class="fal fa-times-circle action-close"></i>
		</div>
		<div class="action-body">
			<form id="equipment-form" action="" method="post">
				<input type="hidden" name="character_id" value="<?php echo $CHARACTER->character_id; ?>" />
				<input type="hidden" name="user_id" value="<?php echo $CHARACTER->user_id; ?>" />
				<table>
					<tr>
						<th>Slot</th>
						<td>
							<div class="mad-style">
								<select id="equipment-slot" name="equipment-slot">
									<?php 
										foreach($SLOTS as $slot){
											echo '<option value="'.$slot.'">'.$slot.'</option>';
										}
									?>
								</select>
							</div>
						</td>
					</tr>
					<tr>
						<th>Name</th>
						<td><input type="text" id="equipment-name" name="equipment-name" class="form-control" /></td>
					</tr>
					<tr>
						<th>Description</th>
						<td><input type="text" id="equipment-desc" name="equipment-desc" class="form-control" /></td>
					</tr>
					<tr>
						<th>Bonus</th>
						<td><input type="number" id="equipment-bonus" name="equipment-bonus" class="form-control" /></td>
					</tr>
					<tr>
						<th>Stat</th>
						<td>
							<div class="mad-style">
								<select id="equipment-stat" name="equipment-stat">
									<?php 
										foreach($STATS as $stat_id => $stat){
											echo '<option value="'.$stat_id.'">'.$stat.'</option>';
										}
									?>
								</select>
							</div>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<div class="action-footer">
			<button type="button" class="btn btn-outline-default action-close">Close</button>
			<button type="button" class="btn btn-outline-success">Equip</button>
		</div>
	</div>
</div>