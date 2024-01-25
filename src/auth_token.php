<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Db.php';

function generateAuthToken()
{
    global $config;
    $token = bin2hex(random_bytes(32));
    $expirationTime = date('Y-m-d H:i:s', strtotime($config['auth']['expiration_time']));

    return [$token, $expirationTime];
}

function storeAuthToken($user) {
    global $config;
    global $db;

    $authArray = generateAuthToken();
    $token = $authArray[0];
    $expirationTime = $authArray[1];

    $db->storeAuthToken($user['id'], $token, $expirationTime);

    return $token;
}

function sessionHandler($user) {
    $token = storeAuthToken($user);

    $_SESSION['logged_in'] = true;
    $_SESSION['user'] = $user;
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['auth_token'] = $token;
}