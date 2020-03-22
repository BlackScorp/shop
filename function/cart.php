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
