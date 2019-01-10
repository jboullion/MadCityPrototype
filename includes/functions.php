<?php 


/**
 * Debug function display cleaner information
 * 
 * @param mixed $data Any PHP variable you want to debug
 */
function mc_print($data){
	echo '<pre class="jb-print">'.print_r($data, true).'</pre>';
}


/**
 * Send a user to a specific location
 * 
 * @param string $url the URL of the redirect
 * @param bool $permanent 301 vs 302 redirect
 */
function mc_redirect($url, $permanent = false){
	header('Location: ' . $url, true, $permanent ? 301 : 302);
	exit();
}


/**
 * Generate a random password
 * 
 * @param int $length The length of the random password
 */
function mc_random_password( $length = 8 ) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*?";
	return substr( str_shuffle( $chars ), 0, $length );
}


/**
 * Return an array of user information
 * 
 * @param PDO $PDO PDO Object
 * @param int $user_id The user ID of the user info to get
 * @param return $user object 
 * 
 * TODO: Setup a User Class and return that
 */
function mc_get_user(PDO $PDO, $user_id){
	try{
		$stmt = $PDO->prepare("SELECT `user_id`, `user_email`, `user_is_online`, `user_image`, `user_created` FROM users WHERE user_id = {$user_id} LIMIT 1");
		$stmt->execute();
		return $stmt->fetch();
	}catch(PDOException $e){
		//error_log($e->getMessage(), 0);
	}
	
	return false;
}

/**
 * Get information about a user.
 * 
 * @param int $user_id The ID of the user to get info about
 * @param string $column The column name of the info you want 
 */
function mc_get_userinfo($user_id, $column){
	global $PDO;

	if($column === 'user_password'){
		return $result['error'] = 'Cannot return password';
	}

	$select = "SELECT $column FROM users WHERE user_id = :user_id LIMIT 1";
	$stmt = $PDO->prepare($select);
	$stmt->execute( 
		array(
			'user_id' => $user_id
		)
	);

	$result = $stmt->fetch();

	return $result[$column];

}


/**
 * Log in a user based on their Google Credentials
 * 
 * @param PDO $PDO PDO Object
 * @param string $id_token The id token generated by Google
 * @param string $email User email to check
 */
function jbGoogleSignIn(PDO $PDO, $id_token, $email){
	require_once __DIR__.'/../vendor/autoload.php';

	$client = new Google_Client(['client_id' => CLIENT_ID]);
	$payload = $client->verifyIdToken($id_token);
	if ($payload) {
		//Valid ID Token
		//Now try to log in

		//this should not be able to happen. Trust Google.
		if(empty($email)) {
			return json_encode(array('error' => 'Info Missing'));
		}

		//this should not be able to happen. Trust Google.
		if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return json_encode(array('error' => 'Invalid Email'));
		}

		//Does this email Exist already?
		$user = mc_user_exists($PDO, $email);

		// TODO: Should we separate the Google account from other accounts? 
		// Would we allow 2 of the same emails if so?
		// One a google user and one a custom user?
		if(! empty($user)){
			//User Exists, log into it
			$_SESSION['email'] = $_POST['email'];
			$_SESSION['user_id'] = $user['user_id'];
			$_SESSION['party_ids'] = explode(',', $user['party_ids']);
			
			return json_encode(array('success' => 'Sign in Successful'));
		}else{
			//User Doesn't Exist...Sign them up!
			$insert = "INSERT INTO users (user_email, user_google_token, user_is_online) VALUES(:email, :password, 1)";
			$stmt = $PDO->prepare($insert);
			$result = $stmt->execute( 
				array(
					'email' => $email,
					'user_google_token' => $id_token //TODO: Should update this everytime they log in? Not really something we have to track
				)
			);

			if($result){
				$_SESSION['email'] = $email;
				return json_encode(array('success' => 'Google User Created'));
			}else{
				return json_encode(array('error' => 'Couldn\t create the Google User'));
			}
		}

	} else {
		// Invalid ID token
		return json_encode(array('error' => 'Invalid ID token'));
	}
}


/**
 * Check if a user exists
 * 
 * @param PDO $PDO PDO Object
 * @param string $email Check if this email exists
 */
function mc_user_exists(PDO $PDO, $email){
	try{
		$select = "SELECT * FROM users WHERE user_email = :email LIMIT 1";
		$stmt = $PDO->prepare($select);
		$stmt->execute( 
			array(
				'email' => $email
			)
		);
	
		return $stmt->fetch();
	}catch(PDOException $e){
		//error_log($e->getMessage(), 0);
	}
	
	return false;
	
}