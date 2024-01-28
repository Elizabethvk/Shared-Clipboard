<?php
require_once dirname(__FILE__) . '/../Db.php';
require_once dirname(__FILE__) . '/../auth_token.php';
require_once dirname(__FILE__) . '/../config/config.php';

function redirectToUserHome()
{
    global $config;
    $url = $config['host']['url'] . '/src/home/home_user.php';
    header('Location:' . $url);
    exit();
}

function redirectToErrorPage($message)
{
    global $config;
    $url = $config['host']['url'] . '/src/error/error_page.php?message=$message';
    header('Location:' . $url);
}

function redirectToPreviousPage()
{
    $previousPage = $_SERVER['HTTP_REFERER'];
    header("Location: $previousPage");
}

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'], $_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $db->getUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            sessionHandler($user);

            redirectToUserHome();
        } else {
            $_SESSION["errormsg"] = 'Невалиден имейл/парола!';
            redirectToPreviousPage();
            exit();
        }
    } else {
        $_SESSION["errormsg"] = 'Моля, попълнете липсващите полета!';
        redirectToPreviousPage();
    }
}
?>