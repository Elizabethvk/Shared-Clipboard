<?php

require_once dirname(__FILE__) . '/../Db.php';

session_start();


if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirectToErrorPage('Invalid request');
    }

    if (isset($_POST['exportUsers'])) {
        $users = $db->getAllUsers();

        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"clipboard_users.json\"");
        echo json_encode($users);
    }
}