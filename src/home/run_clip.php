<?php
require_once dirname(__FILE__) . '/../transformers.php';
require_once dirname(__FILE__) . '/../Db.php';

// session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['act'])) {
    $clipIdx = $_POST['act'];
    // $transformer = $transformers[$_POST['transformer_select']];
    $dropdownName = "transformer_select_$clipIdx";

    if (isset($_POST[$dropdownName])) {
        $transformer = $transformers[$_POST[$dropdownName]];
        $clip = $db->getClipById($clipIdx);
        $transformer->transform($clip);
    }

    // $clip = $db->getClipById($clipIdx);
    // // $clip = $db->getSnippetsForUser($_SESSION['user_id'])[$clipIdx];
    // $transformer->transform($clip);
}