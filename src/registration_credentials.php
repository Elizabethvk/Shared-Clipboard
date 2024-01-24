<?php
session_start();

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
        include 'config/config.php';
        $sql = mysqli_query($conn, "select * from `user` where email='$email'");
        if (mysqli_num_rows($sql) > 0) {
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
            include 'config/config.php';
            
            // Check if email already exists again (just to be sure)
            $sql = mysqli_query($conn, "select * from `user` where email='$email'");
            if (mysqli_num_rows($sql) > 0) {
                echo json_encode(['success' => false, 'message' => 'Email ID already exists']);
                exit;
            }

            // Insert new user into the database
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query = "insert into `user` (email, username, password, is_admin) values ('$email', '$username', '$hashedPassword', false)";
            $sql = mysqli_query($conn, $query) or die("Could not perform the query");
            
            // echo json_encode(['success' => true, 'message' => 'Registration successful']);
            header("Location: home_user.php");
            exit;
        } else {
            // If there are errors, return them as a JSON response
            echo json_encode(['success' => false, 'errors' => $errors]);
            exit;
        }
    }
}
// ?>
