<?php

function createOrder(int $userId,array $cartItems,string $status = 'new'):bool{

    $sql ="INSERT INTO orders SET
      status = :status,
      userId = :userId
    ";
    $statement = getDB()->prepare($sql);
    $data = [
      ':status'=>$status,
      ':userId' => $userId
    ];
    $statement->execute($data);
    $orderId = getDB()->lastInsertId();

    $sql ="INSERT INTO order_products SET
    title=:title,
    quantity = :quantity,
    price = :price,
    taxInPercent = :taxInPercent,
    orderId = :orderId
    ";
    $statement = getDB()->prepare($sql);

    foreach($cartItems as $cartItem){
      $taxInPercent = 19;
      $price = $cartItem['price'];

      $netPrice = (100-($taxInPercent/100)) * $price;
      $data = [
        ':title'=>$cartItem['title'],
        ':quantity'=>$cartItem['quantity'],
        ':price'=>$netPrice,
        ':taxInPercent'=>19,
        ':orderId'=>$orderId
      ];
      $statement->execute($data);
    }
    return true;
}
