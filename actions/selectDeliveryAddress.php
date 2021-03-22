<?php

redirectIfNotLogged('/checkout');



if (deliveryAddressBelongsToUser($deliveryAddressId, $userId)) {
    $_SESSION['deliveryAddressId'] = $deliveryAddressId;
    header("Location: " . $baseUrl . "index.php/selectPayment");
    exit();
}
header("Location: " . $baseUrl . "index.php/checkout");