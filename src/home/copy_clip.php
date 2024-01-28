<?php
session_start();
require_once dirname(__FILE__) . '/../Db.php';

function redirectBack()
{
    $previousPage = $_SERVER['HTTP_REFERER'];
    header("Location: $previousPage");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['clip_id'])) {
        $clipId = $_POST['clip_id'];

        $originalClip = $db->getClipById($clipId);

        if ($originalClip) {
            $db->storeClip($originalClip['name'], $originalClip['description'], $originalClip['resource_type'], $originalClip['resource_data'], $originalClip['is_public'], $_SESSION['user_id']);
            $_SESSION['msg'] = "Успешно добавен отрязък!";
            redirectBack();
        }
    }
}

?>