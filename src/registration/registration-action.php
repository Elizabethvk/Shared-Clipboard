<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/auth_token.php';

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
    if (isset($_POST['email'], $_POST['username'], $_POST['password'], $_POST['repeat_password'])) {
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $repeatPassword = $_POST['repeat_password'];

        $existingUser = $db->getUserByEmail($email);
        if ($existingUser) {
            $_SESSION["errormsgemail"] = 'Вече съществува потребител с такъв имейл адрес!';
            redirectToPreviousPage();
            exit();
        }

        $existingUsername = $db->getUserByUsername($username);
        if ($existingUsername) {
            $_SESSION["errormsgusername"] = 'Вече съществува потребител с такъв никнейм!';
            redirectToPreviousPage();
            exit();
        }

        // Insert new user into the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $db->storeUser($email, $username, $hashedPassword, false);

        $createdUser = $db->getUserByEmail($email);

        sessionHandler($createdUser);

        redirectToPreviousPage();
    } else {
        // Missing filled in information
        $_SESSION["errormsg"] = 'Моля, попълнете липсващите полета!';
        redirectToPreviousPage();
    }
}

?>