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
function jb_display_number_group($name, $value){
	echo '<div class="form-group">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text" id="'.$name.'-label">'.ucwords($name).'</span>
				</div>
				<input type="number" class="form-control number-control" id="'.$name.'" value="'.$value.'" aria-describedby="'.$name.'-label" pattern="[0-9]{3}" min="0" max="999" maxlength="3">
				<div class="input-group-append d-print-none">
					<span class="input-group-text">+</span>
					<span class="input-group-text">-</span>
				</div>
			</div>
		</div>';
}