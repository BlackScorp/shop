<?php

function getCurrentUserId():?int{
  $userId = null;

  if(isset($_SESSION['userId'])){
    $userId = (int) $_SESSION['userId'];
  }
  return $userId;
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
function getUserDataForUsername(string $username):array{
  $sql ="SELECT id,password,CONCAT_WS('-','KD',SUBSTR(username,1,3),id) AS customerNumber
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
