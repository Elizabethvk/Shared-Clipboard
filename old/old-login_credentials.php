<?php
session_start();

if (isset($_POST['save'])) {
    extract($_POST);
    include 'config/config.php';

    $email = $_POST['email'];
    $enteredPassword = $_POST['password'];

    $sql = mysqli_query($conn, "select * from `user` where email='$email'");
    $row = mysqli_fetch_array($sql);

    if (is_array($row)) {
        if (password_verify($enteredPassword, $row['password'])) {
            $_SESSION['logged_in'] = TRUE;
            $_SESSION['user_id'] = $row['id'];

            if ($row['is_admin']) {
                header("Location: ./home-admin.php");
            } else {
                header("Location: ./home-user.php");
            }
            
        } else {
            echo "Invalid Email ID/Password";
        }
    } else {
        echo "Invalid Email ID/Password";
    }
} else {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        extract($_POST);

        require_once dirname(__FILE__) . '/src/Db.php';
        require_once dirname(__FILE__) . '/src/config/config.php';

        $email = $_POST['email'];
        $enteredPassword = $_POST['password'];

        // Fetching the hashed password from the database
        $user = $db->getUserByEmail($email);

        if ($user && password_verify($enteredPassword, $user['password'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['user'] = $user;

            if ($user['is_admin']) {
                header("Location: ./home-admin.php");
            } else {
                header("Location: ./home-user.php");
            }
        } else {
            echo "Invalid Email ID/Password";
        }
    } else {
        // Handle the case where email or password is not set
        echo "Email and password are required.";
    }
}

// Session expiration logic
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    $user_id = $_SESSION['user_id'];

    // Check the last activity timestamp
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 86400)) {
        // Session has expired (86400 seconds = 24 hours)
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage
        header("Location: ./login.php");
        exit();
    }

    // Update the last activity timestamp
    $_SESSION['last_activity'] = time();
} else {
    // Redirect to the login page or show an error message
    header("Location: ./login.php");
    exit();
}
?>