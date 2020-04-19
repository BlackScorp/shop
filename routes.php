<?php
$url = $_SERVER['REQUEST_URI'];

$indexPHPPosition = strpos($url,'index.php');
$baseUrl = $url;
if(false !== $indexPHPPosition){
  $baseUrl = substr($baseUrl,0,$indexPHPPosition);
}

if(substr($baseUrl,-1) !== '/'){
  $baseUrl .='/';
}

$route = null;

if(false !== $indexPHPPosition){
  $route = substr($url,$indexPHPPosition);
  $route = str_replace('index.php','',$route);

}


$userId = getCurrentUserId();
$countCartItems = countProductsInCart($userId);

setcookie('userId',$userId,strtotime('+30 days'),$baseUrl);

if(!$route){
  $products = getAllProducts();
  require __DIR__.'/templates/main.php';
  exit();
}
if(strpos($route,'/cart/add/') !== false){
  $routeParts = explode('/',$route);
  $productId = (int)$routeParts[3];
  addProductToCart($userId,$productId);
  header("Location: ".$baseUrl."index.php");
  exit();
}
if(strpos($route,'/cart') !== false){

  $cartItems = getCartItemsForUserId($userId);
  $cartSum = getCartSumForUserId($userId);
  require __DIR__.'/templates/cartPage.php';
  exit();
}
if(strpos($route,'/login') !== false){
  $isPost = strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
  $username ="";
  $password= "";
  $errors = [];
  $hasErrors = false;
  if($isPost){

    $username = filter_input(INPUT_POST,'username',FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST,'password');

    if(false === (bool)$username){
      $errors[]="Benutzername ist leer";
    }
    if(false === (bool)$password){
      $errors[]="Passwort ist leer";
    }
    $userData = getUserDataForUsername($username);
    if((bool)$username && 0 === count($userData)){
      $errors[]="Benutzername exestiert nicht";
    }
    if((bool)$password &&
    isset($userData['password']) &&
    false === password_verify($password,$userData['password'])
  ){
    $errors[]="Passwort stimmt nicht";
  }

    if(0 === count($errors)){
      $_SESSION['userId'] = (int)$userData['id'];
      moveCartProductsToAnotherUser($_COOKIE['userId'],(int)$userData['id']);

      setcookie('userId',(int)$userData['id'],strtotime('+30 days'),$baseUrl);
      $redirectTarget = $baseUrl.'index.php';
      if(isset($_SESSION['redirectTarget'])){
        $redirectTarget = $_SESSION['redirectTarget'];
      }
      header("Location: ". $redirectTarget);
      exit();
    }


  }
  $hasErrors = count($errors) > 0;

  require __DIR__.'/templates/login.php';
  exit();
}
if(strpos($route,'/checkout') !== false){
  if(!isLoggedIn()){
    $_SESSION['redirectTarget'] = $baseUrl.'index.php/checkout';
    header("Location: ".$baseUrl."index.php/login");
    exit();
  }

  exit();
}

if(strpos($route,'/logout') !== false){
  session_regenerate_id(true);
  session_destroy();
  $redirectTarget = $baseUrl.'index.php';
  if(isset($_SESSION['redirectTarget'])){
    $redirectTarget = $_SESSION['redirectTarget'];
  }
  header("Location: ". $redirectTarget);
  exit();
}
