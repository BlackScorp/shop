<?php



if (count($routeParts) !== 3) {
    echo "Ungültige URL";
    exit();
}
$slug = rawurldecode($routeParts[2]);
if (0 === strlen($slug)) {
    echo "ungültiges Produkt";
    exit();
}
$product = getProductBySlug($slug);
if (null === $product) {
    echo "ungültiges Produkt";
    exit();
}

require_once TEMPLATES_DIR . '/productDetails.php';