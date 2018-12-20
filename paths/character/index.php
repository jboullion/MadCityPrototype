<?php
// functions used throuhgout the site
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php');

// All Classes loaded here
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/classes.php');

// Database connection 
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/setup.php');
?>
<!doctype html>
<html lang="en">
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/common/header.php'); ?>
	<body>
		<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/common/navigation.php'); ?>
		<?php 
			// TODO: set this to check for a Character object. A Character object will only be set if we found a character for this ID
			if(! empty($_GET['id'])){
				require_once($_SERVER['DOCUMENT_ROOT'].'/templates/character/sheet.php');
				require_once($_SERVER['DOCUMENT_ROOT'].'/templates/character/actions/actions.php');
			}else{
				require_once($_SERVER['DOCUMENT_ROOT'].'/templates/character/list.php');
			}
		?>
		<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/common/footer.php'); ?>
	</body>
</html>