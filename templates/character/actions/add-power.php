<?php 

?>
<div id="power-modal" class="action-modal">
	<div class="action-content">
		<form id="power-form" action="" method="post">
			<div class="action-title">
				Add Power
				<i class="fal fa-times-circle action-close"></i>
			</div>
			<div class="action-body">
				
				<input type="hidden" name="character_id" value="<?php echo $CHARACTER->character_id; ?>" />
				<input type="hidden" name="user_id" value="<?php echo $CHARACTER->user_id; ?>" />
				<input type="hidden" name="level" value="1" />
				<table>
					<tr>
						<th>Type</th>
						<td>
							<?php 
								$CHARACTER->displaySelect('types', 'power-type', 'type');
							?>
						</td>
					</tr>
					<tr>
						<th>Name</th>
						<td><input type="text" id="power-name" name="name" class="form-control" maxlength="30" required/></td>
					</tr>
					<tr>
						<th>Damage</th>
						<td>
							<?php 
								$CHARACTER->displaySelect('damage', 'power-damage', 'damage');
							?>
						</td>
					</tr>
					<tr>
						<th>Effect</th>
						<td>
							<?php 
								$CHARACTER->displaySelect('effects', 'power-effect', 'effect');
							?>
						</td>
					</tr>
					<tr>
						<th>Stat</th>
						<td>
							<?php 
								$CHARACTER->displaySelect('combinedstats', 'power-stat', 'stat');
							?>
						</td>
					</tr>
					<tr>
						<th>Duration</th>
						<td>
							<?php 
								$CHARACTER->displaySelect('levels', 'power-duration', 'duration');
							?>
						</td>
					</tr>
					<tr>
						<th>Description</th>
						<td><textarea id="power-desc" name="desc" class="form-control" maxlength="200"></textarea></td>
					</tr>
				</table>
			
			</div>
			<div class="action-footer">
				<!-- <button type="button" class="btn btn-outline-default action-close">Close</button> -->
				<button type="submit" class="btn btn-outline-success">Add</button>
			</div>
		</form>
	</div>
</div>
<!-- when adding a new power we will use this template -->
<?php 
	$power = array(
		"name" => '<%name%>',
		"type" => '<%type%>',
		"damage" => '<%damage%>',
		"effect" => '<%effect%>',
		"object" => '<%object%>'
	);
?>
<script id="power-template" type="text/template">
<?php 
	$CHARACTER->displayPower('<%key%>', $power);
?>
</script>

<!-- <td class="dice roller"><i class="fal fa-dice-d20"></i></td> -->
<!-- <td class="dice mutate"><i class="fal fa-atom"></i></td> -->
<!-- 
<script id="power-template" type="text/template">
	<tr id="power-<%key%>" class="edit-power pointer" data-key="<%key%>" data-object='<%object%>'>
		<th class="type"><i class="fal fa-fw fa-info-circle no-print"></i> <%type%></th>
		<td class="name"><%name%></td>
		<td class="damage"><%damage%></td>
		<td class="effect"><%effect%></td>
	</tr>
</script>
-->