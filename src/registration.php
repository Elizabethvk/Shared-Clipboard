<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- <script defer src="js/register.js"></script> -->
    <link rel="stylesheet" type="text/css" href="../public/css/register.css" />

    <title>Регистрация</title>
    <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon.png" />
</head>

<body>
    <section class="container">
        <form id="register-form" class="register-form" action="/src/registration_credentials.php" method="post">
            <h1 class="register-text">Регистрация</h1>

            <div class="form-group">
                <input class="input-group" type="email" placeholder="Имейл" name="email" required />
                <p class="error" id="erroremail">
                    <?php
                    if (isset($errors['email'])) {
                        echo $errors['email'];
                    }
                    ?>
                </p>
            </div>

            <div class="form-group">
                <input class="input-group" type="text" placeholder="Никнейм" name="username" required />
                <p class="error" id="errorusername">
                    <?php
                    if (isset($errors['username'])) {
                        echo $errors['username'];
                    }
                    ?>
                </p>
            </div>

            <div class="form-group">
                <input type="password" class="input-group" placeholder="Парола" name="password" required />
            </div>

            <div class="form-group">
                <input type="password" class="input-group" placeholder="Потвърди парола" name="repeat_password" required />
                <p class="error" id="errorrepeat_password">
                    <?php
                    if (isset($errors['repeat_password'])) {
                        echo $errors['repeat_password'];
                    }
                    ?>
                </p>
            </div>

            <button name="submit" class="btn" id="register-button" type="submit">Регистрация</button>

            <p class="register-under-text">
                Вече имаш профил? <a href="login.php">Влез в профила си</a>
            </p>

            <div class="form-item hide" id="response-message"></div>
        </form>
    </section>
</body>

</html>
