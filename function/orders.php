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

      $netPrice = (1.0-($taxInPercent/100)) * $price;
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

function getOrderForUser(int $orderId,int $userId):?array{

  $sql = "SELECT orderDate,status,userId,id
  FROM orders
  WHERE id=:orderId AND userId = :userId
  LIMIT 1
  ";
  $statement = getDB()->prepare($sql);
  if(false === $statement){
    echo printDBErrorMessage();
    return null;
  }
    $statement->execute([
      ':orderId'=>$orderId,
      ':userId'=>$userId
    ]);
    if(0 === $statement->rowCount()){
      return null;
    }
    $orderData =$statement->fetch();
    $orderData['products'] = [];

    $sql = "SELECT id,title,quantity,price,taxInPercent
    FROM order_products
    WHERE orderId = :orderId";
$statement = getDB()->prepare($sql);
if(false === $statement){
  echo printDBErrorMessage();
  return null;
}
$statement->execute([
  ':orderId'=>$orderId
]);
if(0 === $statement->rowCount()){
  return null;
}

    while($row = $statement->fetch()){
        $orderData['products'][]=$row;
    }
    return $orderData;
}
