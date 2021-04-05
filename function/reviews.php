<?php
function getPublicReviewsByProductId(int $productId):?array
{
    return getReviewsByProductId($productId,'PUBLIC');
}

function getReviewsByProductId(int $productId,string $status):?array
{
    $reviews = [];

    $sql ="SELECT r.`id`,`product_id`,`user_id`,`username`,`value`,`title`,`text`,`created`,`status`
    FROM reviews r
    INNER JOIN user u ON(r.`user_id` = u.`id`)
    WHERE `product_id` =:productId 
    AND `status` = :status
    ORDER BY `created` DESC
    ";
    $statement = getDB()->prepare($sql);
    
    if(false=== $statement){
       
        return null;
    }
    $data = [
        ':productId'=>$productId,
        ':status'=>$status
    ];
 
    $statement->execute($data);

    if($statement->rowCount() === 0){
       
        return null;
    }

    while($row = $statement->fetch()){
        $reviews[]=$row;
    }
    return $reviews;
}