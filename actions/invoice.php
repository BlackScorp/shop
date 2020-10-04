<?php

redirectIfNotLogged('/');
$routeParts =  explode('/',$route);
  $invoiceId = null;
if(isset($routeParts[2])){
  $invoiceId=(int)$routeParts[2];
}
if(!$invoiceId){
echo "Rechnung nicht angegeben";
  exit();
}
$userId = getCurrentUserId();

$orderData = getOrderForUser($invoiceId,$userId);
$orderSum = getOrderSumForUser($invoiceId,$userId);
$userData = getUserDataForId($userId);
if(!$orderData){
  echo "Daten wurden nicht gefunden";
  exit();
}

require_once TEMPLATES_DIR.'/invoice.php';