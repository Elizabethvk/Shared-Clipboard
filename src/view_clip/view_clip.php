<?php
$active = "my-clips";
include dirname(__FILE__) . '/../header.php';
include dirname(__FILE__) . '/../footer.php';

function redirectToErrorPage($message)
{
    global $config;
    $url = "$config[host][url]/src/error/error_page.php?message=$message";
    header('Location:' . $url);
}


if (!isset($_GET['clipId'])) {
    redirectToErrorPage('Споделяне на отрязъци се нуждае от повече параметри. Линкът, който използвате е грешен');
}

?>

<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Моите отрезки</title>
    <link rel="icon" type="image/png" sizes="32x32" href="../../img/favicon.png">
    <link href="./view_clip.css" rel="stylesheet">
</head>

<body>
    <?php
    require_once dirname(__FILE__) . '/../Db.php';

    $clip = $db->getClipById($_GET['clipId']);
    ?>

    <h1>Отрязък</h1>
    <section class="info">
        <p>
            Име:
            <?php echo $clip['name'] ?>
        </p>
        <p>
            <?php
            if ($clip['description'] !== null && $clip['description'] !== '') {
                echo 'Описание:' . $clip['description'];
            }
            ?>
        </p>
        <p>
            Тип:
            <?php echo $clip['resource_type']; ?>
        </p>
        <p>
            Съдържание:
            <?php echo htmlspecialchars($clip['resource_data']); ?>
        </p>
        <form action="../../src/home/copy_clip.php" method="post">
            <input type="hidden" name="clip_id" value="<?= $clip['id'] ?>">
            <button type="submit">Копирай</button>
        </form>
    </section>
</body>