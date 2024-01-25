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
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Регистрация</title>
    <script defer src="./registration.js"></script>
    <link rel="stylesheet" type="text/css" href="./registration.css" />
    <link rel="icon" type="image/ico" sizes="32x32" href="../img/favicon.ico" />
</head>

<body>
    <section class="container">
        <form id="register-form" class="register-form" action="./registration-action.php" method="post"
            enctype="multipart/form-data">
            <h1 class="register-text">Регистрация</h1>

            <div class="form-group">
                <input class="input-group" type="email" placeholder="Имейл" name="email" id="email" required />
                <p class="error" id="erroremail">
                    <?php
                    if (isset($_SESSION["errormsgemail"])) {
                        echo $_SESSION["errormsgemail"];
                        // echo "<p class='alert'>" . $_SESSION["errormsgemail"] . "</p>";
                        // session_unset();
                        unset($_SESSION["errormsgemail"]);
                    }
                    ?>
                </p>
            </div>

            <div class="form-group">
                <input class="input-group" type="text" placeholder="Никнейм" name="username" id="username" required />
                <p class="error" id="errorusername">
                    <?php
                    if (isset($_SESSION["errormsgusername"])) {
                        echo $_SESSION["errormsgusername"];
                        // echo "<p class='alert'>" . $_SESSION["errormsgusername"] . "</p>";
                        // session_unset();
                        unset($_SESSION["errormsgusername"]);
                    }
                    ?>
                </p>
            </div>

            <div class="form-group">
                <input type="password" class="input-group" placeholder="Парола" name="password" id="password"
                    required />
                <p class="error" id="errorpassword"></p>
            </div>

            <div class="form-group">
                <input type="password" class="input-group" placeholder="Потвърди парола" name="repeat_password" id="repeat_password" required />
                <p class="error" id="errorrepeat_password"></p>
            </div>

            <p class="error">
                <?php
                if (isset($_SESSION["errormsg"])) {
                    echo $_SESSION["errormsg"];
                    // session_unset();
                    unset($_SESSION["errormsg"]);
                }
                ?>
            </p>

            <button name="submit" class="btn" id="register-button" type="submit">Регистрация</button>

            <p class="register-under-text">
                Вече имаш профил? <a href="../login/login.php">Влез в профила си</a>
            </p>

        </form>
    </section>
</body>

</html>