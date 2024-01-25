<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Db.php';

function redirectToAddClip()
{
    header('Location:http://' . $_SERVER['HTTP_HOST'] . '/src/add_clip/add_clip.php');
}

function redirectBack()
{
    $previousPage = $_SERVER['HTTP_REFERER'];
    header("Location: $previousPage");
}

function redirectToIndex()
{
    header('Location:' . $_SERVER['DOCUMENT_ROOT'] . '/src/index.php');
}

function redirectToErrorPage($message)
{
    header('Location:' . $_SERVER['DOCUMENT_ROOT'] . "/src/error/error_page.php?message=$message");
}

session_start();
function getCurrentUser()
{
    global $db;
    if (isset($_SESSION["logged_in"]) && $_SESSION['logged_in']) {
        return $db->getUserById($_SESSION['user_id']);
    } else {
        return null;
    }
}

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirectToErrorPage('Invalid request');
    }

    if (isset($_POST['name'], $_POST['res_type'], $_POST['clip_content'])) {
        $name = $_POST['name'];
        $resourceType = $_POST['res_type'];
        $clipContent = $_POST['clip_content'];
        $isPublic = isset($_POST['public']);

        $desc = $_POST['description'];

        $user = getCurrentUser();

        if ($user) {
            $_SESSION['msg'] = "Успешно добавен отрязък! $isPublic, $desc";

            $db->storeClip($name, $desc, $resourceType, $clipContent, $isPublic, $_SESSION['user_id']);

            redirectBack();
        }
    }
} else {
    redirectToIndex();
}
