<?php

function createOrder(int $userId, array $cartItems, array $deliveryAddressData, string $status = 'new'): bool
{
    $sql = "INSERT INTO orders SET
      status = :status,
      orderDate = :orderDate,
      deliveryDate = :deliveryDate,
      userId = :userId
    ";
    $statement = getDB()->prepare($sql);
    if (false === $statement) {
        echo printDBErrorMessage();
        return false;
    }
    $data = [
        ':status' => $status,
        ':userId' => $userId,
        ':orderDate' => date('Y-m-d'),
        ':deliveryDate' => '0000-00-00'
    ];
    $created = $statement->execute($data);
    if (false === $created) {
        echo printDBErrorMessage();
        return false;
    }
    $orderId = getDB()->lastInsertId();
    invoiceId($orderId);
    $sql = "INSERT INTO order_adresses SET
    order_id = :orderId,
    recipient = :recipient,
    city = :city,
    street = :street,
    streetNumber = :streetNumber,
    zipCode = :zipCode
    ";
    $statement = getDB()->prepare($sql);
    if (false === $statement) {
        echo printDBErrorMessage();
        return false;
    }
    $data = [
        ':orderId' => $orderId,
        ':recipient' => $deliveryAddressData['recipient'],
        ':city' => $deliveryAddressData['city'],
        ':street' => $deliveryAddressData['street'],
        ':streetNumber' => $deliveryAddressData['streetNumber'],
        ':zipCode' => $deliveryAddressData['zipCode'],
    ];
    $created = $statement->execute($data);
    if (false === $created) {
        echo printDBErrorMessage();
        return false;
    }
    $sql = "INSERT INTO order_products SET
    title=:title,
    quantity = :quantity,
    price = :price,
    taxInPercent = :taxInPercent,
    orderId = :orderId
    ";
    $statement = getDB()->prepare($sql);
    if (false === $statement) {
        echo printDBErrorMessage();
        return false;
    }
    foreach ($cartItems as $cartItem) {
        $taxInPercent = 19;
        $price = $cartItem['price'];

        $netPrice = (1.0 - ($taxInPercent / 100)) * $price;
        $data = [
            ':title' => $cartItem['title'],
            ':quantity' => $cartItem['quantity'],
            ':price' => $netPrice,
            ':taxInPercent' => 19,
            ':orderId' => $orderId
        ];
        $created = $statement->execute($data);
        if (false === $created) {
            echo printDBErrorMessage();
            break;
        }
    }
    return $created;
}

function invoiceId(?int $invoiceId = null)
{
    static $id = null;
    if (!$invoiceId) {
        return $id;
    }
    $id = $invoiceId;
}

function getOrderSumForUser(int $orderId, int $userId): ?array
{
    $sql = "SELECT SUM(price*quantity) AS sumNet,
  CONVERT(SUM(price*quantity)*(1+taxInPercent/100), SIGNED INTEGER) AS sumBrut,
  CONVERT((SUM(price*quantity)*(1+taxInPercent/100)) - ( SUM(price*quantity) ),SIGNED INTEGER) AS taxes
  FROM order_products op
  INNER JOIN orders o ON(op.orderId = o.id)
  WHERE userId = :userId
  AND orderId = :orderId";

    $statement = getDB()->prepare($sql);
    if (false === $statement) {
        echo printDBErrorMessage();
        return null;
    }
    $statement->execute([
        ':orderId' => $orderId,
        ':userId' => $userId
    ]);
    if (0 === $statement->rowCount()) {
        return null;
    }
    return $statement->fetch();
}

function getOrderForUser(int $orderId, ?int $userId = null): ?array
{
    $sql = "SELECT orderDate,deliveryDate,status,userId,id
  FROM orders
  WHERE id=:orderId ";
    $data = [
        ':orderId' => $orderId
    ];

    if ($userId) {
        $data[':userId'] = $userId;
        $sql .= "AND userId = :userId";
    }


    $sql .= " LIMIT 1";

    $statement = getDB()->prepare($sql);
    if (false === $statement) {
        echo printDBErrorMessage();
        return null;
    }
    $statement->execute($data);
    if (0 === $statement->rowCount()) {
        return null;
    }

    $orderData = $statement->fetch();
    $orderDate = date_create($orderData['orderDate']);
    $deliveryDateFormatted = 'Noch nicht angegeben';
    if ($orderData['deliveryDate'] !== "0000-00-00") {
        $deliveryDate = date_create($orderData['deliveryDate']);
        $deliveryDateFormatted = date_format($deliveryDate, 'd.m.Y');
    }
    $orderData['deliveryDateFormatted'] = $deliveryDateFormatted;
    $orderData['orderDateFormatted'] = date_format($orderDate, 'd.m.Y');
    $orderData['products'] = [];
    $orderData['deliveryAddressData'] = [];
    $sql = "SELECT recipient,streetNumber,city,street,zipCode,`type`
    FROM order_adresses
    WHERE order_id = :orderId LIMIT 1";
    $statement = getDB()->prepare($sql);
    if (false === $statement) {
        echo printDBErrorMessage();
        return null;
    }
    $data = [
        ':orderId' => $orderId
    ];

    $executed = $statement->execute($data);
    if (false === $executed) {
        echo printDBErrorMessage();
        return null;
    }

    if (0 === $statement->rowCount()) {
        return null;
    }
    $orderData['deliveryAddressData'] = $statement->fetch();

    $sql = "SELECT id,title,quantity,price,taxInPercent
    FROM order_products
    WHERE orderId = :orderId";
    $statement = getDB()->prepare($sql);
    if (false === $statement) {
        echo printDBErrorMessage();
        return null;
    }
    $statement->execute([
        ':orderId' => $orderId
    ]);
    if (0 === $statement->rowCount()) {
        return null;
    }

    while ($row = $statement->fetch()) {
        $orderData['products'][] = $row;
    }
    return $orderData;
}

function getOrders(): array
{
    logData('INFO','Suche Bestellungen');

    $sql ="SELECT id,orderDate,deliveryDate,status 
    FROM orders 
    ORDER BY orderDate DESC
    ";
    $statement = getDB()->prepare($sql);
    if (false === $statement) {
        logData('ERROR','Fehler beim Aufrufen der Bestellungen',[
            'sql'=>$sql,
            'error'=> printDBErrorMessage()
        ]);
     
        return [];
    }
    $statement->execute();
    if (0 === $statement->rowCount()) {
        logData('INFO','Es wurden keine Bestellungen gefunden');
        return [];
    }
    logData('INFO','Liefere alle Bestellungen aus');
    $orders = [];
    while ($row = $statement->fetch()) {
        $orders[] = $row;
    }
    return $orders;
}

function updateOrderStatus(string $newStatus, int $orderId):bool {
    logData('INFO','Ändere order status');

    $sql ="UPDATE orders SET status = :newStatus WHERE id=:id";
    $statement = getDB()->prepare($sql);
    if (false === $statement) {
        logData('ERROR','Fehler beim Aufrufen der Bestellungen',[
            'sql'=>$sql,
            'error'=> printDBErrorMessage()
        ]);
     
        return false;
    }
    $statement->execute(
        [
            ':newStatus'=>$newStatus,
            ':id'=>$orderId
        ]
    );
    return $statement->rowCount() > 0;
}