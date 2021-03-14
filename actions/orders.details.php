<?php
if(!isAdmin()){
    echo 'Kein Zugriff';
    exit();
}
$orderId = (int)$routeParts[3];

$orderDetails = getOrderForUser($orderId);
$customer = getUserDataForId((int)$orderDetails['userId']);
$invoiceLink = BASE_URL . 'storage/invoices/invoice-' . $orderId . '.pdf';

require_once TEMPLATES_DIR.'/orderDetails.php';