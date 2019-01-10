<?php 

?>
<div id="equipment-modal" class="action-modal">
	<div class="action-content">
		<form id="equipment-form" action="" method="post">
			<input type="hidden" name="character_id" value="<?php echo $CHARACTER->character_id; ?>" />
			<input type="hidden" name="user_id" value="<?php echo $CHARACTER->user_id; ?>" />
			<div class="action-title">
				Add Equipment
				<i class="far fa-times-circle action-close"></i>
			</div>
			<div class="action-body">
				
				<table>
					<tr>
						<th>Name</th>
						<td><input type="text" id="equipment-name" name="name" class="form-control" maxlength="30" required/></td>
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
<?php 
	$item = array(
		"name" => '<%name%>',
		"slot" => '<%slot%>',
		"bonus" => '<%bonus%>',
		"stat" => '<%stat%>',
		"desc" => '<%desc%>',
		"object" => '<%object%>'
	);
?>
<script id="equipment-template" type="text/template">
<?php 
	$CHARACTER->displayItem('<%key%>', $item);
?>
</script>