<div id="party-log" class="col-12">
	<h2>Party Log</h2>
	
	<?php 
	echo '<div id="player-log">
			'.$PARTY->getProp('log').'
		</div>';

	/**
	 * If this user is the DM of this party then we need to make this area editable
	 * https://ckeditor.com/docs/ckeditor5/latest/builds/guides/integration/installing-plugins.html
	 * https://ckeditor.com/docs/ckeditor5/latest/builds/guides/integration/frameworks/react.html
	 */
	echo '<script>var party_id = '.$PARTY->party_id.';</script>';
	if($PARTY->dm_id !== $_SESSION['user_id']):
	?>
		<script>
			//TODO: This isn't great, but should be fine when we move to react
			var oldData = '';
			setInterval(function(){ 
				$.get( BASE_DIR+"rest/party/get-log", {party_id:party_id}, function( data ) {
					if(oldData !== data){
						$( '#player-log' ).html(data);
						oldData = data;
					}
				});
			}, 5000);
		</script>
	<?php else: ?>
		<script src="/js/ckeditor.11.2.0.js" ></script>
		<script>
			ClassicEditor
			.create( document.querySelector( '#player-log' ),{
				autosave: {
					save( editor ) {
						console.log('Saving');

						$.post( BASE_DIR+"rest/party/log", {party_id:party_id , party_log:editor.getData()}, function( result ) {
							//console.log(result);
						}, 'json');
					}
				},
				mediaEmbed: {
					previewsInData: true
				}
			} )
			.then( editor => {
				//console.log( editor );
			} )
			.catch( error => {
				console.error( error );
			} );
		</script>
	<?php endif; ?>
</div>