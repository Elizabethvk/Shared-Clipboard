<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/config/config.php';

class Db
{
    private $connection;

    private $loginValidationStmt;
    private $userByEmailStmt;

    public function __construct()
    {
        global $config;
        $dbhost = $config['db']['host'];
        $dbName = $config['db']['name'];
        $userName = $config['db']['user'];
        $userPassword = $config['db']['password'];

        $this->connection = new PDO(
            "mysql:host=$dbhost;dbname=$dbName",
            $userName,
            $userPassword,
            [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );

        $this->loginValidationStmt = $this->connection->prepare("select 1 from user where email=:email and password=:password");
        $this->userByEmailStmt = $this->connection->prepare("select * from user where email=:email");
    }

    public function validLogin($email, $password)
    {
        $this->loginValidationStmt->execute(['email' => $email, 'password' => $password]);
        if ($this->loginValidationStmt->fetchColumn()) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserByEmail($email)
    {
        $this->userByEmailStmt->execute(['email' => $email]);
        $user = $this->loginValidationStmt->fetch();
        if ($user) {
            return $user;
        } else {
            return null;
        }
    }
}

$db = new Db();