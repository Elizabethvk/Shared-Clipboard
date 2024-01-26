<?php
$active = "admin";
include $_SERVER['DOCUMENT_ROOT'] . '/src/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/src/footer.php';

// session_start();

// Check if the user is already logged in
if (!isset($_SESSION['logged_in'])) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/src/login/login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="bg">

<head>
    <title>Админ панел</title>
    <link href="./home_admin.css" rel="stylesheet">
</head>

<body>
    <form action="./export_action.php" method="post" enctype="multipart/form-data">
        <h1>Експорт</h1>
        <button type="submit" name="exportUsers" class="form-change" id="export">Всички потребители</button>
    </form>

    <form action="./import_action.php" method="post" enctype="multipart/form-data">
        <h1>Импорт</h1>
        <input type="file" name="usersFile" id="usersFile" class="form-change"  >
        <button type="submit" name="importUsers" class="form-change"  id="import-submit">Всички потребители</button>
    </form>
</body>

</html>