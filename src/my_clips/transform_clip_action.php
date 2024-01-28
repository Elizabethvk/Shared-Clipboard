<?php
require_once dirname(__FILE__) . '/../transformers.php';
require_once dirname(__FILE__) . '/../Db.php';

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