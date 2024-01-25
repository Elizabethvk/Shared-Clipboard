<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/config/config.php';

session_start();
if ($config['auth']['disable_auth']) {
	$_SESSION['logged_in'] = true;
	$_SESSION['user_id'] = 1;
}

if ($_SESSION['user']) {
	// user is authenticated
	header('Location: src/home/home_user.php');
} else {
	// user is not authenticated
	header('Location: src/login/login.html');
}
?>