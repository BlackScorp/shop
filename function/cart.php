<?php
function addProductToCart(int $userId,int $productId){
  $sql ="INSERT INTO cart
  SET quantity=1,user_id = :userId,product_id = :productId
  ON DUPLICATE KEY UPDATE quantity = quantity +1
  ";
  $statement = getDB()->prepare($sql);

  $statement->execute([
    ':userId'=>  $userId ,
    ':productId'=>$productId
  ]);
}

function countProductsInCart(int $userId){
  $sql ="SELECT COUNT(id) FROM cart WHERE user_id =".$userId;
  $cartResults = getDB()->query($sql);
  if($cartResults === false){

    return 0;
  }
  $cartItems = $cartResults->fetchColumn();
  return $cartItems;
}

function getCartItemsForUserId(int $userId):array{
  $sql ="SELECT product_id,title,description,price
          FROM cart
          JOIN products ON(cart.product_id = products.id)
          WHERE user_id = ".$userId;
  $results = getDb()->query($sql);
  if($results === false){
    return [];
  }
  $found = [];
  while($row = $results->fetch()){
    $found[]=$row;
  }
  return $found;
}

function getCartSumForUserId(int $userId): int{
  $sql ="SELECT SUM(price * quantity)
          FROM cart
          JOIN products ON(cart.product_id = products.id)
          WHERE user_id = ".$userId;
  $result = getDb()->query($sql);
  if($result === false){
    return 0;
  }
  return (int)$result->fetchColumn();
}

function moveCartProductsToAnotherUser(int $sourceUserId,int $targetUserId):int{
  $sql="UPDATE cart
        SET user_id =:targetUserId
        WHERE  user_id=:sourceUserId";

  $statement = getDb()->prepare($sql);
  if(false === $statement){
    return 0;
  }

  return $statement->execute(
    [
      ':targetUserId'=>$targetUserId,
      ':sourceUserId'=>$sourceUserId
    ]
  );
}
