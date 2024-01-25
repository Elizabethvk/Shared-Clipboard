<?php
$active = "my-clips";
include  '../header.php';

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
    <title>Моите отрезки</title>
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
    <h1>Моите отрезки</h1>
    <table>
        <thead>
            <th>Име</th>
            <th>Описание</th>
            <th>Тип</th>
            <th>Съдържание</th>
            <th>Частни</th>
        </thead>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Db.php';

        $snippets = $db->getSnippetsForUser($_SESSION['user_id']);
        foreach ($snippets as $snip) {
            echo "<tr>
            <td>$snip[name]</td>
            <td>$snip[description]</td>
            <td>$snip[resource_type]</td>";

            echo "<td>";
            if (strlen($snip["resource_data"]) <= 50) {
                echo "$snip[resource_data]";
            } else {
                echo "Resource data too long";
            }
            echo "</td>";

            echo "<td>";
            if (!$snip["is_public"]) {
                echo "V";
            } else {
                echo "X";
            }
            echo "</td>";

            echo "</tr>";
        }
        ?>
    </table>
</body>

</html>