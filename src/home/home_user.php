<?php
$active = "home";
include $_SERVER['DOCUMENT_ROOT'] . '/src/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/src/footer.php';

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

    <title>Начало</title>
    <!-- <link href="./dynamic-table.css" rel="stylesheet"> -->
    <link href="./home_user.css" rel="stylesheet">
    <script src="./home-user.js"></script>
    <link rel="icon" type="image/ico" sizes="32x32" href="../../img/favicon.ico">
</head>

<body>
    <h1>Начало</h1>
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Db.php';

    function getCurrentUser()
    {
        global $db;
        if (isset($_SESSION["logged_in"]) && $_SESSION['logged_in']) {
            return $db->getUserById($_SESSION['user_id']);
        } else {
            return null;
        }
    }

    $subCnt = $db->getSubscriberCountForUserId(getCurrentUser()['id']);
    echo "Последователи: ";
    echo $subCnt;
    echo "<br>";

    $clipCnt = $db->getClipCntForUserIds(getCurrentUser()['id']);
    echo "Брой отрязъци: ";
    echo $clipCnt;
    echo "<br>";
    ?>
</body>

</html>