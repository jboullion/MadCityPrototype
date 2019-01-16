<?php 
/**
 * Database connection and secret functions and values.
 * 
 * Important: DO NOT TRACK THIS FILE IN GIT
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if( empty($_SERVER['HTTP_HOST']) || $_SERVER['HTTP_HOST'] == 'madcity.local' || $_SERVER['HTTP_HOST'] == 'localhost'){
	define('ENVIRONMENT', 'dev');

	//set false if you want to disable debug messages
	define('DEBUG', true);

	$host = 'localhost';
}else{
	define('ENVIRONMENT', 'live');
	define('DEBUG', false);

	$host = $_SERVER['HTTP_HOST'];
}

if(DEBUG){
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
}

//Used for various admin / debug purposes
define('ADMIN_EMAIL', 'youremail@gmail.com');

//This is your google client ID for using the Google Sign in service
define('CLIENT_ID', '123456789-this-is-your-client-id.apps.googleusercontent.com');

if(empty( $_SERVER['proto'])){
	$protocol = 'http';
}else{
	$protocol = $_SERVER['proto'];
}
define('BASE_URL', $protocol .'://'.$host);

/**
 * Setup Database Connection / PDO Object
 * 
 * TODO: Do we move this elsewhere? Leaving here provides the one stop for database 
 */
function setup_pdo(){ 
	if(ENVIRONMENT == 'dev'){  
		$host = 'localhost';
		$db   = 'db_name';
		$user = 'db_user';
		$pass = 'db_pass';
	}else{
		$host = 'localhost';
		$db   = 'live_db_name';
		$user = 'live_db_user';
		$pass = 'live_db_pass';
	}

	$charset = 'utf8mb4';

	$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

	class MyPDOStatement extends PDOStatement{
		protected $_debugValues = null;
	
		protected function __construct(){
			// need this empty construct()!
		}
	
		public function execute($values=array()){
			$this->_debugValues = $values;
			try {
				$t = parent::execute($values);
				// maybe do some logging here?
			} catch (PDOException $e) {
				// maybe do some logging here?
				throw $e;
			}
	
			return $t;
		}
	
		public function _debugQuery($replaced=true){
			$q = $this->queryString;
	
			if (!$replaced) {
				return $q;
			}
	
			return preg_replace_callback('/:([0-9a-z_]+)/i', array($this, '_debugReplace'), $q);
		}
	
		protected function _debugReplace($m){
			$v = $this->_debugValues[$m[1]];
			if ($v === null) {
				return "NULL";
			}

			if (!is_numeric($v)) {
				$v = str_replace("'", "''", $v);
			}
	
			return "'". $v ."'";
		}
	}

	$options = [
		PDO::ATTR_ERRMODE 				=> PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE 	=> PDO::FETCH_ASSOC,
		PDO::ATTR_STATEMENT_CLASS 		=> array('MyPDOStatement', array()),
		PDO::ATTR_EMULATE_PREPARES 		=> false, //Attempt to use Native Prepares which are more secure
		//PDO::ATTR_PERSISTENT 			=> true // Our app probably is better off without persistent connections until we need many repeat queries
	];


	try {
		return new PDO($dsn, $user, $pass, $options);
	} catch (\PDOException $e) {
		throw new \PDOException($e->getMessage(), (int)$e->getCode());
	}
}

// Setup Database object
$PDO = setup_pdo();


/**
 * A helper function to send emails using Gmail SMTP servers
 * 
 * TODO: Is it safe to use this with a hard coded password? Move to Google oAuth API eventually.
 *  
 * @link https://www.web-development-blog.com/archives/send-e-mail-messages-via-smtp-with-phpmailer-and-gmail/
 */
function mc_smtpmailer($to, $from, $from_name, $subject, $body) { 
	$mail = new PHPMailer();  // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true;  // authentication enabled
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 465; 
	$mail->Username = ADMIN_EMAIL;
	$mail->Password = 'Password';
	$mail->SetFrom($from, $from_name);
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AddAddress($to);
	if(!$mail->Send()) {
		return array('error' => 'Mail error: '.$mail->ErrorInfo); 
	} else {
		return array('success' => 'Mail Sent'); 
	}
}


