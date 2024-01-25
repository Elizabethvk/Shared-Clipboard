<?php
$active = "profile";
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

    <title>Профил</title>
    <link href="./profile.css" rel="stylesheet">
    <script src="./profile.js"></script>
    <link rel="icon" type="image/ico" sizes="32x32" href="../../img/favicon.ico">
</head>

<body>
    <!-- <p id="user-message">
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
        }
        unset($_SESSION['msg']);
        ?>
    </p> -->

    <div>
        <label for="search">Търсене по никнейм:</label>
        <input type="text" id="search" placeholder="Никнейм">
        <button onclick="searchUsers()">Търси</button>
    </div>

    <div id="results"></div>

    <div id="error"></div>

</body>

</html>