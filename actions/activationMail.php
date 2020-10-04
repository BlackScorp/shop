<?php

$routeParts = explode('/',$route);
  if(count($routeParts) !== 4){
    echo "Ungültige URL";
    exit();
  }
  
  $username  = $routeParts[2];
  $activationKey = getActivationKeyByUsername($username);
  if(null === $activationKey){
    echo "Account ist aktiviert";
    exit();
  }
 


  $isEmail = true;
  $registrationDate = date('d.M.Y');
  $acitvationLink = $projectUrl.'index.php/account/activate/'.$username.'/'.$activationKey;
  $currentYear = date('Y');

  require_once TEMPLATES_DIR.'/activationMail.php';
  