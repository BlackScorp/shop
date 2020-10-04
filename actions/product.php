<?php

$routeParts = explode('/',$route);
 
if(count($routeParts) !== 3){
  echo "Ungültige URL";
  exit();
}
$slug = $routeParts[2];
if(0 === strlen($slug)){
  echo "Ungülites Produkt";
  exit();
}
$product = getProductBySlug($slug);
if(null === $product){
  echo "Ungülites Produkt";
  exit();
}

require_once TEMPLATES_DIR.'/productDetails.php';