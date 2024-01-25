<?php
header('Content-Type: application/json');
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['username'])) {
    $username = $_GET['username'];
    $subscriberId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    if ($subscriberId !== null) {
        $users = $db->searchUserByUsername($username);

        foreach ($users as &$user) {
            $targetUserId = $user['id'];
            $user['isSubscribed'] = $db->isUserSubscribed($subscriberId, $targetUserId);
        }

        echo json_encode($users);
        exit();
    } else {
        echo json_encode(['error' => 'Subscriber ID not found in the session']);
        exit();
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
    exit();
}
?>