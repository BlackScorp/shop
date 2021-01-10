<?php

function getCategories():array{
    $categories = [];
    $sql ="SELECT id,label,parentId
    FROM categories
    ORDER BY `position`,label";

    $statement = getDB()->prepare($sql);
    if(false === $statement){
      return $categories;
    }
    $statement->execute();
    if(0 === $statement->rowCount()){
        return $categories;
    }
    while($row = $statement->fetch()){
        
        $categories[]=$row;
    }
    return $categories;
}