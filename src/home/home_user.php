<?php
$active = "home";
include $_SERVER['DOCUMENT_ROOT'] . '/src/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/src/footer.php';

if (!isset($_SESSION['logged_in'])) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/src/login/login.php');
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Db.php';

$subscribedUsers = $db->getSubscribedToUsers($_SESSION['user_id']);
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

    <h2>Публични отрезки на вашите абонаменти:</h2>

    <?php if (isset($subscribedUsers) && !empty($subscribedUsers)): ?>
        <table class="subscribed-users-table">
            <thead>
                <tr>
                    <th>Име</th>
                    <th>Описание</th>
                    <th>Тип</th>
                    <th>Съдържание</th>
                    <th>Собственик</th>
                    <th>Качено на</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subscribedUsers as $user): ?>
                    <?php
                    $publicClips = $db->getPublicClipsForUser($user['id']);
                    $user = getCurrentUser();
                    $username = $user['username'];
                    ?>
                    <?php foreach ($publicClips as $clip): ?>
                        <tr>
                            <td><?= htmlspecialchars($clip['name']) ?></td>
                            <td><?= htmlspecialchars($clip['description']) ?></td>
                            <td><?= htmlspecialchars($clip['resource_type']) ?></td>
                            <td><?= htmlspecialchars($clip['resource_data']) ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($clip['uploaded_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No subscribed users found.</p>
    <?php endif; ?>

</body>

</html>