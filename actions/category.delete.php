<?php

$routeParts = explode('/', $route);
$categoryId =  (int)$routeParts[2];

$category = findCategoryById($categoryId);
if(!$category){
    echo "Category ".$categoryId." nicht gefunden";
    die();
}
$_SESSION['deleteCategory'] = $category;

require_once __DIR__.'/product.edit.php';