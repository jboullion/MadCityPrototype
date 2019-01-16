<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/party-functions.php');

	$parties = mc_get_parties($PDO);
?>
<section id="party-list">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="list-group" id="party-list-target">
					<?php 
						if(! empty($parties)){
							foreach($parties as $party){
								mc_display_party($party);
							}
						}
					?>
				</div>
			</div>
		</div>

		<div class="row list-controls">
			<div class="col-12">
				<button class="btn btn-primary w-100" id="create-party"><i class="far fa-scroll-old"></i> Create Party</button>
			</div>
			
		</div>
		<!-- 
			<div class="col-6">
				<button class="btn btn-primary w-100" id="join-party"><i class="far fa-search"></i> Join Party</button>
			</div>
		-->
	</div>
</section>
<!-- when adding a new party we will use this template -->
<script id="party-template" type="text/template">
<?php 
	$party = array(
		'party_id' => '<%party_id%>',
		'party_name' => '<%party_name%>',
		'dm_email' => '<%dm_email%>',
		'next_session' => '',
		'last_online' => ''
	);

	mc_display_party($party, true);
?>
</script>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/party/actions/join.php'); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/party/actions/create.php'); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/party/actions/edit.php'); ?>