<?php

$cartItems = getCartItemsForUserId($userId);
$cartSum = getCartSumForUserId($userId);
require TEMPLATES_DIR.'/cartPage.php';