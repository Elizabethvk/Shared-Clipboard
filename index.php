<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Shared clipboard</title>
</head>

<body>
	<?php
	// require_once("src/Db.php");
	// $db = new Db();
	// echo $db->getConnection()->prepare("select * from user")->execute();
	
	?>
</body>

</html>

<?php // home.php
session_start();
if ($_SESSION['user']) {
	// user is authenticated
	header('Location: src/home/home_user.php');
} else {
	// user is not authenticated
	header('Location: src/login/login.html');
}
?>