<?php

function writeTweet($mensaje){
	// require codebird
	require_once('lib/codebird-php-develop/src/codebird.php');
	 
	\Codebird\Codebird::setConsumerKey("dxsTZpoDGiLarcayVVW0GY7j6", "6xOiiN26g0FNgmHfY1mOICsP1rDbswgic99RnJFKqnkPUcj9YQ");
	$cb = \Codebird\Codebird::getInstance();
	$cb->setToken("2966087385-CVhXVdO3m3FUa0sgseB0rJpsDz59Y6I8kfxlESS", "94uHJKB3yz6F2LC0LFdjwEAKYIwxE9oTyI6QQPpw8nXCT");
	 
	$params = array(
	  'status' => $mensaje
	);
	$reply = $cb->statuses_update($params);

}

?>