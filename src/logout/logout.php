<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Db.php';

    $db = new Db();
    $db->removeAuthToken($user_id);
}

session_unset();
session_destroy();
header("Location: /src/login/login.php"); // Redirect to login page
exit();

// ?>