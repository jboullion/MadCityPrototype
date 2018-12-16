<?php 

?>
<div id="equipment-modal" class="action-modal">
	<div class="action-content">
		<form id="equipment-form" action="" method="post">
			<input type="hidden" name="character_id" value="<?php echo $CHARACTER->character_id; ?>" />
			<input type="hidden" name="user_id" value="<?php echo $CHARACTER->user_id; ?>" />
			<div class="action-title">
				Add Equipment
				<i class="fal fa-times-circle action-close"></i>
			</div>
			<div class="action-body">
				
				<table>
					<tr>
						<th>Slot</th>
						<td>
							<div class="mad-style">
								<select id="equipment-slot" name="slot" required>
									<?php 
										foreach($CHARACTER->slots as $slot => $name){
											echo '<option value="'.$name.'">'.$name.'</option>';
										}
									?>
								</select>
							</div>
						</td>
					</tr>
					<tr>
						<th>Name</th>
						<td><input type="text" id="equipment-name" name="name" class="form-control" required/></td>
					</tr>
					<tr>
						<th>Bonus</th>
						<td><input type="number" id="equipment-bonus" name="bonus" class="form-control" required/></td>
					</tr>
					<tr>
						<th>Stat</th>
						<td>
							<div class="mad-style">
								<select id="equipment-stat" name="stat" required>
									<?php 
										$CHARACTER->optionStat('vitals');
										$CHARACTER->optionStat('stats');
										$CHARACTER->optionStat('skills');
									?>
								</select>
							</div>
						</td>
					</tr>
					<tr>
						<th>Description</th>
						<td><textarea id="equipment-desc" name="desc" class="form-control" maxlength="200"></textarea></td>
					</tr>
				</table>
				
			</div>
			<div class="action-footer">
				<!--  <button type="button" class="btn btn-outline-default action-close">Close</button> -->
				<button type="submit" class="btn btn-outline-success">Equip</button>
			</div>
		</form>
	</div>
</div>
<!-- when adding a new power we will use this template -->
<script id="equipment-template" type="text/template">
	<tr id="equipment-<%key%>" data-key="<%key%>" data-object='<%object%>'>
		<th class="slot edit-equipment pointer"><i class="fal fa-fw fa-info-circle no-print"></i> <%slot%></th>
		<td class="name edit-equipment pointer"><%name%></td>
		<td class="bonus" >+<%bonus%> <%stat%></td>
	</tr>
</script>