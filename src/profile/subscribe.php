<?php
include $_SERVER['DOCUMENT_ROOT'] . '/src/Db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $subscriberId = $_SESSION['user_id'];
    $username = $_POST['username'];

    $subscriptionResult = $db->toggleSubscription($subscriberId, $username);

    if ($subscriptionResult['success']) {
        echo json_encode(['success' => true, 'action' => $subscriptionResult['action']]);
        exit();
    } else {
        echo json_encode(['error' => $subscriptionResult['error']]);
        exit();
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
    exit();
}
?>
