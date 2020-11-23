<?php

function getAllProducts(){
  $sql ="SELECT id,title,description,price,slug,status
  FROM products";
  if(false === isAdmin()){
    $sql .= " WHERE status = 'LIVE'";
  }

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
  $sql ="SELECT id,title,description,price,slug,status
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
function editProduct(int $id, string $productName,string $slug,string $description,int $price):bool{
  $sql="UPDATE products SET 
  title = :productName,
  slug = :slug,
  description = :description,
  price = :price
  WHERE id= :id
  ";
    $statement = getDB()->prepare($sql);
    if(false === $statement){
      return false;
    }
    $statement->execute(
      [
        ':id'=>$id,
        ':productName' => $productName,
        ':slug'=>$slug,
        ':description'=>$description,
        ':price'=>$price,
      ]
    ); 
    $rowCount = $statement->rowCount();
    return $rowCount > 0;
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

function uploadProductPictures(string $slug,array $picutres){
  $picutrePath = STORAGE_DIR.'/productPictures/'.$slug.'/';
  if(!is_dir($picutrePath)){
    mkdir($picutrePath,0777,true);
  }
  foreach($picutres as $picutre){
    copy($picutre['tmp_name'],$picutrePath.'1.'.$picutre['extension']);
    unlink($picutre['tmp_name']);
  }
}