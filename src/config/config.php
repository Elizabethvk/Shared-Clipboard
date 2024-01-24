<?php

$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/src/config/config.ini', true);

$dbhost = $config['db']['host'];
$dbName = $config['db']['name'];
$userName = $config['db']['user'];
$userPassword = $config['db']['password'];

$conn = new mysqli($dbhost, $userName, $userPassword, $dbName);

if ($conn->connect_error) {
    die('Could not Connect MySQL: ' . $conn->connect_error);
}
