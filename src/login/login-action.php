<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . 'src/auth_token.php';

function redirectToUserHome()
{
    $url = 'http://' . $_SERVER['HTTP_HOST'] . '/src/home/home_user.php';
    header('Location:' . $url);
    exit();
}

function redirectToErrorPage($message)
{
    $url = 'http://' . $_SERVER['HTTP_HOST'] . '/src/error/error_page.php?message=$message';
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