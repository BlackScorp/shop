<?php
$url = $_SERVER['REQUEST_URI'];

$https = $_SERVER['REQUEST_SCHEME'] === 'https';


$indexPHPPosition = strpos($url,'index.php');
$baseUrl = $url;
logData('INFO','Starte Routing');
if(false !== $indexPHPPosition){
  $baseUrl = substr($baseUrl,0,$indexPHPPosition);
  logData('INFO','Es gibt eine index.php in URL');
}

if(substr($baseUrl,-1) !== '/'){
  $baseUrl .='/';
  
}
define('BASE_URL',$baseUrl);
$projectUrl =  $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$baseUrl;

$route = null;

if(false !== $indexPHPPosition){
  $route = substr($url,$indexPHPPosition);
  $route = str_replace('index.php','',$route);

}


$userId = getCurrentUserId();
$countCartItems = countProductsInCart($userId);
$isEmail = false;

if(!$route){
  require_once __DIR__.'/actions/index.php';
  exit();
}
if(strpos($route,'/cart/add/') !== false){
  require_once __DIR__.'/actions/cart.add.php';
  exit();
}
if(strpos($route,'/cart') !== false){
  require_once __DIR__.'/actions/cart.php';
  exit();
}
if(strpos($route,'/login') !== false){
  require_once __DIR__.'/actions/login.php';
  exit();
}
if(strpos($route,'/checkout') !== false){
  require_once __DIR__.'/actions/checkout.php';
  exit();
}

if(strpos($route,'/logout') !== false){
  require_once __DIR__.'/actions/logout.php';
  exit();
}
if(strpos($route,'/selectDeliveryAddress') !== false){
  require_once __DIR__.'/actions/selectDeliveryAddress.php';
  exit();
}
if(strpos($route,'/deliveryAddress/add') !== false){
  require_once __DIR__.'/actions/deliveryAddress.add.php';
  exit();
}

if(strpos($route,'/selectPayment') !== false){
  require_once __DIR__.'/actions/selectPayment.php';
  exit();
}

if(strpos($route,'/paymentComplete') !== false){
  require_once __DIR__.'/actions/paymentComplete.php';
  exit();
}

if(strpos($route,'/completeOrder') !== false){
  require_once __DIR__.'/actions/completeOrder.php';
  exit();
}
if(strpos($route,'/register') !== false){
  require_once __DIR__.'/actions/register.php';
  exit();
}

if(strpos($route,'/invoice') !== false){
  require_once __DIR__.'/actions/invoice.php';
  exit();
}

if(strpos($route,'/account/activate') !== false){
  require_once __DIR__.'/actions/account.activate.php';
  exit();
}

if(strpos($route,'/activationMail') !== false){
  require_once __DIR__.'/actions/activationMail.php';
  exit();
}
if(strpos($route,'/product/new') !== false){
  require_once __DIR__.'/actions/product.new.php';
  exit();
}
if(strpos($route,'/product') !== false){
  require_once __DIR__.'/actions/product.php';
  exit();
}
