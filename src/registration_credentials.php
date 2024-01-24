<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Db.php';

$db = new Db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'], $_POST['username'], $_POST['password'], $_POST['repeat_password'])) {
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $repeatPassword = $_POST['repeat_password'];

        $errors = [];

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email address';
        }

        // Check if email already exists
        $existingUser = $db->getUserByEmail($email);
        if ($existingUser) {
            $errors['email'] = 'Email ID already exists';
        }

        // Validate username
        if (empty($username)) {
            $errors['username'] = 'Username is required';
        }

        // Validate password
        if (strlen($password) < 6) {
            $errors['password'] = 'Password must be at least 6 characters long';
        }

        // Check if passwords match
        if ($password !== $repeatPassword) {
            $errors['repeat_password'] = 'Passwords do not match';
        }

        if (empty($errors)) {
            // If there are no errors, proceed with the registration logic

            // Check if email already exists again (just to be sure)
            $existingUser = $db->getUserByEmail($email);
            if ($existingUser) {
                $_SESSION['registration_errors'] = ['email' => 'Email ID already exists'];
                header("Location: registration.php");
                exit;
            }

            // Insert new user into the database
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $db->storeUser($email, $username, $hashedPassword, false);

            header("Location: home_user.php");
            exit;
        } else {
            // If there are errors, store them in the session variable
            $_SESSION['registration_errors'] = $errors;
            header("Location: registration.php");
            exit;
        }
    }
}
?>
