<?php
if(!isPost()){
    echo "Ungültige URL";
    die();
}

if(!isset($_SESSION['deleteCategory'])){
    echo "Ungültige URL";
    die();
}
$category = $_SESSION['deleteCategory'];
$deleted = deleteCategory($category['id']);

$message = "Kategorie konnte nicht gelöscht werden";
if($deleted){
    $message = "Kategorie ".$category['label']." wurde gelöscht";
    unset($_SESSION['deleteCategory']);
}
flashMessage($message);
header('Location: '.BASE_URL.'index.php');
