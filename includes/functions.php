<?php 
/**
 * A variety of functions used throughout the site
 */

/**
 * Display the a stat / skill component
 * 
 * @param string $name The name of the stat or skill
 * @param int $value The value of this stat or skill
 */
function jb_display_number_group($name, $value, $roll = true){
	$id = str_replace(' ', '-', $name);

	echo '<div class="form-group">
			<label for="'.$id.'">'.ucwords($name).'</label>
			<div class="input-group">';
	
	if(! $roll){
		echo '<div class="input-group-prepend d-print-none">
				<span class="input-group-text increment" data-target="'.$id.'"><i class="fas fa-fw fa-plus-square"></i></span>
			</div>';
	}

	echo '	<input type="number" class="form-control number-control" id="'.$id.'" value="'.$value.'" aria-describedby="'.$id.'-label" pattern="[0-9]{3}" min="0" max="999" maxlength="3">
			<div class="input-group-append d-print-none">';
	
	if($roll){
		echo '<span class="input-group-text roller"><i class="fal fa-dice-d20"></i></span>';
	}else{
		echo '
		<span class="input-group-text decrement" data-target="'.$id.'"><i class="fas fa-minus-square"></i></span>';
	}
	
	echo '		</div>
			</div>
		</div>';
}