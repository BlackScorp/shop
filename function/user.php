<?php

function getCurrentUserId():?int{
  $userId = null;

  if(isset($_SESSION['userId'])){
    $userId = (int) $_SESSION['userId'];
  }
  return $userId;
}
function createAccount(string $username,string $password,string $email):bool{
  $password = password_hash($password,PASSWORD_DEFAULT);

  $sql ="INSERT INTO user SET
  username=:username,
  password=:password,
  email = :email,
  activationKey = :activationKey";

  $statement = getDb()->prepare($sql);
  if(false === $statement){
    return false;
  }
  $activationKey = getRandomHash(8);
   $statement->execute([
    ':username'=>$username,
    ':password'=>$password,
    ':email'=>$email,
    ':activationKey'=>$activationKey
  ]);
  $affectedRows = $statement->rowCount();

  return $affectedRows > 0;

}
function getUserDataForId(?int $userId):array{
  if(null === $userId){
    $userId = getCurrentUserId();
  }

  $sql ="SELECT id,password,CONCAT_WS('-','KD',SUBSTR(username,1,3),id) AS customerNumber
  FROM user
  WHERE id=:id";

  $statement = getDb()->prepare($sql);
  if(false === $statement){
    return [];
  }
  $statement->execute([
    ':id'=>$userId
  ]);
  if(0 === $statement->rowCount()){
    return  [];
  }
  $row = $statement->fetch();
  return $row;
}
function usernameExists(string $username):bool{
  $sql ="SELECT 1 FROM user WHERE username=:username";
  $statement = getDb()->prepare($sql);
  if(false === $statement){
    return false;
  }
  $statement->execute([
    ':username'=>$username
  ]);
  return (bool)$statement->fetchColumn();
}
function emailExists(string $email):bool{
  $sql ="SELECT 1 FROM user WHERE email=:email";
  $statement = getDb()->prepare($sql);
  if(false === $statement){

    return false;
  }
  $statement->execute([
    ':email'=>$email
  ]);

  return (bool)$statement->fetchColumn();
}
function getUserDataForUsername(string $username):array{
  $sql ="SELECT id,password,CONCAT_WS('-','KD',SUBSTR(username,1,3),id) AS customerNumber,activationKey
  FROM user
  WHERE username=:username";

  $statement = getDb()->prepare($sql);
  if(false === $statement){
    return [];
  }
  $statement->execute([
    ':username'=>$username
  ]);
  if(0 === $statement->rowCount()){
    return  [];
  }
  $row = $statement->fetch();
  return $row;
}

function isLoggedIn():bool{
  return isset($_SESSION['userId']);
}

function activateAccount(string $username,string $activationKey):bool{
    $sql ="UPDATE user
    SET activationKey = NULL
    WHERE username=:username
    AND activationKey = :activationKey";
    $statement = getDb()->prepare($sql);
    if(false === $statement){
      return false;
    }
    $statement->execute([
      ':username'=>$username,
      ':activationKey'=>$activationKey
    ]);
    $affectedRows = $statement->rowCount();
    return $affectedRows > 0;
}