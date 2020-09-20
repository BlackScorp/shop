<?php

function getAllProducts(){
  $sql ="SELECT id,title,description,price,slug
  FROM products";

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