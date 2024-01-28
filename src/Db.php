<?php

require_once dirname(__FILE__) . '/config/config.php';

class Db
{
    private $connection;
    private $loginValidationStmt;
    private $userByEmailStmt;
    private $userByUsernameStmt;
    private $userByIdStmt;
    private $storeAuthTokenStmt;
    private $removeAuthTokenStmt;
    private $storeUserStmt;
    private $storeClipStmt;
    private $publicClipsForSubscribedUserForIdStmt;
    private $isAdminByIdStmt;
    private $snippetsByOwnerIdStmt;
    private $searchUserByUsernameStmt;
    private $searchUserFromSubscriber;
    private $subscribeUserInfo;
    private $unsubscribeUserInfo;
    private $allUsersStmt;
    private $deleteAllUsersStmt;
    private $storeUserDuringImportStmt;
    private $subscriberCntForUserIdStmt;
    private $clipCntForUserIdStmt;
    private $deleteClipForUserIdByIdStmt;
    private $subscribedToStmt;
    private $getClipByIdStmt;

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
        $this->userByUsernameStmt = $this->connection->prepare("SELECT * FROM user WHERE username=:username");
        $this->storeAuthTokenStmt = $this->connection->prepare("INSERT INTO auth_token (user_id, token, expires_at) VALUES (:userId, :token, :expirationTime)");
        $this->removeAuthTokenStmt = $this->connection->prepare("DELETE FROM auth_token WHERE user_id = :userId");
        $this->storeUserStmt = $this->connection->prepare("INSERT INTO user (email, username, password, is_admin) VALUES (:email, :username, :password, :isAdmin)");
        $this->storeUserDuringImportStmt = $this->connection->prepare("INSERT INTO user (id, email, username, password, is_admin) VALUES (:id, :email, :username, :password, :isAdmin)");
        $this->userByIdStmt = $this->connection->prepare("SELECT * FROM user WHERE id=:id");

        $this->publicClipsForSubscribedUserForIdStmt = $this->connection->prepare(
            "SELECT clip.id FROM subscription " .
            "JOIN user as subscriber ON subscription.subscriber_id = subscriber.id " .
            "JOIN user as owner ON subscription.user_id = owner.id " .
            "JOIN clip ON clip.owner_id = owner.id " .
            "WHERE subscriber.id=:id AND clip.is_public = true " .
            "LIMIT :offset, :limit"
        );
        $this->isAdminByIdStmt = $this->connection->prepare("SELECT is_admin FROM user WHERE id = :id");
        $this->storeClipStmt = $this->connection->prepare("INSERT INTO clip (name, description, resource_type, resource_data, is_public, owner_id) VALUES (:name, :description, :resourceType, :resourceData, :isPublic, :ownerId)");
        $this->snippetsByOwnerIdStmt = $this->connection->prepare("SELECT * FROM clip WHERE  owner_id = :id");
        $this->searchUserByUsernameStmt = $this->connection->prepare("SELECT id, email, username FROM user WHERE username LIKE :username");
        $this->searchUserFromSubscriber = $this->connection->prepare("SELECT 1 FROM subscription WHERE subscriber_id = :subscriberId AND user_id = :targetUserId");
        $this->subscribeUserInfo = $this->connection->prepare("INSERT INTO subscription (subscriber_id, user_id) VALUES (:subscriberId, :targetUserId)");
        $this->unsubscribeUserInfo = $this->connection->prepare("DELETE FROM subscription WHERE subscriber_id = :subscriberId AND user_id = :targetUserId");
        $this->allUsersStmt = $this->connection->prepare("SELECT * FROM user");
        $this->deleteAllUsersStmt = $this->connection->prepare("DELETE FROM user");
        $this->subscriberCntForUserIdStmt = $this->connection->prepare("SELECT COUNT(1) FROM subscription WHERE user_id=:id");
        $this->clipCntForUserIdStmt = $this->connection->prepare("SELECT COUNT(1) FROM clip WHERE owner_id=:id");
        $this->deleteClipForUserIdByIdStmt = $this->connection->prepare("DELETE FROM clip WHERE owner_id=:userId AND id=:clipId");
        $this->subscribedToStmt = $this->connection->prepare(("SELECT user.* FROM subscription JOIN user ON subscription.user_id = user.id WHERE subscription.subscriber_id = :subscriberId"));
        $this->getClipByIdStmt = $this->connection->prepare("SELECT * FROM clip WHERE id = :clipId");

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

    public function getUserByUsername($username)
    {
        $this->userByUsernameStmt->execute(['username' => $username]);
        return $this->userByUsernameStmt->fetch();
    }

    public function getUserById($id)
    {
        $this->userByIdStmt->execute(['id' => $id]);
        return $this->userByIdStmt->fetch();
    }

