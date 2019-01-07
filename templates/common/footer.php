<!-- Custom JS -->
<?php 
	if(ENVIRONMENT !== 'dev'){
		echo '<script src="/js/live.js?v='.date('Ymd').'"></script>';
	}else{
		echo '<script src="/js/dev.js?v='.time().'"></script>';
	}
?>

<!-- Google Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nosifer|Roboto:400,700">