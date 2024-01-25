<?php
$active = "my-clips";
include $_SERVER['DOCUMENT_ROOT'] . '/src/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/src/footer.php';

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
    <link rel="stylesheet" type="text/css" href="./my_clips.css">
    <link rel="icon" type="image/png" sizes="32x32" href="../../img/favicon.png">
</head>

<body>
    <main class="section" id="main">
        <p id="user-message">
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
            }
            unset($_SESSION['msg']);
            ?>
        </p>
        <h1>Моите отрезки</h1>
        <table class="clip-table">
            <thead>
                <th>Име</th>
                <th>Описание</th>
                <th>Тип</th>
                <th>Съдържание</th>
                <th>Частни</th>
                <th>Действия</th>
            </thead>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                return;
            }
            require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Db.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/src/transformers.php';

            function printValidActionsForClip($clip)
            {
                $transformableTo = array_map(function ($transformer) {
                    return $transformer->canTransformTo();
                }, availableTransformersFor($clip['resource_type']));

                echo '<select id="transformer_select" name="transformer_select">';
                foreach ($transformableTo as $idx => $transformableToStr) {

                    echo "<option value=\"$idx\">$transformableToStr</option>";
                }
                echo '</select>';
            }

            $clips = $db->getSnippetsForUser($_SESSION['user_id']);
            foreach ($clips as $idx => $clip) {
                echo '<form class="list-clip-run-form" action="./transform_clip_action.php" method="post"
            enctype="multipart/form-data">';

                echo "<tr>
            <td>$clip[name]</td>
            <td>$clip[description]</td>
            <td>$clip[resource_type]</td>";

                echo "<td>";
                if (strlen($clip["resource_data"]) <= 50) {
                    echo htmlspecialchars("$clip[resource_data]");
                } else {
                    echo "Съдържанието на ресурса е твърде дълго.";
                }
                echo "</td>";

                echo "<td id=\"privacy\">";
                if (!$clip["is_public"]) {
                    echo "✓";
                } else {
                    echo "X";
                }
                echo "</td>";

                echo "<td>";
                printValidActionsForClip($clip);
                echo "</td>";
                echo "<td>";
                echo "<button type=\"submit\" name=\"act\" value=\"$idx\">Изпълни</button>";
                echo "</td>";
                echo "<td>";
                echo "<button type=\"submit\" name=\"delete\" value=\"$clip[id]\">Изтрий</button>";
                echo "</td>";
                echo "</tr>";
                echo "</form>";
                // TODO Tsvetelin : edit clips
            }
            ?>
        </table>
    </main>
</body>

</html>