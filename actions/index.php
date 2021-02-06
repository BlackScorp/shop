<?php

$isAdmin = isAdmin();
$products = getAllProducts();
$flashMessages = flashMessage();
$hasFlashMessages = count($flashMessages) > 0;
logData('INFO', 'Die Startseite wurde aufgerufen', [
    'aktuelleUserId' => $userId,
    'produktListe' => $products
]);
require TEMPLATES_DIR . '/main.php';