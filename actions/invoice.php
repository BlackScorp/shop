<?php


$routeParts = explode('/', $route);
$invoiceId = null;
$securityKey = null;

if (isset($routeParts[2])) {
    $invoiceId = (int)$routeParts[2];
}

if (isset($routeParts[3])) {
    $securityParts = explode('.', $routeParts[3]);
    if (count($securityParts) === 2) {
        $securityKeyPath = $securityParts[0];
        $securityKeyCheck = $securityParts[1];
        $securityKeyFileName = STORAGE_DIR . '/security/key_' . $securityKeyPath . '.txt';
        if (is_file($securityKeyFileName)) {
            $checkKey = file_get_contents($securityKeyFileName);
            if ($securityKeyCheck === $checkKey) {
                $securityKey = $routeParts[3];
            }
        }
    }
}
if (!$securityKey) {
    redirectIfNotLogged('/');
}
if (!$invoiceId) {
    echo "Rechnung nicht angegeben";
    exit();
}

$userId = getCurrentUserId();
if ($securityKey) {
    $userId = null;
}

$orderData = getOrderForUser($invoiceId, $userId);

$userId = $orderData['userId'];
$orderSum = getOrderSumForUser($invoiceId, $userId);
$userData = getUserDataForId($userId);
if (!$orderData) {
    echo "Daten wurden nicht gefunden";
    exit();
}

require_once TEMPLATES_DIR . '/invoice.php';