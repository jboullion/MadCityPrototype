<section id="main-navigation">
	<div class="container">
		<div class="row">
			<div class="col-12">

				<?php if(empty($_SESSION['email'])): //Not logged in ?>
					<div class="text-center">
						<h1>Mad City</h1>
					</div>
				<?php else: ?>
					<div id="logo">
						<h1>Mad City</h1>
					</div>
					<div id="user-info">
						<a href="#" onclick="jbSignOut(event, '<?php echo $_SESSION['email']; ?>');" class="btn btn-default">Sign out</a>
					</div>
				<?php
					/*
						<div class="menu-toggle d-print-none">
							<i class="fal fa-bars"></i>
						</div>
					*/
				?>
				<?php endif; ?>
				
			</div>
		</div>
	</div>
</section>

<?php require_once('menu.php');