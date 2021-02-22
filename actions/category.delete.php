<?php


$categoryId =  (int)$routeParts[2];
$slug = $routeParts[3];
$category = findCategoryById($categoryId);
if(!$category){
    echo "Category ".$categoryId." nicht gefunden";
    exit();
}
$product = getProductBySlug($slug);
if(!$product){
    echo "Slug ".$slug." is nicht gültig";
    exit();
}
$_SESSION['deleteCategory'] = $category;
$_SESSION['redirectUrl'] = BASE_URL.'index.php/product/edit/'. $slug;
require_once __DIR__.'/product.edit.php';