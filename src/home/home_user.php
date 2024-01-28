<?php
$active = "home";
require_once dirname(__FILE__) . '/../header.php';
require_once dirname(__FILE__) . '/../footer.php';

if (!isset($_SESSION['logged_in'])) {
    // header('Location:' . $config['host']['url'] . '/src/login/login.php');
    exit();
}

require_once dirname(__FILE__) . '/../Db.php';

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
</head>

<body>
    <h1>Начало</h1>

    <?php
    require_once dirname(__FILE__) . '/../Db.php';

    $subCnt = $db->getSubscriberCountForUserId(getCurrentUser()['id']);
    $clipCnt = $db->getClipCntForUserIds(getCurrentUser()['id']);
    ?>

    <div class="user-info">
        <h3>
            Здравей,
            <?php echo getCurrentUser()['username'] ?>!
        </h3>
    </div>

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

                    // $user = getCurrentUser();
                    // $username = $user['username'];
                    ?>
                    <?php foreach ($publicClips as $clip): ?>
                        <?php
                        $owner = $db->getUserById($clip['owner_id']);
                        $username = $owner['username'];
                        ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($clip['name']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($clip['description']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($clip['resource_type']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($clip['resource_data']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($username) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($clip['uploaded_at']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="user-info">
            <h3>Не сте абонирани за никого все още!</h3>
        </div>
    <?php endif; ?>

</body>

</html>