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
define('BASE_URL',$baseUrl);

$route = null;

if(false !== $indexPHPPosition){
  $route = substr($url,$indexPHPPosition);
  $route = str_replace('index.php','',$route);

}


$userId = getCurrentUserId();
$countCartItems = countProductsInCart($userId);


if(!$route){
  $products = getAllProducts();
  $flashMessages = flashMessage();
  $hasFlashMessages = count($flashMessages)> 0;
  require __DIR__.'/templates/main.php';
  exit();
}
if(strpos($route,'/cart/add/') !== false){

  $routeParts = explode('/',$route);
  $productId = (int)$routeParts[3];
  $_SESSION['redirectTarget'] =$baseUrl."index.php/cart/add/".$productId;

  redirectIfNotLogged('/login');
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
  $isPost = isPost();
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
  require __DIR__.'/templates/selectDeliveryAddress.php';
  exit();
}

if(strpos($route,'/logout') !== false){
  $redirectTarget = $baseUrl.'index.php';
  if(isset($_SESSION['redirectTarget'])){
    $redirectTarget = $_SESSION['redirectTarget'];
  }
  session_regenerate_id(true);
  session_destroy();
  header("Location: ". $redirectTarget);
  exit();
}
if(strpos($route,'/selectDeliveryAddress') !== false){
  redirectIfNotLogged('/checkout');

  $routeParts = explode('/',$route);
  $deliveryAddressId = (int)$routeParts[2];
  if(deliveryAddressBelongsToUser($deliveryAddressId,$userId)){
    $_SESSION['deliveryAddressId'] = $deliveryAddressId;
    header("Location: ".$baseUrl."index.php/selectPayment");
    exit();
  }
  header("Location: ".$baseUrl."index.php/checkout");
  exit();
}
if(strpos($route,'/deliveryAddress/add') !== false){
    redirectIfNotLogged('/deliveryAddress/add');
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
  $isPost = isPost();
  $errors = [];
  $deliveryAddresses = getDeliveryAddressesForUser($userId);
  if($isPost){
    $recipient = filter_input(INPUT_POST,'recipient',FILTER_SANITIZE_SPECIAL_CHARS);
    $recipient = trim($recipient);
    $city = filter_input(INPUT_POST,'city',FILTER_SANITIZE_SPECIAL_CHARS);
    $city = trim($city);
    $street = filter_input(INPUT_POST,'street',FILTER_SANITIZE_SPECIAL_CHARS);
    $street = trim($street);
    $streetNumber = filter_input(INPUT_POST,'streetNumber',FILTER_SANITIZE_SPECIAL_CHARS);
    $streetNumber = trim($streetNumber);
    $zipCode = filter_input(INPUT_POST,'zipCode',FILTER_SANITIZE_SPECIAL_CHARS);
    $zipCode = trim($zipCode);

    if(!$recipient){
      $errors[]="Bitte Empfänger eintragen";
      $recipientIsValid = false;
    }
    if(!$city){
      $errors[]="Bitte Stadt eintragen";
      $cityIsValid = false;
    }
    if(!$street){
      $errors[]="Bitte Stasse eintragen";
      $streetIsValid = false;
    }
    if(!$streetNumber){
      $errors[]="Bitte Hausnummer eintragen";
      $streetNumberIsValid = false;
    }
    if(!$zipCode){
      $errors[]="Bitte PLZ Eintragen";
      $zipCodeIsValid = false;
    }
    if(count($errors) === 0){
      $deliveryAddresId = saveDeliveryAddressForUser($userId,$recipient,$city,$zipCode,$street,$streetNumber);
      if($deliveryAddresId > 0){
        $_SESSION['deliveryAddressId'] = $deliveryAddresId;
        header("Location: ".$baseUrl."index.php/selectPayment");
        exit();
      }
      $errors[]="Fehler beim Speicher der Lieferadresse Fehlermeldung: ".printDBErrorMessage();
    }
  }
  $hasErrors = count($errors) > 0;

  require __DIR__.'/templates/selectDeliveryAddress.php';
  exit();
}

if(strpos($route,'/selectPayment') !== false){
  redirectIfNotLogged('/selectPayment');
  if(!isset($_SESSION['deliveryAddressId'])){
    header("Location: ".$baseUrl."index.php/checkout");
    exit();
  }
  $errors = [];
  $avaliablePaymentMethods = [
    "paypal"=>"PayPal",
    "vorkasse" => "Vorkasse"
  ];
  if(isPost()){
    $paymentMethod = filter_input(INPUT_POST,'paymentMethod',FILTER_SANITIZE_STRING);

    if(!$paymentMethod){
      $errors[]="Bitte bezahl methode auswählen";
    }
    if($paymentMethod && !in_array($paymentMethod,array_keys($avaliablePaymentMethods))){
      $errors[]="Ungültige Auswahl";
    }
    $deliveryAddressData = getDeliveryAddressDataForUser($_SESSION['deliveryAddressId'],getCurrentUserId());
    if(!$deliveryAddressData){
        $errors[]="Ausgewälte Lieferadresse wurde nicht gefunden";
    }
      $cartProducts = getCartItemsForUserId(getCurrentUserId());
      if(count($cartProducts) === 0){
        $errors[]="Warenkorb ist leer";
      }
    if(count($errors) === 0){
      $functionName =   $paymentMethod.'CreateOrder';
      $_SESSION['paymentMethod'] = $paymentMethod;
      call_user_func_array($functionName,[$deliveryAddressData,$cartProducts]);
    }

  }

  $hasErrors = count($errors) > 0;
  require __DIR__.'/templates/selectPayment.php';
  exit();
}

