<?php
$active = "profile";
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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Профил</title>
    <link href="./profile.css" rel="stylesheet">
    <script src="./profile.js"></script>
</head>

<body>
    <h1>Профил</h1>
    
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Db.php';

    $subCnt = $db->getSubscriberCountForUserId(getCurrentUser()['id']);
    $clipCnt = $db->getClipCntForUserIds(getCurrentUser()['id']);
    ?>

    <div class="user-info">
        <p>
            Здравей,
            <?php echo getCurrentUser()['username'] ?>!
        </p>
        <p>Имаш
            <?php 
            echo $subCnt;
            echo " последовател";
            echo $subCnt === 1 ? '.' : 'и.';
            // echo $subCnt; 
            ?> 
            <!-- последователи. -->
        </p>
        <p>Имаш
        <?php 
            echo $clipCnt;
            echo $clipCnt === 1 ? ' отрязък.' : ' отрязъци.';
            ?> 
             <!-- отрязъци. -->
        </p>
    </div>

    <h1>Последвай приятел</h1>
    <div>
        <label for="search">Търсене по никнейм:</label>
        <input type="text" id="search" placeholder="Никнейм">
        <button onclick="searchUsers()">Търси</button>
    </div>

    <!-- <div id="results"></div> -->
    <div id="results">
        <table>
            <thead>
                <tr>
                    <th>Никнейм</th>
                    <th id="action">Действие</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

    <div id="error"></div>

</body>

</html>