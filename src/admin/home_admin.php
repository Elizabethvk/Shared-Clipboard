<?php
$active = "admin";
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
<html lang="en">

<head>
    <title>Админ панел</title>
    <link rel="icon" type="image/ico" sizes="32x32" href="../img/favicon.ico">
</head>

<body>
    <form action="./export_action.php" method="post" enctype="multipart/form-data">
        <h1>Експорт</h1>
        <button type="submit" name="exportUsers">Всички потребители</button>
    </form>

    <form action="./import_action.php" method="post" enctype="multipart/form-data">
        <h1>Импорт</h1>
        <input type="file" name="usersFile" id="usersFile">
        <button type="submit" name="importUsers">Всички потребители</button>
    </form>
</body>

</html>