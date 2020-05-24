<?php

function getAccessToken():string{
    if(
      isset($_SESSION['payPalAccessToken'])&&
      isset($_SESSION['payPalAccessTokenExpires']) &&
      $_SESSION['payPalAccessTokenExpires'] > time()
    ){
      return $_SESSION['payPalAccessToken'];
    }

    require_once CONFIG_DIR.'/paypal.php';

    $curl = curl_init();
    $options = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL =>PAYPAL_BASE_URL.'/v1/oauth2/token',
        CURLOPT_HTTPHEADER => [
          'Accept: application/json',
          'Accept-Language: en_US'
        ],
        CURLOPT_USERPWD=>PAYPAL_CLIENT_ID.':'.PAYPAL_SECRET,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS=>'grant_type=client_credentials'
    ];
    curl_setopt_array($curl,$options);
    $result = curl_exec($curl);
    if(curl_errno($curl)){
      curl_close($curl);
      echo curl_error($curl);
      return'';
    }
    curl_close($curl);
    $data = json_decode($result,true);
    $accessToken = $data['access_token'];

    $_SESSION['payPalAccessToken'] = $accessToken;
    $_SESSION['payPalAccessTokenExpires'] = time()+$data['expires_in'];
    return $accessToken;

}
