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
    <script defer src="../public/js/login.js"></script>
</head>

<body>
    <section class="container">
        <!-- <form id="login-form" class="login-form" method="post" enctype="multipart/form-data"> -->
        <form id="login-form" class="login-form" method="post">
            <h1 class="login-text">Вход</h1>

            <div class="form-group">
                <input class="input-group" type="email" placeholder="Имейл" name="email" id="email" required />
                <p class="error" id="erroremail"></p>
            </div>

            <div class="form-group">
                <input type="password" class="input-group" placeholder="Парола" name="password" id="password" required />
                <p class="error" id="errorpassword"></p>
            </div>

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