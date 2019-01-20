<div id="party-log">
	<div class="first page">
		<!-- front content -->
		<?php echo $PARTY->getProp('log'); ?>
	</div>
	<div class="second page">
		<!-- back content -->
		<p>My money's in that office, right? If she start giving me some bullshit about it ain't there, and we got to go someplace else and get it, I'm gonna shoot you in the head then and there. Then I'm gonna shoot that bitch in the kneecaps, find out where my goddamn money is. She gonna tell me too. Hey, look at me when I'm talking to you, motherfucker. You listen: we go in there, and that nigga Winston or anybody else is in there, you the first motherfucker to get shot. You understand? </p>

		<p>My money's in that office, right? If she start giving me some bullshit about it ain't there, and we got to go someplace else and get it, I'm gonna shoot you in the head then and there. Then I'm gonna shoot that bitch in the kneecaps, find out where my goddamn money is. She gonna tell me too. Hey, look at me when I'm talking to you, motherfucker. You listen: we go in there, and that nigga Winston or anybody else is in there, you the first motherfucker to get shot. You understand? </p>

		<p>Now that there is the Tec-9, a crappy spray gun from South Miami. This gun is advertised as the most popular gun in American crime. Do you believe that shit? It actually says that in the little book that comes with it: the most popular gun in American crime. Like they're actually proud of that shit.  </p>
	</div>
</div>
<?php 
/*
echo '<div id="party-log">
		'.$PARTY->getProp('log').'
	</div>';
*/
/**
 * If this user is the DM of this party then we need to make this area editable
 * https://ckeditor.com/docs/ckeditor5/latest/builds/guides/integration/installing-plugins.html
 * https://ckeditor.com/docs/ckeditor5/latest/builds/guides/integration/frameworks/react.html
 */
/*
if($PARTY->dm_id !== $_SESSION['user_id']):
?>
	<script>
		//TODO: This isn't great, but should be fine when we move to react
		var oldData = '';
		setInterval(function(){ 
			$.get( BASE_DIR+"api/party/get-log", {party_id:party_id}, function( data ) {
				if(oldData !== data){
					$( '#party-log' ).html(data);
					oldData = data;
				}
			});
		}, 5000);
	</script>
<?php else: ?>
	<script src="/js/ckeditor.11.2.0.js" ></script>
	<script>
		ClassicEditor
		.create( document.querySelector( '#party-log' ),{
			autosave: {
				save( editor ) {

					$.post( BASE_DIR+"api/party/log", {party_id:party_id , party_log:editor.getData()}, function( result ) {
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
<?php endif; */