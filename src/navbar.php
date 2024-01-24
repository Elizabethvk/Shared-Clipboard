<!DOCTYPE html 5.0>
<html>
    <head>
        <link href="../public/css/navbar.css" rel="stylesheet"></link>
        <?php require 'config/config.php'; ?>
    </head>
    <body>
        <script src="../public/js/navbar.js"></script>

        <?php
            if(!isset($_SESSION)) 
            { 
                session_start(); 
            }

            $user_id = "";
            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];
            } else {
                exit();
            }

            $user_query = "SELECT is_admin FROM `user` WHERE id = " . $user_id;
            $result = mysqli_query($conn, $user_query);

            $home_href = "";
            if ($row = mysqli_fetch_array($result)) {
                if ($row['is_admin']) {
                    $home_href = "home_admin.php";
                } else {
                    $home_href = "home_user.php";
                }
            } else {
                exit();
            }
        ?>

        <nav class="navigation">
            <ul class="navlist">
                <li><a href=<?php echo $home_href ?> class='active'> Home </a></li>

                <?php  
                    $current_page = basename($_SERVER['PHP_SELF']);

                    if (strcmp($current_page, 'clipboard.php') == 0) {
                        $clipboard_id = $_GET['clipboard_id'];
                        $types = $_GET['types'];

                        $clipboard_param = "?clipboard_id=" . $clipboard_id;
                        $types_param = "";
                        foreach ($types as $type) {
                            $types_param .= "&types[]=" . $type;
                        }

                        echo "<li><a href='add-resource.php" . $clipboard_param . $types_param . "'> Добави ресурс </a></li>";
                    } else if (strcmp($current_page, 'home-user.php') == 0) {
                        echo "<li><a href='#subscribe-anchor'> Абонирай се </a></li>";
                        echo "<li><a href='create-clipboard.php'> Създай клипборд </a></li>";
                    } else if (strcmp($current_page, 'home-admin.php') == 0) {
                        echo "<li><a href='create-clipboard.php'> Създай клипборд </a></li>";
                    }
                ?>
                <li><a href="login.php" onclick="logout()"> Logout </a></li>
                
            </ul>
        </nav>
    </body>
</html>
