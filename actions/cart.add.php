<?php

$routeParts = explode('/',$route);
  $productId = (int)$routeParts[3];
 
  redirectIfNotLogged("/cart/add/".$productId);
  addProductToCart($userId,$productId);
  header("Location: ".$baseUrl."index.php");