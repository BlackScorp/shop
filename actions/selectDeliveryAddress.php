<?php

redirectIfNotLogged('/checkout');

$routeParts = explode('/',$route);
$deliveryAddressId = (int)$routeParts[2];
if(deliveryAddressBelongsToUser($deliveryAddressId,$userId)){
  $_SESSION['deliveryAddressId'] = $deliveryAddressId;
  header("Location: ".$baseUrl."index.php/selectPayment");
  exit();
}
header("Location: ".$baseUrl."index.php/checkout");