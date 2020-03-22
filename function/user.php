<?php

function getCurrentUserId(){
  $userId = random_int(0,time());
  if(isset($_COOKIE['userId'])){
    $userId = (int) $_COOKIE['userId'];
  }
  if(isset($_SESSION['userId'])){
    $userId = (int) $_SESSION['userId'];
  }
  return $userId;
}
