<?php
// home_db.php
require_once dirname(__FILE__) . '/../Db.php';

// Retrieve the users you are subscribed to
$subscribedUsers = $db->getSubscribedToUsers($_SESSION['user_id']);
?>
