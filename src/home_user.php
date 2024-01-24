<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <link href="../public/css/dynamic-table.css" rel="stylesheet">
    <!-- <?php require 'navbar.php'; ?> -->
    <script src="../public/js/home-user.js"></script>
</head>
<body>
    <?php
    if (!isset($_SESSION)) {
        session_start();
    }

    $user_id = "";
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        die("Not logged in!");
    }
    
    echo $_SESSION;
    echo $user_id;

    // Retrieve user information
    $query_user = "SELECT * FROM `user` WHERE ID=$user_id";
    $result_user = mysqli_query($conn, $query_user);
    $row_user = mysqli_fetch_array($result_user);
    if ($row_user['is_admin']) {
        header("Location: home_admin.php");
    }

    // Retrieve clipboards the user is subscribed to
    $subquery = "SELECT user_id FROM subscription WHERE subscriber_id = $user_id";
    $query_subscribed = "SELECT * FROM clip WHERE owner_id IN ($subquery)";
    // $query_subscribed = "SELECT * FROM clip WHERE id IN (select )";
    $result_subscribed = mysqli_query($conn, $query_subscribed);

    // Retrieve all public clipboards excluding those the user is subscribed to
    $subquery_all_public = "SELECT user_id FROM subscription WHERE subscriber_id=$user_id";
    $query_all_public = "SELECT * FROM clip WHERE is_public IS false AND owner_id NOT IN ($subquery_all_public)";
    $result_all_public = mysqli_query($conn, $query_all_public);

    // Visualize subscribed clipboards table
    echo "<div class='clipContainer'>
            <table class='clipTable'>
                <thead class='tableHeader'>
                    <tr>
                        <th class='headerElement'>Name</th>
                        <th class='headerElement'>Type</th>
                        <th class='headerElement'>Private</th>
                    </tr>
                </thead>
                <tbody class='tableBody'>";

    while ($row_subscribed = mysqli_fetch_array($result_subscribed)) {
        // Output rows for subscribed clipboards
        echo "<tr class='tableRow'>";
        echo "<td class='clipName'>" . $row_subscribed['name'] . "</td>";
        // Add other columns as needed
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "<a name='introduction-anchor'></a>";

    // Visualize all public clipboards table
    echo "<div class='clipContainer'>
            <table class='clipTable'>
                <thead class='tableHeader'>
                    <tr>
                        <th class='headerElement'>Name</th>
                        <th class='headerElement'>Type</th>
                        <th class='headerElement'>Subscribe</th>
                    </tr>
                </thead>
                <tbody class='tableBody'>";

    while ($row_all_public = mysqli_fetch_array($result_all_public)) {
        // Output rows for all public clipboards
        echo "<tr class='tableRow'>";
        echo "<td class='clipName'>" . $row_all_public['name'] . "</td>";
        // Add other columns as needed
        echo "<td class='borderData'>" . $row_all_public['resource_type'] . "</td>";
        echo "<td class='addUser'> 
                <button type='button' id='subscribeBtn' onclick='subscribe($user_id, $clipboard_id)'>Subscribe</button>
              </td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";

    mysqli_close($conn);
    ?>
</body>
</html>
