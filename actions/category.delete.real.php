<?php

if(!isset($_SESSION['deleteCategory'])){
    echo "Ungültige URL";
    exit();
}
$category = $_SESSION['deleteCategory'];
$deleted = deleteCategory($category['id']);
$redirectUrl = $_SESSION['redirectUrl'];

$message = "Kategorie konnte nicht gelöscht werden";
if($deleted){
    $message = "Kategorie ".$category['label']." wurde gelöscht";
    unset($_SESSION['deleteCategory']);
}
unset($_SESSION['redirectUrl']);
flashMessage($message);

header('Location: '.$redirectUrl);
