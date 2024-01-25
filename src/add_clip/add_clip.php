<?php
$active = "add-clip";
include '../header.php';

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
    <title>Добави отрязък</title>
    <link rel="icon" type="image/png" sizes="32x32" href="../../img/favicon.png">
</head>

<body>
    <p id="user-message">
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
        }
        unset($_SESSION['msg']);
        ?>
    </p>
    <form id="add-clip-form" class="add-clip-form" action="./add_clip_action.php" method="post"
        enctype="multipart/form-data">
        <h1>Добави отрязък</h1>

        <input placeholder="Име" name="name" required>
        <input placeholder="Описание" name="description">

        <!-- TODO Tsvetelin : Print from the transformers array -->
        <label for="res_type">Поддържани трансформатори:</label>
        <select id="res_type" name="res_type">
            <option value="html">HTML</option>
            <option value="php">PHP</option>
            <option value="js">JavaScript</option>
            <option value="link">Link</option>

            <option value="other">Other</option>
        </select>

        <input placeholder="Твоят отрязък тук" name="clip_content" required>

        <label for="myCheckbox">Личен</label>
        <input type="checkbox" name="private">
        <!-- TODO Tsvetelin : input file -->

        <button class="btn" id="save-button" type="submit" name="save">Качи</button>

    </form>
</body>

</html>