if(strpos($route,'/paymentComplete') !== false){
  redirectIfNotLogged('/checkout');
  if(!isset($_SESSION['paymentMethod'])){
    header("Location: ".$baseUrl."index.php/selectPayment");
    exit();
  }
  $userId = getCurrentUserId();
  $cartItems = getCartItemsForUserId($userId);
  $cartSum = getCartSumForUserId($userId);
  if($_SESSION['paymentMethod'] === 'paypal'){
    $_SESSION['paypalOrderToken'] = filter_input(INPUT_GET,'token',FILTER_SANITIZE_STRING);
  }


  require __DIR__.'/templates/checkoutOverview.php';

  exit();
}

if(strpos($route,'/completeOrder') !== false){
  redirectIfNotLogged('/checkout');
  if(!isset($_SESSION['paymentMethod'])){
    header("Location: ".$baseUrl."index.php/selectPayment");
    exit();
  }
  if(!isset($_SESSION['deliveryAddressId'])){
    header("Location: ".$baseUrl."index.php/checkout");
    exit();
  }
  $userId = getCurrentUserId();
  $cartItems =  getCartItemsForUserId($userId);

  $functionName =   $_SESSION['paymentMethod'].'PaymentComplete';
  $parameter =[];
  if($_SESSION['paymentMethod'] === 'paypal'){
    $parameter=[
      $_SESSION['paypalOrderToken']
    ];
  }
  call_user_func_array($functionName,  $parameter);
  $deliveryAddressData  = getDeliveryAddressDataForUser($_SESSION['deliveryAddressId'],$userId);

  if(createOrder($userId,$cartItems,$deliveryAddressData)){
    clearCartForUser($userId);
    require __DIR__.'/templates/thankyYouPage.php';
    exit();
  }

  //
}
if(strpos($route,'/register') !== false){
  $username = "";
  $email = "";
  $emailRepeat = "";
  $password ="";
  $passwordRepeat ="";
  $errors = [];


  if(isPost()){
     $username = filter_input(INPUT_POST,'username',FILTER_SANITIZE_SPECIAL_CHARS);
     $password = filter_input(INPUT_POST,'password');
     $passwordRepeat = filter_input(INPUT_POST,'passwordRepeat');
     $email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
     $emailRepeat = filter_input(INPUT_POST,'emailRepeat',FILTER_SANITIZE_EMAIL);

     if(false === (bool)$username){
       $errors[]="Benutzername ist leer";
     }

     if(false === (bool)$password){
       $errors[]="Passwort ist leer";
     }
     if(true === (bool)$username){
       if(mb_strlen($username) < 4){
         $errors []="Benutzername ist zu kurz, mindestens 4 Zeichen";
       }
       if(mb_strlen($username) > 10){
         $errors []="Benutzername ist zu lang, maximal 10 Zeichen";
       }
       $usernameExists = usernameExists($username);
       if(true === $usernameExists){
         $errors[]="Benutzername bereits exestiert";
       }
     }
     if(true === (bool)$password){
       if(mb_strlen($password) < 6){
         $errors[]="Passwort ist zu kurz";
       }
     }
     if($password !== $passwordRepeat){
       $errors[]="Passwörter stimmen nicht überein";
     }
     if(false === (bool)$email){
       $errors[]="Email ist leer";
     }
     if(true === (bool)$email){

       if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
         $errors[]="Email ist nicht gültig";
       }
       $emailExists = emailExists($email);
    
       if(true === $emailExists){
         $errors[]="E-Mail bereits exestiert";
       }
     }
     if($email !== $emailRepeat){
       $errors[]="Email adressen stimmen nicht überein";
     }

     $hasErrors = count($errors)> 0;
     if(false === $hasErrors){
       $created = createAccount($username,$password,$email);
       if(!$created){
            $errors[]="Account konnte nicht angelegt werden, versuchen Sie es später erneut";
       }
       if($created){
         flashMessage("Account wurde erstellt");
         header("Location: ".$baseUrl."index.php");
       }
     }
  }
  $hasErrors = count($errors)> 0;
  require_once __DIR__.'/templates/register.php';
  exit();
}

if(strpos($route,'/invoice') !== false){
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

require_once __DIR__.'/templates/invoice.php';
exit();
}
