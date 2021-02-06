<?php

redirectIfNotLogged('/checkout');
if (!isset($_SESSION['paymentMethod'])) {
    header("Location: " . $baseUrl . "index.php/selectPayment");
    exit();
}
$userId = getCurrentUserId();
$cartItems = getCartItemsForUserId($userId);
$cartSum = getCartSumForUserId($userId);
if ($_SESSION['paymentMethod'] === 'paypal') {
    $_SESSION['paypalOrderToken'] = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_STRING);
}


require TEMPLATES_DIR . '/checkoutOverview.php';