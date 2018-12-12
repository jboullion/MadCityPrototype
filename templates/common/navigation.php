<div id="main-navigation" >
	<div id="logo">
		<h1>Mad City</h1>
	</div>

	<div class="menu-toggle d-print-none">
		<i class="fal fa-bars"></i>
	</div>

	<div id="user-info">
		Hello, <?php echo $USER['user_email']; ?>
	</div>
	<div class="clearfix"></div>
</div>

<?php require_once('templates/common/menu.php');