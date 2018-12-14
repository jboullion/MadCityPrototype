<?php 

?>
<div id="power-modal" class="action-modal">
	<div class="action-content">
		<div class="action-title">
			Add Power
			<i class="fal fa-times-circle action-close"></i>
		</div>
		<div class="action-body">
			<form action="" method="post">
				<table>
					<tr>
						<th>Type</th>
						<td><input type="text" id="power-type" name="power-type" class="form-control" /></td>
					</tr>
					<tr>
						<th>Name</th>
						<td><input type="text" id="power-name" name="power-name" class="form-control" /></td>
					</tr>
					<tr>
						<th>Description</th>
						<td><input type="text" id="power-desc" name="power-desc" class="form-control" /></td>
					</tr>
					<tr>
						<th>Add Effect</th>
						<td>
							<div class="mad-style">
								<select id="power-effect" name="power-effect">
									<?php 
										// when adding a power you only need to show the first level
										foreach($POWER_EFFECTS as $level => $effect){
											if($level > 0) break;
											foreach($effect as $name => $value){
												echo '<option value="'.$value.'">'.$name.': '.$value.'</option>';
											}
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
			<button type="button" class="btn btn-outline-danger action-close">Close</button>
			<button type="button" class="btn btn-outline-success">Mutate</button>
		</div>
	</div>
</div>