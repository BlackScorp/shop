<?php

$routeParts = explode('/',$route);
if(count($routeParts) !== 5){
  echo "Ungültige URL";
  exit();
}
$username  = $routeParts[3];
$activationKey = $routeParts[4];

$activated = activateAccount($username,$activationKey);
if(false === $activated){
  echo "Ungültiger Account";
  exit();
}
flashMessage("Account wurde aktiviert");
header("Location: ".$baseUrl."index.php");