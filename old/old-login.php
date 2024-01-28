<?php
session_start();

if (isset($_POST['user'])) {
    // Your existing code for handling the form submission goes here
}
else {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        extract($_POST);

        require_once dirname(__FILE__) . '/src/Db.php';
        require_once dirname(__FILE__) . '/src/config/config.php';

        $email = $_POST['email'];
        $password = sha1($_POST['password']);

        echo $email, $password;

        $_SESSION['logged_in'] = true;
        $_SESSION['user'] = $db->getUserByEmail($email);

    } else {
        // Handle the case where email or password is not set
        echo "Email and password are required.";
    }
}


// if (!isset($_POST['user'])) {
//     extract($_POST);

//     require_once dirname(__FILE__) . '/src/Db.php';
//     require_once dirname(__FILE__) . '/src/config/config.php';

//     $email = $_POST['email'];
//     $password = sha1($_POST['password']);

//     echo $email, $password;

//     // if ($db->isValidLogin($email, $password)) {
//     // line 2
//     // session_start();
//     $_SESSION['logged_in'] = true;
//     $_SESSION['user'] = $db->getUserByEmail($email);

//     //     if ($row['IS_ADMIN']) {
// //         header("Location: ../home-admin.php");
// //     } else {
// //         header("Location: ../home-user.php");
// //     }
// // }
// // else {
// //     echo "Invalid Email ID/Password";
// // }
//     // }
// }