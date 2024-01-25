<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="../../img/favicon.png">
    <title>Не сме безгрешни, но сме истински</title>
</head>

<body>
    <div class="container">
        <h1>Опа! Грешка.</h1>
        <?php
        $errorMessage = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : 'Няма съобщение за грешка.';
        echo '<p>Съобщение за грешка: ' . $errorMessage . '</p>';
        ?>
    </div>
</body>

</html>