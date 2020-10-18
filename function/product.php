<?php

function getAllProducts(){
  $sql ="SELECT id,title,description,price,slug
  FROM products
  WHERE status = 'LIVE'";

  $result = getDB()->query($sql);
  if(!$result){
    return [];
  }
  $products = [];
  while($row = $result->fetch()){
    $products[]=$row;
  }
  return $products;
}

function getProductBySlug(string $slug):?array{
  $sql ="SELECT id,title,description,price,slug 
  FROM products
  WHERE slug=:slug
  LIMIT 1
  ";
  $statement = getDB()->prepare($sql);
  if(false === $statement){
    return null;
  }
  $statement->execute(
    [':slug'=>$slug]
  );
  if($statement->rowCount() === 0){
    return null;
  }
  return $statement->fetch();
}

function createProduct(string $productName,string $slug,string $description,int $price):bool{
    $sql="INSERT INTO products SET 
    title = :productName,
    slug = :slug,
    description = :description,
    price = :price
    ";
      $statement = getDB()->prepare($sql);
      if(false === $statement){
        return false;
      }
      $statement->execute(
        [
          ':productName' => $productName,
          ':slug'=>$slug,
          ':description'=>$description,
          ':price'=>$price,
        ]
      ); 
      $lastId = getDB()->lastInsertId();
      return $lastId > 0;
}