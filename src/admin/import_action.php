<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Db.php';

session_start();

function redirectToErrorPage($message)
{
    $url = 'http://' . $_SERVER['HTTP_HOST'] . "/src/error/error_page.php?message=$message";
    header("Location:$url");
}


if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {

    // https://www.php.net/manual/en/features.file-upload.php
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirectToErrorPage('Invalid request');
    }


    if (isset($_POST['importUsers'])) {
        if (
            !isset($_FILES['usersFile']['error']) ||
            is_array($_FILES['usersFile']['error'])
        ) {
            redirectToErrorPage('Избрани няколко/николко файла. Изберете точно един!');
        }

        switch ($_FILES['usersFile']['error']) {
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

        if ($_FILES['usersFile']['size'] > 1000000) {
            redirectToErrorPage('Избран е твърде голям файл!');
            exit();
        }

        $uploadDir = $config['files']['uploadDir'];
        $targetFile = $uploadDir . sprintf(
            '/%s',
            sha1_file($_FILES['usersFile']['tmp_name'])
        );

        if (
            !move_uploaded_file(
                $_FILES['usersFile']['tmp_name'],
                $targetFile
            )
        ) {
            redirectToErrorPage('Грешка при местене на файла!');
            exit();
        }

        $users = json_decode(readfile($targetFile));

        foreach ($users as $user) {
            $db->storeUser($user['email'], $user['username'], $user['password'], $user['isAdmin']);
        }
    }
}