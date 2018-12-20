//TODO: Send a post to /rest/user/signin with either ID of email
//TODO: Set the current user up as this user. IE Show Hello. xxx@domain.com
function googleSignIn(googleUser) {
	var profile = googleUser.getBasicProfile();

	// console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
	// console.log('Name: ' + profile.getName());
	// console.log('Image URL: ' + profile.getImageUrl());
	// console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
	
}

function googleSignOut() {
	var auth2 = gapi.auth2.getAuthInstance();
	auth2.signOut().then(function () {
		console.log('User signed out.');
	});
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

		$.post( BASE_DIR+"rest/user/signin", data, function( result ) {
			if(result.success){
				//redirect should occur on the server level, until we move to React
				window.location.href = window.location.protocol+"//"+window.location.hostname+"/character/";
			}else if(result.error){
				$signinForm.find('.alert-danger').html(result.error).removeClass('hidden');
			}else{
				$signinForm.find('.alert-danger').html('Unknown Error').removeClass('hidden');
			}
		}, 'json');

	});

	// Submit our character sheet to our update function to save
	$signupForm.submit(function(e){
		e.preventDefault();

		var data = $(this).serializeArray();

		$.post( BASE_DIR+"rest/user/signup", data, function( result ) {

			if(result.success){
				//redirect should occur on the server level, until we move to React
				window.location.href = window.location.protocol+"://"+window.location.hostname+"/character/";
			}else if(result.error){
				$signupForm.find('.alert-danger').html(result.error).removeClass('hidden');
			}else{
				$signupForm.find('.alert-danger').html('Unknown Error').removeClass('hidden');
			}
			
		}, 'json');

	});

	// Submit our character sheet to our update function to save
	$forgotForm.submit(function(e){
		e.preventDefault();

		var data = $(this).serializeArray();
		$forgotForm.find('.btn-primary').html('<i class="fal fa-circle-notch fa-spin"></i>').prop('disabled', true);

		$.post( BASE_DIR+"rest/user/forgot", data, function( result ) {
			if(result.success){
				$forgotForm.find('.alert-danger').addClass('hidden');
				$forgotForm.find('.alert-success').html(result.success).removeClass('hidden');
			}else if(result.error){
				$forgotForm.find('.alert-danger').html(result.error).removeClass('hidden');
			}else{
				$forgotForm.find('.alert-danger').html('Unknown Error').removeClass('hidden');
			}
			$forgotForm.find('.btn-primary').html('Get New Password').prop('disabled', false);
		}, 'json');

	});

	$signinBtns.click(function(e){
		console.log('Sign In Form');
		$loginForms.removeClass('open');
		$signinForm.addClass('open');
	});

	$signupBtns.click(function(e){
		console.log('Sign Up Form');
		$loginForms.removeClass('open');
		$signupForm.addClass('open');
	});

	$forgotBtns.click(function(e){
		console.log('Forgot Form');
		$loginForms.removeClass('open');
		$forgotForm.addClass('open');
	});

});

