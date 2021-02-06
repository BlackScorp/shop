<?php

redirectIfNotLogged('/selectPayment');
if (!isset($_SESSION['deliveryAddressId'])) {
    header("Location: " . $baseUrl . "index.php/checkout");
    exit();
}
$errors = [];
$avaliablePaymentMethods = [
    "paypal" => "PayPal",
    "vorkasse" => "Vorkasse"
];
if (isPost()) {
    $paymentMethod = filter_input(INPUT_POST, 'paymentMethod', FILTER_SANITIZE_STRING);

    if (!$paymentMethod) {
        $errors[] = "Bitte bezahl methode auswählen";
    }
    if ($paymentMethod && !in_array($paymentMethod, array_keys($avaliablePaymentMethods))) {
        $errors[] = "Ungültige Auswahl";
    }
    $deliveryAddressData = getDeliveryAddressDataForUser($_SESSION['deliveryAddressId'], getCurrentUserId());
    if (!$deliveryAddressData) {
        $errors[] = "Ausgewälte Lieferadresse wurde nicht gefunden";
    }
    $cartProducts = getCartItemsForUserId(getCurrentUserId());
    if (count($cartProducts) === 0) {
        $errors[] = "Warenkorb ist leer";
    }
    if (count($errors) === 0) {
        $functionName = $paymentMethod . 'CreateOrder';
        $_SESSION['paymentMethod'] = $paymentMethod;
        call_user_func_array($functionName, [$deliveryAddressData, $cartProducts]);
    }
}

$hasErrors = count($errors) > 0;
require TEMPLATES_DIR . '/selectPayment.php';