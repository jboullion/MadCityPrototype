<div id="character-modal" class="action-modal">
	<div class="action-content">
		<form id="character-form" action="" method="post">
			<div class="action-title">
				Add Character
				<i class="fal fa-times-circle action-close"></i>
			</div>
			<div class="action-body">
				<input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>" />
				<table>
					<tr>
						<th>Name</th>
						<td><input type="text" id="character-name" name="character_name" class="form-control" maxlength="50" required/></td>
					</tr>
				</table>
			</div>
			<div class="action-footer">
				<!-- <button type="button" class="btn btn-outline-default action-close">Close</button> -->
				<button type="submit" class="btn btn-outline-success">Create</button>
			</div>
		</form>
	</div>
</div>
<!-- when adding a new character we will use this template -->
<script id="character-template" type="text/template">
<?php 
	$character = array(
		'character_id' => '<%character_id%>',
		'character_name' => '<%name%>',
		'character_power_type' => '<%type%>',
		'character_xp' => 0
	);

	jb_display_character($character);
?>
</script>