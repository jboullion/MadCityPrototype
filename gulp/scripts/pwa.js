var deferredPrompt;
//var addToHomeScreenBtns = document.querySelector('.action-dice');

//Does this browser support service workers?
if('serviceWorker' in navigator){
	
	//register our service worker
	navigator.serviceWorker
		.register('/serviceWorker.js')
		.then(function(){
			//console.log('Service Worker Registered');
		});
}

// Prevent the browser from automatically offering to put the app on the homescreen
window.addEventListener('beforeinstallprompt', function(event){
	//console.log('Before Install');
	event.preventDefault();
	deferredPrompt = event;
	return false;
});

/*
// https://developers.google.com/web/fundamentals/app-install-banners/
if(addToHomeScreenBtns){
	//Prompt the user to add this to their home screen
	addToHomeScreenBtns.addEventListener('click',function(){
		
		if(deferredPrompt){
			deferredPrompt.prompt();

			deferredPrompt.userChoice.then(function(choiceResult){
				console.log(choiceResult);

				if(choiceResult.outcome === 'dismissed'){
					console.log('Cancel add to home screen');
				}else{
					console.log('Add to homescreen');
				}
			});

			deferredPrompt = null;
		}
	});
}
*/
