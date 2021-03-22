<?php

if (false === isAdmin()) {
    echo "Ungültiger Zugriff";
    exit();
}


$slug = rawurldecode($slug);

$product = getProductBySlug($slug);
if (null === $product) {
    echo "Konnte kein passendes Produkt zum Slug:" . $slug . " finden";
    exit();
}


$categoryName = '';
$errors = [];
$hasErrors = false;
$flashMessages = flashMessage();
$hasFlashMessages = count($flashMessages) > 0;
$id = null;

if ($categoryId > 0) {
    $category = findCategoryById($categoryId);

    if (null === $category) {
        $message = "Konnte keine Kategorie zu der ID:" . $categoryId . " finden";
        flashMessage($message);
        header("Location: " . BASE_URL . "index.php/product/edit/" . $slug);
        exit();
    }
    $id = $category['id'];
}

if(isPost()){
    $categoryName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    if(false === (bool)$categoryName){
        $errors[]="Kategorie Name darf nicht leer sein";
    }
    if((bool)$categoryName){
        $created = createCategory($categoryName,$id);
        if($created){
            $message ="Kategorie ".$categoryName." wurde angelegt";
            flashMessage($message);
            header("Location: " . BASE_URL . "index.php/product/edit/" . $slug);
            exit();
        }
        $errors[]="Kategorie konnte nicht erstellt werden";
    }
    $hasErrors = count($errors) >0;
}

require_once TEMPLATES_DIR.'/newCategory.php';
exit();