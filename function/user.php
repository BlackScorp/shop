<?php

function getCurrentUserId(): ?int
{
    $userId = null;

    if (isset($_SESSION['userId'])) {
        $userId = (int)$_SESSION['userId'];
    }
    return $userId;
}

function getAccountsTotal(): ?int
{
    $sql = "SELECT COUNT(id) FROM user";
    $statement = getDb()->query($sql);
    if (false === $statement) {
        return null;
    }
    return (int)$statement->fetchColumn();
}

function createAccount(string $username, string $password, string $email): bool
{
    $password = password_hash($password, PASSWORD_DEFAULT);

    $group = 'USER';
    if (getAccountsTotal() === 0) {
        $group = 'ADMIN';
    }

    $sql = "INSERT INTO user SET
  username=:username,
  password=:password,
  email = :email,
  activationKey = :activationKey,
  userRights = :group";

    $statement = getDb()->prepare($sql);
    if (false === $statement) {
        return false;
    }
    $activationKey = getRandomHash(8);
    $data = [
        ':username' => $username,
        ':password' => $password,
        ':email' => $email,
        ':activationKey' => $activationKey,
        ':group' => $group
    ];
    $statement->execute($data);

    $affectedRows = $statement->rowCount();

    return $affectedRows > 0;
}

function getUserDataForId(?int $userId): array
{
    if (null === $userId) {
        $userId = getCurrentUserId();
    }

    $sql = "SELECT id,username,email,password,CONCAT_WS('-','KD',SUBSTR(username,1,3),id) AS customerNumber
  FROM user
  WHERE id=:id";

    $statement = getDb()->prepare($sql);
    if (false === $statement) {
        return [];
    }
    $statement->execute([
        ':id' => $userId
    ]);
    if (0 === $statement->rowCount()) {
        return [];
    }
    $row = $statement->fetch();
    return $row;
}

function usernameExists(string $username): bool
{
    $sql = "SELECT 1 FROM user WHERE username=:username";
    $statement = getDb()->prepare($sql);
    if (false === $statement) {
        return false;
    }
    $statement->execute([
        ':username' => $username
    ]);
    return (bool)$statement->fetchColumn();
}

function emailExists(string $email): bool
{
    $sql = "SELECT 1 FROM user WHERE email=:email";
    $statement = getDb()->prepare($sql);
    if (false === $statement) {
        return false;
    }
    $statement->execute([
        ':email' => $email
    ]);

    return (bool)$statement->fetchColumn();
}

function getUserDataForUsername(string $username): array
{
    $sql = "SELECT id,password,CONCAT_WS('-','KD',SUBSTR(username,1,3),id) AS customerNumber,activationKey,userRights
  FROM user
  WHERE username=:username";

    $statement = getDb()->prepare($sql);
    if (false === $statement) {
        return [];
    }
    $statement->execute([
        ':username' => $username
    ]);
    if (0 === $statement->rowCount()) {
        return [];
    }
    $row = $statement->fetch();
    return $row;
}

function isLoggedIn(): bool
{
    return isset($_SESSION['userId']);
}

function activateAccount(string $username, string $activationKey): bool
{
    $sql = "UPDATE user
    SET activationKey = NULL
    WHERE username=:username
    AND activationKey = :activationKey";
    $statement = getDb()->prepare($sql);
    if (false === $statement) {
        return false;
    }
    $statement->execute([
        ':username' => $username,
        ':activationKey' => $activationKey
    ]);
    $affectedRows = $statement->rowCount();
    return $affectedRows > 0;
}

function getActivationKeyByUsername(string $username): ?string
{
    $sql = "SELECT activationKey FROM user WHERE username=:username
  LIMIT 1
  ";
    $statement = getDb()->prepare($sql);
    if (false === $statement) {
        return null;
    }
    $statement->execute([
        ':username' => $username
    ]);
    if ($statement->rowCount() === 0) {
        return null;
    }
    return $statement->fetchColumn();
}

function isAdmin(): bool
{
    return isset($_SESSION['userRights']) && $_SESSION['userRights'] === 'ADMIN';
}