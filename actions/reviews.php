<?php
//EINGABE
$slug = rawurldecode($slug);
$product = getProductBySlug($slug);
if(!$product){
    echo "Unbekanntes Produkt";
    logData('WARNING','Unbekanntes Produkt',['slug'=>$slug]);
    exit();
}
$productId = (int)$product['id'];
$reviews = getPublicReviewsByProductId($productId);
$isLoggedIn = isLoggedIn();
$maxRating = 5;

$errors = [];
$hasErrors = false;
$rating = null;
$flashMessages = flashMessage();
$hasFlashMessages = count($flashMessages) > 0;
$title = '';
$text = '';
//VERARBEITUNG
if(isPost()){
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_SPECIAL_CHARS);
    $rating = filter_input(INPUT_POST, 'rating', FILTER_SANITIZE_NUMBER_INT);
    $userHasRatedProduct = userHasRatedProduct($userId,$productId);
    if(false === $userHasRatedProduct ){
        if (false === (bool)$title) {
            $errors[] = "Titel ist leer";
        }
        if (false === (bool)$text) {
            $errors[] = "Text ist leer";
        }
        if (false === (bool)$rating) {
            $errors[] = "Bitte eine Bewertung abgeben";
        }
    }
    if(true === $userHasRatedProduct){
        $errors[]="Du hast das Produkt bereits bewertet";
    }

    $hasErrors = count($errors)>0;
    if(false === $hasErrors){
        $saved = saveReview($userId,$productId,$rating,$title,$text);
        if(false === $saved){
            $errors[] = "Konnte eine Bewertung nicht abgeben, versuchen Sie es später noch ein Mal";
        }
        if(true === $saved){
            flashMessage('Vielen dank für ihre Bewertung, sie muss noch freigeschaltet werden');
            header("Location: " . BASE_URL . "index.php/reviews/" . $slug);
            exit();
        }
        $hasErrors = count($errors)>0;
    }
    
    $rating = (int)$rating;
}


//AUSGABE
require_once TEMPLATES_DIR.'/reviews.php';