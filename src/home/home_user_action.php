<?php
// home_db.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Db.php';

// Retrieve the users you are subscribed to
$subscribedUsers = $db->getSubscribedToUsers($_SESSION['user_id']);
?>
