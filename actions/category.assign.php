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


$id = null;

if ($categoryId > 0) {
    $category = findCategoryById($categoryId);

    if (null === $category) {
        echo "Konnte keine Kategorie zu der ID:" . $categoryId . " finden";
        exit();
    }
    $id = $category['id'];
    $successMessage =$product['title'] . " gehört jetzt zu der Kategorie " . $category['label'];
    $failMessage ="Konnte " . $category['label'] . " nicht zum Produkt " . $product['title'] . " nicht zuordnen";
}

$assigned = assignCategory($product['id'], $id);

if(!$category){
    $failMessage ="Kategorie konnte nicht zurückgesetzt werden";
    $successMessage ="Kategorie wurde zurückgesetzt";
    if(!$product['category_id']){
        $assigned = true;
    }
}
$message = $failMessage;
if ($assigned) {
    $message =  $successMessage;
}

flashMessage($message);

header("Location: " . BASE_URL . "index.php/product/edit/" . $slug);