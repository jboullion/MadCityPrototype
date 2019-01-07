/**
 * Sign In Function from Google Docs for Google Auth
 * 
 * @link https://developers.google.com/identity/sign-in/web/sign-in
 * @param {*} googleUser The object from the google signin callback
 */
function googleSignIn(googleUser) {
	var profile = googleUser.getBasicProfile();
	var id_token = googleUser.getAuthResponse().id_token;
	var data = {
		email:profile.getEmail(),
		id_token:id_token
	};

	//set a cookie with this token so we can check it at a later time on the server
	jbSetCookie('google-idtoken', id_token, 1);
	jbSetCookie('email', profile.getEmail(), 1);

	//let our server know we are loggin in and redirect to character page
	jbUserFormSend('google-signin', data, $signinForm);

	// console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
	// console.log('Name: ' + profile.getName());
	// console.log('Image URL: ' + profile.getImageUrl());
	// console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.

}

/**
 * Sign Out Function from Google Docs for Google Auth
 * 
 * @link https://developers.google.com/identity/sign-in/web/sign-in
 */
function jbSignOut(e, email) {
	e.preventDefault();
	
	if(gapi.auth2){
		var auth2 = gapi.auth2.getAuthInstance();

		if (auth2.isSignedIn.get()) {
			//var profile = auth2.currentUser.get().getBasicProfile();
	
			auth2.signOut().then(function () {
				jbDeleteSession(email);
			});
		}else{
			jbDeleteSession(email);
		}
	}else{
		jbDeleteSession(email);
	}

}

/**
 * Delete a user's session and inform the server
 * 
 * @param string email Email address of user to log out
 */
function jbDeleteSession(email){
	jbDeleteCookie('google-idtoken');
	jbDeleteCookie('email');

	if(email){
		//disconnect from the server and then redirect to homepage
		jQuery.post( BASE_DIR+"rest/user/logout", {email:email}, function( result ) {
			if(result.success){
				window.location.href = window.location.protocol+"//"+window.location.hostname;
			}else{
				console.log(result);
			}
		});
	}
}

/**
 * We are calling this as the callback from the Google platform
 * 
 * @link https://stackoverflow.com/questions/30945798/html-php-google-single-sign-on-signout-will-throw-cannot-read-property-getauth
 */
function onLoad() {
	gapi.load('auth2', function() {
		gapi.auth2.init();
	});

}


/**
 * Send data to our rest API and respond accordingly
 * 
 * @param string script The name of the script to post to
 * @param object data the object you would like to send to the server 
 * @param jQueryElement $form the form sending the information that will also reciece the error notices
 */
function jbUserFormSend(script, data, $form){
	$.post( BASE_DIR+"rest/user/"+script, data, function( result ) {
		if(result.success){

			//redirect should occur on the server level, until we move to React
			if('forgot-form' == $form[0].id){
				$form.find('.alert-danger').addClass('hidden');
				$form.find('.alert-success').html(result.success).removeClass('hidden');
			}else{
				jbSetCookie('email', data.email, 1);
				window.location.href = window.location.protocol+"//"+window.location.hostname+"/character/";
			}

		}else if(result.error){
			$form.find('.alert-danger').html(result.error).removeClass('hidden');
		}else{
			$form.find('.alert-danger').html('Unknown Error').removeClass('hidden');
		}

		if('forgot-form' == $form[0].id){
			$form.find('.btn-primary').html('Get New Password').prop('disabled', false);
		}
	}, 'json');
}

/**
 * Controls the actions and tracks the data on the character page
 */
jQuery(document).ready(function($){
	$body = $('body');
	$loginForms = $('.login-form');

	$signinForm = $('#signin-form');
	$signinBtns = $('.signin-btn');

	$signupForm = $('#signup-form');
	$signupBtns = $('.signup-btn');

	$forgotForm = $('#forgot-form');
	$forgotBtns = $('.forgot-btn');

	// Submit our character sheet to our update function to save
	$signinForm.submit(function(e){
		e.preventDefault();

		var data = $(this).serializeArray();

		jbUserFormSend('signin', data, $signinForm);

	});

	// Submit our character sheet to our update function to save
	$signupForm.submit(function(e){
		e.preventDefault();

		var data = $(this).serializeArray();

		jbUserFormSend('signup', data, $signinForm);

	});

	// Submit our character sheet to our update function to save
	$forgotForm.submit(function(e){
		e.preventDefault();

		var data = $(this).serializeArray();
		$forgotForm.find('.btn-primary').html('<i class="fal fa-circle-notch fa-spin"></i>').prop('disabled', true);

		jbUserFormSend('forgot', data, $forgotForm);
	});

	$signinBtns.click(function(e){
		$loginForms.removeClass('open');
		$signinForm.addClass('open');
	});

	$signupBtns.click(function(e){
		$loginForms.removeClass('open');
		$signupForm.addClass('open');
	});

	$forgotBtns.click(function(e){
		$loginForms.removeClass('open');
		$forgotForm.addClass('open');
	});

});

