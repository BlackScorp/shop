<?php
redirectIfNotLogged('/checkout');
  $recipient = "";
  $city ="";
  $street = "";
  $streetNumber ="";
  $zipCode ="";
  $recipientIsValid = true;
  $cityIsValid = true;
  $streetIsValid =true;
  $streetNumberIsValid = true;
  $zipCodeIsValid = true;
  $errors = [];
  $hasErrors = count($errors) >0;
  $deliveryAddresses = getDeliveryAddressesForUser($userId);
  require TEMPLATE_DIR.'/selectDeliveryAddress.php';