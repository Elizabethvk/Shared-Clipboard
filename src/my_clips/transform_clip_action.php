<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/transformers.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['act'])) {
    $transformer = $transformers[$_POST['transformer_select']];
    $clipIdx = $_POST['act'];

    $clip = $db->getSnippetsForUser($_SESSION['user_id'])[$clipIdx];
    $transformer->transform($clip);
} else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $clipIdx = $_POST['delete'];

    $db->deleteSnippetForUser($_SESSION['user_id'], $clipIdx);
    redirectBack();
} else {
    redirectBack();
}