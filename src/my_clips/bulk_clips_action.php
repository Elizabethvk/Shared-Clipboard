<?php

require_once dirname(__FILE__) . "/../Db.php";
require_once dirname(__FILE__) . "/../config/config.php";

session_start();

function redirectBack()
{
    global $config;
    $previousPage = $_SERVER['HTTP_REFERER'];
    header("Location: $previousPage");
}

function getCurrentUser()
{
    global $db;
    if (isset($_SESSION["logged_in"]) && $_SESSION['logged_in']) {
        return $db->getUserById($_SESSION['user_id']);
    }
}

function redirectToErrorPage($message)
{
    global $config;
    $url = $config['host']['url'] . "/src/error/error_page.php?message=$message";
    header("Location:$url");
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['export'])) {
    $clips = $db->getAllClipsForUser(getCurrentUser()['id']);
    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary");
    header("Content-disposition: attachment; filename=\"clips.json\"");
    echo json_encode($clips);

} else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['import'])) {
    if (isset($_FILES['importClipsFile'])) {
        if (
            !isset($_FILES['importClipsFile']['error']) ||
            is_array($_FILES['importClipsFile']['error'])
        ) {
            redirectToErrorPage('Избрани няколко/николко файла. Изберете точно един!');
        }

        switch ($_FILES['importClipsFile']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                redirectToErrorPage('Не е изпратен файл!');
                exit();
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                redirectToErrorPage('Избран е твърде голям файл!');
                exit();
            default:
                redirectToErrorPage('Грешка при качване!');
                exit();
        }

        if ($_FILES['importClipsFile']['size'] > 1000000) {
            redirectToErrorPage('Избран е твърде голям файл!');
            exit();
        }

        $uploadDir = $config['files']['uploadDir'];
        $targetFile = $uploadDir . sprintf(
            '/%s',
            sha1_file($_FILES['importClipsFile']['tmp_name'])
        );

        if (
            !move_uploaded_file(
                $_FILES['importClipsFile']['tmp_name'],
                $targetFile
            )
        ) {
            redirectToErrorPage('Грешка при местене на файла!');
            exit();
        }

        // readfile($targetFile);
        $jsonString = file_get_contents($targetFile);
        $clips = json_decode($jsonString, true);

        foreach ($clips as $clip) {
            $db->storeClip(
                $clip['name'],
                $clip['description'],
                $clip['resource_type'],
                $clip['resource_data'],
                $clip['is_public'],
                getCurrentUser()['id']
            );
        }

        $_SESSION['msg'] = 'Успешно импортиране на отрязъци';
        redirectBack();
    }
} else {
    redirectBack();
}