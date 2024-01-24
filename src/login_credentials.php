<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'], $_POST['password'])) {
        $email = $_POST['email'];
        $enteredPassword = $_POST['password'];

        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Db.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/config/config.php';

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

            if ($user['is_admin']) {
                header("Location: ./home-admin.php");
            } else {
                header("Location: ./home-user.php");
            }
            exit();
        } else {
            echo "Invalid Email ID/Password";
        }
    }
} else {
    // Handle the case where email or password is not set
    echo "Email and password are required.";
}

?>
