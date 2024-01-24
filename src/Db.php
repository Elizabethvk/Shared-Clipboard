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

        $this->loginValidationStmt = $this->connection->prepare("SELECT 1 FROM user WHERE email=:email AND password=:password");
        $this->userByEmailStmt = $this->connection->prepare("SELECT * FROM user WHERE email=:email");
    }

    public function validLogin($email, $password)
    {
        $this->loginValidationStmt->execute(['email' => $email, 'password' => $password]);
        return (bool) $this->loginValidationStmt->fetchColumn();
    }

    public function storeAuthToken($userId, $token, $expirationTime)
    {
        $stmt = $this->connection->prepare("insert into auth_token (user_id, token, expiration_at) values (?, ?, ?)");
        $stmt->execute([$userId, $token, $expirationTime]);
    }

    public function getUserByEmail($email)
    {
        $this->userByEmailStmt->execute(['email' => $email]);
        return $this->userByEmailStmt->fetch();
    }
}

$db = new Db();