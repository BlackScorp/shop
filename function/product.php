<?php

function getAllProducts(){
  $sql ="SELECT id,titel,description,price
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
