<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Db.php';

$response = [
    'success' => false,
    'message' => '',
    'errors' => [],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'], $_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['errors']['email'] = 'Invalid email address';
        } else {
            // Check if the user exists and the password is correct
            $db = new Db();
            $user = $db->getUserByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                // Generate a random token
                $token = bin2hex(random_bytes(32));
                $expirationTime = date('Y-m-d H:i:s', strtotime('+24 hours'));

                // Store the token in the database
                $db->storeAuthToken($user['id'], $token, $expirationTime);

                // Set session variables
                $_SESSION['logged_in'] = true;
                $_SESSION['user'] = $user;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['auth_token'] = $token;

                $response['success'] = true;
                $response['message'] = 'Login successful';
            } else {
                // Invalid login credentials
                $response['errors']['login'] = 'Invalid email or password';
            }
        }
    } else {
        // Missing email or password in the request
        $response['errors']['server'] = 'Invalid request';
    }
}

// Set content type to JSON
header('Content-Type: application/json');

// Return the JSON response
echo json_encode($response);
exit;
?>
