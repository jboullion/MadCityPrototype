<?php

// functions used throuhgout the site
require_once('includes/functions.php');

// All Classes loaded here
require_once('includes/classes.php');

// Database connection 
require_once('includes/setup.php');
?>
<!doctype html>
<html lang="en">
	<?php require_once('templates/common/header.php'); ?>
	<body>
		<?php require_once('templates/common/navigation.php'); ?>
		<?php 
			// TODO: set this to check for a Character object. A Character object will only be set if we found a character for this ID
			if(! empty($_GET['id'])){
				require_once('templates/character/sheet.php');
			}else{
				require_once('templates/character/list.php');
			}

		?>
		<?php require_once('templates/character/actions/actions.php'); ?>
		<?php require_once('templates/common/footer.php'); ?>
	</body>
</html>