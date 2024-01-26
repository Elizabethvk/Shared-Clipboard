<?php
$active = "add-clip";
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
    <meta charset="utf-8">
    <title>Добави отрязък</title>
    <link rel="stylesheet" type="text/css" href="./add_clip.css">
    <link rel="icon" type="image/png" sizes="32x32" href="../../img/favicon.png">
</head>

<body>

    <form id="add-clip-form" class="add-clip-form" action="./add_clip_action.php" method="post"
        enctype="multipart/form-data">

        <h1>Добави отрязък</h1>
        <p id="user-message">
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
            }
            unset($_SESSION['msg']);
            ?>
        </p>

        <input placeholder="Име" name="name" required>
        <input placeholder="Описание" name="description">

        <!-- TODO Tsvetelin : Print from the transformers array -->
        <label for="res_type">Поддържани трансформатори:</label>
        <select id="res_type" name="res_type">
            <option value="auto">Авто</option>
            <option value="text">Текст</option>
            <option value="php">PHP</option>
            <option value="link">Линк</option>
            <option value="bash">bash</option>

            <option value="other">Other</option>
        </select>

        <!-- <div id="clip_content"> -->
        <input placeholder="Твоят отрязък тук" name="clip_content" id="clip-content" required>
        <!-- </div> -->

        <div class="checkbox-container">
            <label for="myCheckbox" id="privacy">Личен</label>
            <input type="checkbox" name="private">
        </div>

        <!-- <label for="myCheckbox" id="privacy">Личен</label> -->
        <!-- <input type="checkbox" name="private"> -->
        <!-- TODO Tsvetelin : input file -->

        <button class="btn" id="save-button" type="submit" name="save">Качи</button>

    </form>
</body>

</html>