    // the first returned record is page*limit
    // zero indexed in page
    public function getPublicClipsUserSubscribedToById($id, $limit, $page)
    {
        $this->publicClipsForSubscribedUserForIdStmt->execute(['id' => $id, 'limit' => $limit, 'offset' => $page * $limit]);
        return $this->publicClipsForSubscribedUserForIdStmt->fetchAll();
    }

    public function removeAuthToken($user_id)
    {
        $this->removeAuthTokenStmt->bindParam(":userId", $user_id, PDO::PARAM_INT);
        $this->removeAuthTokenStmt->execute();
    }

    public function isUserAdminById($user_id)
    {
        $this->isAdminByIdStmt->execute(["id" => $user_id]);
        return $this->isAdminByIdStmt->fetch()['is_admin'];
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

    public function storeUserDuringImport($id, $email, $username, $hashedPassword, $isAdmin)
    {
        $this->storeUserDuringImportStmt->execute([
            'id' => $id,
            'email' => $email,
            'username' => $username,
            'password' => $hashedPassword,
            'isAdmin' => $isAdmin,
        ]);
    }

    public function storeClip($name, $description, $resourceType, $resourceData, $isPublic, $ownerId)
    {
        $this->storeClipStmt->execute([
            'name' => $name,
            'description' => $description,
            'resourceType' => $resourceType,
            'resourceData' => $resourceData,
            'isPublic' => $isPublic,
            'ownerId' => $ownerId,
        ]);
    }

    public function getSnippetsForUser($user_id)
    {
        $this->snippetsByOwnerIdStmt->execute(["id" => $user_id]);
        return $this->snippetsByOwnerIdStmt->fetchAll();
    }

    public function getSubscriberCountForUserId($user_id)
    {
        $this->subscriberCntForUserIdStmt->execute(["id" => $user_id]);
        return $this->subscriberCntForUserIdStmt->fetchColumn();
    }

    public function getClipCntForUserIds($user_id)
    {
        $this->clipCntForUserIdStmt->execute(["id" => $user_id]);
        return $this->clipCntForUserIdStmt->fetchColumn();
    }

    public function searchUserByUsername($username)
    {
        $this->searchUserByUsernameStmt->bindValue(':username', '%' . $username . '%', PDO::PARAM_STR);
        $this->searchUserByUsernameStmt->execute();

        return $this->searchUserByUsernameStmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function toggleSubscription($subscriberId, $targetUsername)
    {
        $targetUser = $this->getUserByUsername($targetUsername);

        if (!$targetUser) {
            return ['error' => 'Target user not found'];
        }

        $targetUserId = $targetUser['id'];

        if ($this->isUserSubscribed($subscriberId, $targetUserId)) {
            $this->unsubscribeUser($subscriberId, $targetUserId);
            return ['success' => true, 'action' => 'unsubscribe'];
        } else {
            $this->subscribeUser($subscriberId, $targetUserId);
            return ['success' => true, 'action' => 'subscribe'];
        }
    }

    public function isUserSubscribed($subscriberId, $targetUserId)
    {
        $this->searchUserFromSubscriber->execute(['subscriberId' => $subscriberId, 'targetUserId' => $targetUserId]);
        return $this->searchUserFromSubscriber->fetchColumn() !== false;
    }

    public function subscribeUser($subscriberId, $targetUserId)
    {
        $this->subscribeUserInfo->execute(['subscriberId' => $subscriberId, 'targetUserId' => $targetUserId]);
    }

    public function unsubscribeUser($subscriberId, $targetUserId)
    {
        $this->unsubscribeUserInfo->execute(['subscriberId' => $subscriberId, 'targetUserId' => $targetUserId]);
    }

    public function getAllUsers()
    {
        $this->allUsersStmt->execute();
        return $this->allUsersStmt->fetchAll();
    }

    public function deleteAllUsers()
    {
        $this->deleteAllUsersStmt->execute();
    }

    public function deleteSnippetForUser($userId, $clipId)
    {
        $this->deleteClipForUserIdByIdStmt->execute(["userId" => $userId, "clipId" => $clipId]);
    }

    public function getSubscribedToUsers($subscriberId)
    {
        $this->subscribedToStmt->execute(['subscriberId' => $subscriberId]);
        return $this->subscribedToStmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Todo: fix this or change it with the other one
    public function getPublicClipsForUser($userId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM clip WHERE owner_id = :userId AND is_public = 1");
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll();
    }

    public function getClipById($clipId)
    {
        $this->getClipByIdStmt->execute(['clipId' => $clipId]);
        return $this->getClipByIdStmt->fetch();
    }

}

$db = new Db();


