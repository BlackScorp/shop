<?php

function getAccessToken(): string
{
    if (
        isset($_SESSION['payPalAccessToken']) &&
        isset($_SESSION['payPalAccessTokenExpires']) &&
        $_SESSION['payPalAccessTokenExpires'] > time()
    ) {
        return $_SESSION['payPalAccessToken'];
    }

    if (!file_exists(CONFIG_DIR . '/paypal.php')) {
        redirectMissingConfig('config/paypal.php');
    }
    require_once CONFIG_DIR . '/paypal.php';

    $curl = curl_init();
    $options = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => PAYPAL_BASE_URL . '/v1/oauth2/token',
        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
            'Accept-Language: en_US'
        ],
        CURLOPT_USERPWD => PAYPAL_CLIENT_ID . ':' . PAYPAL_SECRET,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => 'grant_type=client_credentials'
    ];
    curl_setopt_array($curl, $options);
    $result = curl_exec($curl);
    if (curl_errno($curl)) {
        echo curl_error($curl);
        curl_close($curl);
        return '';
    }
    curl_close($curl);
    $data = json_decode($result, true);
    $accessToken = $data['access_token'];

    $_SESSION['payPalAccessToken'] = $accessToken;
    $_SESSION['payPalAccessTokenExpires'] = time() + $data['expires_in'];
    return $accessToken;
}

function getMoneyObject(string $value, string $currecyCode = "EUR"): stdClass
{
    $object = new stdClass();
    $object->value = number_format($value, 2);
    $object->currency_code = $currecyCode;
    return $object;
}

function productToPayPalItem(array $product): stdClass
{
    $item = new stdClass();
    $item->name = $product['title'];
    $price = $product['price'];
    $tax = $price * 0.19;
    $netPrice = ($price - $tax);

    $item->unit_amount = getMoneyObject($netPrice / 100);
    $item->tax = getMoneyObject($tax / 100);

    $item->quantity = $product['quantity'];
    $item->category = 'PHYSICAL_GOODS';
    $item->description = $product['description'];
    return $item;
}

function paypalCreateOrder(array $deliveryAddressData, array $products)
{
    if (!file_exists(CONFIG_DIR . '/paypal.php')) {
        redirectMissingConfig('config/paypal.php');
    }
    require_once CONFIG_DIR . '/paypal.php';
    $accessToken = getAccessToken();

    $payer = new stdClass();
    $payer->name = new stdClass();
    $payer->name->given_name = $deliveryAddressData['recipient'];
    $payer->address = new stdClass();
    $payer->address->address_line_1 = $deliveryAddressData['streetNumber'] . ' ' . $deliveryAddressData['street'];
    $payer->address->admin_area_2 = $deliveryAddressData['city'];
    $payer->address->postal_code = $deliveryAddressData['zipCode'];
    $payer->address->admin_area_1 = "Deutschland";
    $payer->address->country_code = "DE";

    $object = new stdClass();

    $object->items = [];
    $totalValue = 0;
    $itemsTotal = 0;
    $taxTotal = 0;
    foreach ($products as $product) {
        $item = productToPayPalItem($product);
        $object->items[] = $item;
        $itemsTotal += $item->unit_amount->value * (int)$product['quantity'];
        $taxTotal += $item->tax->value * (int)$product['quantity'];
        $totalValue += (int)$product['price'] * (int)$product['quantity'];
    }
    $totalValue = $totalValue / 100;
    $amountObject = getMoneyObject($totalValue);

    $amountObject->breakdown = new stdClass();
    $amountObject->breakdown->item_total = getMoneyObject($itemsTotal);
    $amountObject->breakdown->tax_total = getMoneyObject($taxTotal);


    $object->amount = $amountObject;

    $object->shipping = new stdClass();
    $object->shipping->address = $payer->address;

    $applicationContext = new stdClass();
    $applicationContext->shipping_preference = "SET_PROVIDED_ADDRESS";
    $applicationContext->return_url = "http://localhost/shop/index.php/paymentComplete";
    $applicationContext->cancel_url = "http://localhost/shop/index.php/cart";

    $data = [
        "payer" => $payer,
        "application_context" => $applicationContext,
        "intent" => "CAPTURE",
        "purchase_units" => [

            $object
        ]
    ];

    $dataString = json_encode($data);

    $curl = curl_init();
    $options = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => PAYPAL_BASE_URL . '/v2/checkout/orders',
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $accessToken
        ],

        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $dataString
    ];
    curl_setopt_array($curl, $options);
    $result = curl_exec($curl);
    if (curl_errno($curl)) {
        echo curl_error($curl);
        curl_close($curl);
        return '';
    }
    curl_close($curl);
    $data = json_decode($result, true);

    if (!isset($data) && $data['status'] !== "CREATED") {
        return '';
    }
    if (!isset($data['id'])) {
        var_dump($data);
        return '';
    }
    setPayPalOrderId($data['id']);
    $url = '';
    foreach ($data['links'] as $link) {
        if ($link['rel'] !== "approve") {
            continue;
        }
        $url = $link['href'];
    }

    header("Location: " . $url);
}

function setPayPalOrderId(string $orderId): void
{
    $_SESSION['paypalOrderId'] = $orderId;
}

function getPayPalOrderId(): ?string
{
    return isset($_SESSION['paypalOrderId']) ? $_SESSION['paypalOrderId'] : null;
}

function setPayPalRequestId(string $paypalRequestId): void
{
    $_SESSION['paypalRequestId'] = $paypalRequestId;
}

function getPayPalRequestId(): ?string
{
    return isset($_SESSION['paypalRequestId']) ? $_SESSION['paypalRequestId'] : null;
}

function capturePayment(string $accessToken, string $orderId, string $token)
{
    if (!file_exists(CONFIG_DIR . '/paypal.php')) {
        redirectMissingConfig('config/paypal.php');
    }
    require_once CONFIG_DIR . '/paypal.php';
    $data = new stdClass();

    $data->payment_source = new stdClass();
    $data->payment_source->token = new stdClass();
    $data->payment_source->token->id = $token;
    $data->payment_source->token->type = "BILLING_AGREEMENT";
    $dataString = json_encode($data);

    $curl = curl_init();
    $options = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => PAYPAL_BASE_URL . '/v2/checkout/orders/' . $orderId . '/capture',
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $accessToken,
            //'PayPal-Request-Id: '.$payPalRequestId
        ],

        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $dataString
    ];
    curl_setopt_array($curl, $options);
    $result = curl_exec($curl);
    if (curl_errno($curl)) {
        echo curl_error($curl);
        curl_close($curl);
        return '';
    }
    curl_close($curl);
    $data = json_decode($result, true);
}

function paypalPaymentComplete($token)
{
    $accessToken = getAccessToken();
    $orderId = getPayPalOrderId();
    $payPalRequestId = getPayPalRequestId();
    //$token =filter_input(INPUT_GET,'token',FILTER_SANITIZE_STRING);

    if ($accessToken && $orderId && $token) {
        capturePayment($accessToken, $orderId, $token);
    }
}

function vorkassePaymentComplete()
{
    //TODO
}

function vorkasseCreateOrder(array $deliveryAddressData, array $cartProducts)
{
    //TODO;
    header("Location " . BASE_URL . "index.php/paymentComplete");
}
