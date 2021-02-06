<?php

redirectIfNotLogged('/deliveryAddress/add');
$recipient = "";
$city = "";
$street = "";
$streetNumber = "";
$zipCode = "";
$recipientIsValid = true;
$cityIsValid = true;
$streetIsValid = true;
$streetNumberIsValid = true;
$zipCodeIsValid = true;
$isPost = isPost();
$errors = [];
$deliveryAddresses = getDeliveryAddressesForUser($userId);
if ($isPost) {
    $recipient = filter_input(INPUT_POST, 'recipient', FILTER_SANITIZE_SPECIAL_CHARS);
    $recipient = trim($recipient);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_SPECIAL_CHARS);
    $city = trim($city);
    $street = filter_input(INPUT_POST, 'street', FILTER_SANITIZE_SPECIAL_CHARS);
    $street = trim($street);
    $streetNumber = filter_input(INPUT_POST, 'streetNumber', FILTER_SANITIZE_SPECIAL_CHARS);
    $streetNumber = trim($streetNumber);
    $zipCode = filter_input(INPUT_POST, 'zipCode', FILTER_SANITIZE_SPECIAL_CHARS);
    $zipCode = trim($zipCode);

    if (!$recipient) {
        $errors[] = "Bitte Empfänger eintragen";
        $recipientIsValid = false;
    }
    if (!$city) {
        $errors[] = "Bitte Stadt eintragen";
        $cityIsValid = false;
    }
    if (!$street) {
        $errors[] = "Bitte Stasse eintragen";
        $streetIsValid = false;
    }
    if (!$streetNumber) {
        $errors[] = "Bitte Hausnummer eintragen";
        $streetNumberIsValid = false;
    }
    if (!$zipCode) {
        $errors[] = "Bitte PLZ Eintragen";
        $zipCodeIsValid = false;
    }
    if (count($errors) === 0) {
        $deliveryAddresId = saveDeliveryAddressForUser($userId, $recipient, $city, $zipCode, $street, $streetNumber);
        if ($deliveryAddresId > 0) {
            $_SESSION['deliveryAddressId'] = $deliveryAddresId;
            header("Location: " . $baseUrl . "index.php/selectPayment");
            exit();
        }
        $errors[] = "Fehler beim Speicher der Lieferadresse Fehlermeldung: " . printDBErrorMessage();
    }
}
$hasErrors = count($errors) > 0;

require TEMPLATES_DIR . '/selectDeliveryAddress.php';