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

$parentCategories = [];
getParentCategory((int)$product['category_id'], $parentCategories);
array_shift($parentCategories);
asort($parentCategories);

$categories = getCategories((int)$product['category_id']);

$productName = $product['title'];
$slug = $product['slug'];
$originalSlug = $slug;
$productCategoryId = (int)$product['category_id'];
$description = $product['description'];
$price = $product['price'];
$id = $product['id'];
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
$isLive = $product['status'] === 'LIVE';
$prorductImages = [];
$picutrePath = STORAGE_DIR . '/productPictures/' . $slug . '/';
foreach (glob($picutrePath . '*') as $filePath) {
    $prorductImages[] = basename($filePath);
}
$showCategoryDeleteModal = isset($_SESSION['deleteCategory']);
if($showCategoryDeleteModal){
    $deleteCategoryLabel = $_SESSION['deleteCategory']['label'];
}
if (isPost()) {
    $productName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $slug = filter_input(INPUT_POST, 'slug', FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
    $price = (int)filter_input(INPUT_POST, 'price');
    $isLive = (bool)filter_input(INPUT_POST, 'activate');
    $pictures = $_FILES['picture'];
    $pictures = normalizeFiles($pictures);

    if (false === (bool)$productName) {
        $errors[] = "Bitte Produkt Namen angeben";
    }
    if (true === (bool)$productName && false === (bool)$slug) {
        $slug = str_replace([' ', '/'], ['-', '-'], $productName);
    }

    if (true === (bool)$slug &&
        $slug !== $originalSlug
    ) {
        $product = getProductBySlug($slug);
        if (null !== $product) {
            $errors[] = "Slug ist bereits vorhanden";
        }
    }
    $hasPictures = count($pictures) > 0;
    if ($hasPictures) {
        $allowedTypes = ['image/jpeg', 'image/png'];

        foreach ($pictures as $number => $picture) {
            $type = $picture['type'];
            if (!in_array($type, $allowedTypes)) {
                $errors[] = "Das Bild nr:" . $number . " hat den typen " . $type . " und dieser ist nicht erlaubt";
            }
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
    $updateSuccess = false;
    if (false === $hasErrors) {
        $created = editProduct($id, $productName, $slug, $description, $price,$isLive);
        $imageUploadSuccessful = false;
        if ($hasPictures) {
            $imageUploadSuccessful = uploadProductPictures($slug, $pictures);
        }

        if (false === $created) {
            $errors[] = "Produkt konnte nicht bearbeitet werden";
            $hasErrors = true;
        }
        $updateSuccess = true === $created ||
            ($hasPictures && $imageUploadSuccessful);

        if (false === isAjax()) {
            if ($updateSuccess) {
                flashMessage('Produkt wurde bearbeitet');
                header("Location: " . BASE_URL . "index.php/product/edit/" . $slug);
            }
        }
    }
    if (true === isAjax()) {
        $response = [
            'successed' => $updateSuccess,
            'hasErrors' => $hasErrors,
            'errors' => $errors,
            'pictures' => uploadedPictures()
        ];
        echo json_encode($response);
        exit();
    }
}

require_once TEMPLATES_DIR . '/editProduct.php';