<?php
session_start();

if (!isset($_POST['user'])) {
    extract($_POST);

    require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Db.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/src/config/config.php';

    $email = $_POST['email'];
    $password = sha1($_POST['password']);

    echo $email, $password;

    // if ($db->isValidLogin($email, $password)) {
    session_start();
    $_SESSION['logged_in'] = true;
    $_SESSION['user'] = $db->getUserByEmail($email);

    //     if ($row['IS_ADMIN']) {
//         header("Location: ../home-admin.php");
//     } else {
//         header("Location: ../home-user.php");
//     }
// }
// else {
//     echo "Invalid Email ID/Password";
// }
    // }
}