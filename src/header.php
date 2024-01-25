<head>
    <link rel="stylesheet" type="text/css" href="/src/header.css">
</head>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Db.php';

session_start();

function getCurrentUser()
{
    global $db;
    if (isset($_SESSION["logged_in"]) && $_SESSION['logged_in']) {
        return $db->getUserById($_SESSION['user_id']);
    }
}
?>

<body>
    <nav id="main-nav">
        <ul class="nav">
            <li>
                <a href="/src/home/home_user.php" id="home"
                    class="<?php echo ($active === 'home') ? 'active' : ''; ?>">Начало</a>
            </li>
            <li>
                <a href="/src/add_clip/add_clip.php" id="add-clip"
                    class="<?php echo ($active === 'add-clip') ? 'active' : ''; ?>">Добави отрязък</a>
            </li>
            <li>
                <a href="/src/my_clips/my_clips.php" id="my-clips"
                    class="<?php echo ($active === 'my-clips') ? 'active' : ''; ?>">Моите отрезки</a>
            </li>
            <li>
                <a href="/src/profile/profile.php" id="profile"
                    class="<?php echo ($active === 'profile') ? 'active' : ''; ?>">Профил</a>
            </li>

            <?php
            $user = getCurrentUser();
            $isAdmin = $user && $user['is_admin'];
            if ($isAdmin) {
                echo '<li>
                    <a href="/src/admin/home_admin.php" id="admin" class="' . (($active === 'admin') ? 'active' : '') . '">Админ панел</a>
                </li>';
            }
            ?>

            <li>
                <a href="/src/logout/logout.php" id="logout"
                    class="<?php echo ($active === 'logout') ? 'active' : ''; ?>">Изход</a>
            </li>

        </ul>
    </nav>
</body>