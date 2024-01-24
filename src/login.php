<?php
session_start();
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Вход</title>
    <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon.png">
    <link rel="stylesheet" type="text/css" href="../public/css/login.css">
    <!-- <script src="js/login.js" defer></script> -->
</head>
<body>
<section class="container">
    <form id="login-form" class="login-form" action="/src/login_credentials.php" method="post" enctype="multipart/form-data">
        <h1 class="login-text">Вход</h1>
        <input class="input-group" type="email" placeholder="Имейл" name="email" required>
        
        <input class="input-group" type="password" placeholder="Парола" name="password" required>
        
        <button class="btn" id="login-button" type="submit" name="save">Вход</button>
        
        <p id="user-message"></p>
        
        <p class="login-under-text">
            Все още нямаш профил?
            <a href="registration.php">Регистрирай се</a>
        </p>
    </form>
</section>
</body>
</html>
