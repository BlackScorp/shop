<?php
//EINGABE
$slug = rawurldecode($slug);
$product = getProductBySlug($slug);
if(!$product){
    echo "Unbekanntes Produkt";
    logData('WARNING','Unbekanntes Produkt',['slug'=>$slug]);
    exit();
}
$reviews = getPublicReviewsByProductId((int)$product['id']);

//VERARBEITUNG

//AUSGABE
require_once TEMPLATES_DIR.'/reviews.php';