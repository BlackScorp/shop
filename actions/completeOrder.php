<?php

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
    $invoiceId = invoiceId();
    $invoiceUrl = $projectUrl.'index.php/invoice/'.$invoiceId;
    createPdfFromUrl($invoiceUrl,STORAGE_DIR.'/invoices/invoice-'.$invoiceId.'.pdf');
    require TEMPLATES_DIR.'/thankyYouPage.php';
    exit();
  }

  //