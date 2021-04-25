<?php

$isAdmin = isAdmin();
$products = getAllProducts();
$flashMessages = flashMessage();
$hasFlashMessages = count($flashMessages) > 0;
logData('INFO','main.php wird jetzt ausgegeben');

