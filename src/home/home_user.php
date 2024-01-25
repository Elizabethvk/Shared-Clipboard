<?php
$active = "home";
include $_SERVER['DOCUMENT_ROOT'] . '/src/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/src/footer.php';

session_start();

// Check if the user is already logged in
if (!isset($_SESSION['logged_in'])) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/src/login/login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Начало</title>
    <link href="./dynamic-table.css" rel="stylesheet">
    <script src="./home-user.js"></script>
    <link rel="icon" type="image/ico" sizes="32x32" href="../../img/favicon.ico">
</head>

<body>

</body>

</html>