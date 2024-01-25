<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['logged_in'])) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/src/home/home_user.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Вход</title>
    <link rel="icon" type="image/ico" sizes="32x32" href="../img/favicon.ico">
    <link rel="stylesheet" type="text/css" href="./login.css">
    <script src="./login.js" defer></script>
</head>

<body>
    <section class="container">
        <form id="login-form" class="login-form" action="./login-action.php" method="post"
            enctype="multipart/form-data">
            <h1 class="login-text">Вход</h1>

            <div class="form-group">
                <input class="input-group" type="email" placeholder="Имейл" name="email" id="email" required />
                <p class="error" id="erroremail"></p>
            </div>

            <div class="form-group">
                <input type="password" class="input-group" placeholder="Парола" name="password" id="password"
                    required />
                <p class="error" id="errorpassword"></p>
            </div>

            <p class="error" id="error">
            <?php
                if (isset($_SESSION["errormsg"])) {
                    echo $_SESSION["errormsg"];
                    // session_unset();
                    unset($_SESSION["errormsg"]);
                }
                ?>
            </p>

            <button class="btn" id="login-button" type="submit" name="save">Вход</button>


            <p class="login-under-text">
                Все още нямаш профил?
                <a href="../registration/registration.php">Регистрирай се</a>
            </p>
        </form>
    </section>
</body>

</html>