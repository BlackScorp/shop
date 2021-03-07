<?php

redirectIfNotLogged('/checkout');
if (!isset($_SESSION['paymentMethod'])) {
    header("Location: " . $baseUrl . "index.php/selectPayment");
    exit();
}
if (!isset($_SESSION['deliveryAddressId'])) {
    header("Location: " . $baseUrl . "index.php/checkout");
    exit();
}
$userId = getCurrentUserId();
$cartItems = getCartItemsForUserId($userId);

$functionName = $_SESSION['paymentMethod'] . 'PaymentComplete';
$parameter = [];
$defaultStatus = "new";
if ($_SESSION['paymentMethod'] === 'paypal') {
    $defaultStatus="payed";
    $parameter = [
        $_SESSION['paypalOrderToken']
    ];
}
call_user_func_array($functionName, $parameter);
$deliveryAddressData = getDeliveryAddressDataForUser($_SESSION['deliveryAddressId'], $userId);


if (createOrder($userId, $cartItems, $deliveryAddressData,$defaultStatus)) {
    clearCartForUser($userId);
    $invoiceId = invoiceId();
    $invoiceUrl = $projectUrl . 'index.php/invoice/' . $invoiceId;
    $pdfPath = STORAGE_DIR . '/invoices/invoice-' . $invoiceId . '.pdf';
    $created = createPdfFromUrl($invoiceUrl, $pdfPath);
    $userData = getUserDataForId($userId);
    unset($_SESSION['paymentMethod']);
    unset($_SESSION['deliveryAddressId']);
    if ($created) {
        $message = new Swift_Message('Bestellung erfolgreich');
        $body = <<< TEXT
      Vielen Dank für Ihre Bestellung\n
      Im Anhang befindet sich die Rechnung\n
      TEXT;

        $message->setBody($body, 'plain/text');
        $message->attach(Swift_Attachment::fromPath($pdfPath));
        $message->setTo($userData['email']);
        $message->setFrom([MAIL_NOREPLY => 'Mein Shop']);
        $send = sendMail($message);
        if ($send) {
            require TEMPLATES_DIR . '/thankyYouPage.php';
            exit();
        }
    }
}

require TEMPLATES_DIR . '/errorPages/CompleteOrder.php';
exit();