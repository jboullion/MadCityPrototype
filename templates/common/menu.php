<div id="menu-shade"></div>
<div id="menu" class="d-print-none">
	<div class="menu-toggle">
		<i class="fal fa-times"></i>
	</div>
	<ul>
		<li><a href="/characters/"><i class="fal fa-fw fa-users"></i> Characters</a></li>
		<li><a href="#"><i class="fal fa-fw fa-users-crown"></i> Party</a></li>
		<li><a href="#"><i class="fal fa-fw fa-books"></i> Rules</a></li>
		<li><a href="#"><i class="fal fa-fw fa-user-circle"></i> Profile</a></li>
		<li><a href="#" onclick="jbSignOut(event, '<?php echo $_SESSION['email']; ?>');"><i class="fal fa-fw fa-sign-out"></i> Sign out</a></li>
	</ul>
</div>