<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="../public/css/register.css" />
    <script defer src="../public/js/registration.js"></script>
    <title>Регистрация</title>
    <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon.png" />
</head>

<body>
    <section class="container">
        <form id="register-form" class="register-form" action="/src/registration_credentials.php" method="post">
            <h1 class="register-text">Регистрация</h1>

            <div class="form-group">
                <input class="input-group" type="email" placeholder="Имейл" name="email" id="email" required />
                <p class="error" id="erroremail"></p>
            </div>

            <div class="form-group">
                <input class="input-group" type="text" placeholder="Никнейм" name="username" id="username" required />
                <p class="error" id="errorusername"></p>
            </div>

            <div class="form-group">
                <input type="password" class="input-group" placeholder="Парола" name="password" id="password" required />
                <p class="error" id="errorpassword"></p>
            </div>

            <div class="form-group">
                <input type="password" class="input-group" placeholder="Потвърди парола" name="repeat_password" id="repeat_password" required />
                <p class="error" id="errorrepeat_password"></p>
            </div>

            <button name="submit" class="btn" id="register-button" type="submit">Регистрация</button>

			<p class="register-under-text">
                Вече имаш профил? <a href="login.php">Влез в профила си</a>
            </p>
			
        </form>
    </section>
</body>

</html>
