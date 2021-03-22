<?php



$slug = rawurldecode($slug);

$product = getProductBySlug($slug);
if (null === $product) {
    echo "ungültiges Produkt";
    exit();
}

require_once TEMPLATES_DIR . '/productDetails.php';