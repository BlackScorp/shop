<?php

$routeParts = explode('/',$route);
  $productId = (int)$routeParts[3];
  $_SESSION['redirectTarget'] =$baseUrl."index.php/cart/add/".$productId;

  redirectIfNotLogged('/login');
  addProductToCart($userId,$productId);
  header("Location: ".$baseUrl."index.php");