<?php

function isPost():bool{
  return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
}

function escape(string $value):string{
  return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function redirectIfNotLogged(string $sourceTarget){
  if(isLoggedIn()){
    return;
  }
    $_SESSION['redirectTarget'] = BASE_URL.'index.php'.$sourceTarget;
    header("Location: ".BASE_URL."index.php/login");
    exit();
}
function flashMessage(?string $message = null){
  if(!isset($_SESSION['messages'])){
    $_SESSION['messages'] = [];
  }
  if(!$message){
    $messages =  $_SESSION['messages'];
    $_SESSION['messages'] = [];
    return $messages;
  }
  $_SESSION['messages'][]=$message;

}

function convertToMoney(int $cent):string{
  $money = $cent/100;
  return number_format($money,2,","," ");
}
