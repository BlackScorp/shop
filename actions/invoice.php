<?php




$securityKey = null;

if(null !== $securityKeyString){
    $securityKeyString =  substr($securityKeyString,1);
    $securityParts = explode('.', $securityKeyString);
    if (count($securityParts) === 2) {
        $securityKeyPath = $securityParts[0];
        $securityKeyCheck = $securityParts[1];
        $securityKeyFileName = STORAGE_DIR . '/security/key_' . $securityKeyPath . '.txt';        
        if (is_file($securityKeyFileName)) {
            $checkKey = file_get_contents($securityKeyFileName);
            if ($securityKeyCheck === $checkKey) {
                $securityKey = $securityKeyString;
            }
        }
    }
}
if (!$securityKey) {
    redirectIfNotLogged('/');
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