<?php

if (false === isAdmin()) {
    echo "Ungültiger Zugriff";
    exit();
}

$productName = "";
$slug = "";
$description = "";
$price = 0;
$errors = [];
$hasErrors = false;
$flashMessages = flashMessage();
$hasFlashMessages = count($flashMessages) > 0;
$blockedSlugs = [
    'new',
    'delete',
    'details',
    'edit'
];

if (isPost()) {
    $productName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $slug = filter_input(INPUT_POST, 'slug', FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
    $price = (int)filter_input(INPUT_POST, 'price');

    if (false === (bool)$productName) {
        $errors[] = "Bitte Produkt Namen angeben";
    }
    if (true === (bool)$productName && false === (bool)$slug) {
        $slug = str_replace([' ', '/'], ['-', '-'], $productName);
    }
    if (true === (bool)$slug) {
        $product = getProductBySlug($slug);
        if (null !== $product) {
            $errors[] = "Slug ist bereits vorhanden";
        }
    }
    if (in_array($slug, $blockedSlugs)) {
        $errors[] = "Slug ist reserviert, bitte einen anderen benutzen";
    }
    if (false === (bool)$description) {
        $errors[] = "Bitte Beschreibung angeben";
    }
    if ($price === 0) {
        $errors[] = "Bitte preis angeben";
    }
    $hasErrors = count($errors) > 0;
    if (false === $hasErrors) {
        $created = createProduct($productName, $slug, $description, $price);
        if (false === $created) {
            $errors[] = "Produkt konnte nicht angelegt werden";
            $hasErrors = true;
        }
        if (true === $created) {
            flashMessage('Produkt wurde erstellt');
            header("Location: " . BASE_URL . "index.php/product/new");
        }
    }
}

require_once TEMPLATES_DIR . '/newProduct.php';