<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/config/config.php';

class Db
{
    private $connection;

    private $loginValidationStmt;
    private $userByEmailStmt;
    private $storeAuthTokenStmt;
    private $removeAuthTokenStmt;
    private $storeUserStmt;

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
        $this->storeAuthTokenStmt = $this->connection->prepare("INSERT INTO auth_token (user_id, token, expires_at) VALUES (:userId, :token, :expirationTime)");
        $this->removeAuthTokenStmt = $this->connection->prepare("DELETE FROM auth_token WHERE user_id = :userId");
        $this->storeUserStmt = $this->connection->prepare("INSERT INTO user (email, username, password, is_admin) VALUES (:email, :username, :password, :isAdmin)");
    }

    public function validLogin($email, $password)
    {
        $this->loginValidationStmt->execute(['email' => $email, 'password' => $password]);
        return (bool) $this->loginValidationStmt->fetchColumn();
    }

    public function storeAuthToken($userId, $token, $expirationTime)
    {
        $this->storeAuthTokenStmt->execute([
            'userId' => $userId,
            'token' => $token,
            'expirationTime' => $expirationTime,
        ]);
    }

    public function getUserByEmail($email)
    {
        $this->userByEmailStmt->execute(['email' => $email]);
        return $this->userByEmailStmt->fetch();
    }

    public function removeAuthToken($user_id)
    {
        $this->removeAuthTokenStmt->bindParam(":userId", $user_id, PDO::PARAM_INT);
        $this->removeAuthTokenStmt->execute();
    }

    public function storeUser($email, $username, $hashedPassword, $isAdmin)
    {
        $this->storeUserStmt->execute([
            'email' => $email,
            'username' => $username,
            'password' => $hashedPassword,
            'isAdmin' => $isAdmin,
        ]);
    }

}

$db = new Db();