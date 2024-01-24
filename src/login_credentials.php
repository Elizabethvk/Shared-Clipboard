<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/config/config.php';

session_start();

$response = [
    'success' => false,
    'message' => '',
    'errors' => [],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'], $_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $db->getUserByEmail($email);

        if ($user && password_verify($enteredPassword, $user['password'])) {
            $token = bin2hex(random_bytes(32)); // Generate a random token
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

            if ($user['is_admin']) {
                header("Location: home_admin.php");
            } else {
                header("Location: home_user.php");
            }
            exit();
        } else {
            // Check if the user exists and the password is correct
            $response['errors']['login'] = 'Invalid email or password';
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
