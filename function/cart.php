<?php
function addProductToCart(int $userId,int $productId){
  $sql ="INSERT INTO cart SET user_id = :userId,product_id = :productId";
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
  $sql ="SELECT product_id,titel,description,price
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
