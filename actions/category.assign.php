<?php

if (false === isAdmin()) {
    echo "Ungültiger Zugriff";
    exit();
}

$routeParts = explode('/', $route);
if (count($routeParts) !== 5) {
    echo "Ungültige URL";
    die();
}
$slug = rawurldecode($routeParts[3]);

$product = getProductBySlug($slug);
if (null === $product) {
    echo "Konnte kein passendes Produkt zum Slug:" . $slug . " finden";
    die();
}

$categoryId = (int)$routeParts[4];


$id = null;

if ($categoryId > 0) {
    $category = findCategoryById($categoryId);

    if (null === $category) {
        echo "Konnte keine Kategorie zu der ID:" . $categoryId . " finden";
        die();
    }
    $id = $category['id'];
}
$assigned = assignCategory($product['id'], $id);

$message = "Konnte " . $category['label'] . " nicht zum Produkt " . $product['title'] . " nicht zuordnen";
if ($assigned) {
    $message = $product['title'] . " gehört jetzt zu der Kategorie " . $category['label'];
}

flashMessage($message);

header("Location: " . BASE_URL . "index.php/product/edit/" . $slug);