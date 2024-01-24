<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Db.php';

function redirectToUserHome()
{
    header('Location:' . $_SERVER['DOCUMENT_ROOT'] . '/src/home/home_user.php');
}

function redirectToErrorPage($message)
{
    header('Location:' . $_SERVER['DOCUMENT_ROOT'] . "/src/error/error_page.php?message=$message");
}

session_start();
if (!isset($_SESSION['logged_in'])) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$_SESSION['logged_in']) {
        if (isset($_POST['email'], $_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $db->getUserByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $token = bin2hex(random_bytes(32)); // Generate a random token
                $expirationTime = date('Y-m-d H:i:s', strtotime('+24 hours'));

                // Store the token in the database
                $db->storeAuthToken($user['id'], $token, $expirationTime);

                $_SESSION['logged_in'] = true;
                $_SESSION['user'] = $user;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['auth_token'] = $token;

                redirectToUserHome();
            } else {
                redirectToErrorPage('Invalid email or password');
            }
        } else {
            // Missing email or password in the request
            redirectToErrorPage('Invalid request');
        }
    }
} else {
    redirectToUserHome();
}
?>