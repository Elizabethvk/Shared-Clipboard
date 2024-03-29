<?php
require_once dirname(__FILE__) . '/../Db.php';

function redirectToAddClip()
{
    global $config;
    $url = $config['host']['url'] . '/src/add_clip/add_clip.php';
    header("Location:$url");
}
function redirectBack()
{
    global $config;
    $previousPage = $_SERVER['HTTP_REFERER'];
    header("Location: $previousPage");
}

function redirectToIndex()
{
    global $config;
    $url = $config['host']['url'] . '/src/index.php';
    header("Location:$url");
}

function redirectToErrorPage($message)
{
    global $config;
    $url = $config['host']['url'] . "/src/error/error_page.php?message=$message";
    header("Location:$url");
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
        $isPublic = !isset($_POST['private']);

        $desc = $_POST['description'];

        if ($resourceType === 'auto') {
            if (preg_match('/^https?:\/\//', $clipContent)) {
                $resourceType = 'link';
            } else if (preg_match('/^\<\?php/', $clipContent)) {
                $resourceType = 'php';
            } else if (preg_match('/^\#\!/', $clipContent)) {
                $resourceType = 'bash';
            } else {
                $resourceType = 'other';
            }
        }

        $user = getCurrentUser();

        if ($user) {
            $db->storeClip($name, $desc, $resourceType, $clipContent, $isPublic, $_SESSION['user_id']);
            $_SESSION['msg'] = "Успешно добавен отрязък!";
            redirectBack();
        } else {
            redirectToErrorPage("Няма активен потребител!");
        }
    }
} else {
    redirectToIndex();
}
