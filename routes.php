<?php
$url = $_SERVER['REQUEST_URI'];
$indexPHPPosition = strpos($url,'index.php');
$route = substr($url,$indexPHPPosition);
$route = str_replace('index.php','',$route);

if(strpos($route,'/cart/add/') !== false){
  $routeParts = explode('/',$route);
  $productId = (int)$routeParts[3];

  addProductToCart($userId,$productId);
  header("Location: /shop/index.php");
  exit();
}
