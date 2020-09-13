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

function getRandomHash(int $length):string{
  $randomInt = random_int(0,time()); 
  $hash = md5($randomInt); 
  $start = random_int(0,strlen($hash)-$length);
  $hashShort = substr($hash,$start,$length);
  return $hashShort;
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

function sendMail(Swift_Message $message):bool{


  $transport = new Swift_SmtpTransport('smtp.gmail.com', 465,'ssl');
  $transport->setUsername(SMTP_USERNAME);
  $transport->setPassword(SMTP_PASSWORD);  

  $mailer = new Swift_Mailer($transport);
  return $mailer->send($message);
}