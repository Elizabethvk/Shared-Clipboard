<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/config/config.php';

session_start();

$response = [
    'success' => false,
    'message' => '',
    'user' => null,
    'errors' => [],
];

// Set content type to JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    if (isset($_POST['email'], $_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $db->getUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $token = bin2hex(random_bytes(32)); // Generate a random token
            $expirationTime = date('Y-m-d H:i:s', strtotime('+24 hours'));

            // Store the token in the database
            $db->storeAuthToken($user['id'], $token, $expirationTime);

            $response['success'] = true;
            $response['message'] = 'Login successful';
            $response['user'] = $user;

            $_SESSION['logged_in'] = true;
            $_SESSION['user'] = $user;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['auth_token'] = $token;
        } else {
            // Check if the user exists and the password is correct
            $response['errors']['login'] = 'Invalid email or password';
        }
    } else {
        // Missing email or password in the request
        $response['errors']['server'] = 'Invalid request';
    }
}

// Return the JSON response
echo json_encode($response);
exit;
?>