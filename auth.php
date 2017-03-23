<?php 
	$username = "rock";
	$password = 'roll';

	if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) || ($_SERVER['PHP_AUTH_USER'] <> $username) || ($_SERVER['PHP_AUTH_PW'] <> $password)) {
		header('HTTP/1.1 401 Unauthorized');
		header('WWW-Authenticate: Basic realm = "Guitar Wars"');
		exit('Sorry, you are not authorized to access this page. Pleae insert appropriate username and password for viewing this page.');
	}

 ?>