<?php

require_once dirname(__FILE__) . '/src/config/config.php';

session_start();
if ($config['auth']['disable_auth']) {
	$_SESSION['logged_in'] = true;
	$_SESSION['user_id'] = 1;
}

if ($_SESSION['logged_in']) {
	// user is authenticated
	header('Location:' . $config['host']['url'] . '/src/home/home_user.php');
} else {
	// user is not authenticated
	header('Location:' . $config['host']['url'] . '/src/login/login.html');
}
?>