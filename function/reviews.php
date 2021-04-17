<?php
function getPublicReviewsByProductId(int $productId): ?array
{
    return getReviewsByProductId($productId, 'PUBLIC');
}

function getReviewsByProductId(int $productId, string $status): ?array
{
    $reviews = [];

    $sql = "SELECT r.`id`,`product_id`,`user_id`,`username`,`value`,`title`,`text`,`created`,`status`
    FROM reviews r
    INNER JOIN user u ON(r.`user_id` = u.`id`)
    WHERE `product_id` =:productId 
    AND `status` = :status
    ORDER BY `created` DESC
    ";
    $statement = getDB()->prepare($sql);

    if (false === $statement) {

        return null;
    }
    $data = [
        ':productId' => $productId,
        ':status' => $status
    ];

    $statement->execute($data);

    if ($statement->rowCount() === 0) {

        return null;
    }

    while ($row = $statement->fetch()) {
        $reviews[] = $row;
    }
    return $reviews;
}


function saveReview(int $userId, int $productId, int $rating, string $title, string $text): bool
{
    $sql = "INSERT INTO reviews SET 
    `product_id` = :productId,
    `user_id` = :userId,
    `value` = :rating,
    `title` = :title,
    `text` = :text";
    $statement = getDB()->prepare($sql);

    if (false === $statement) {

        return false;
    }
    $data = [
        ':userId' => $userId,
        ':rating' => $rating,
        ':productId' => $productId,
        ':title' => $title,
        ':text' => $text,
    ];

    $statement->execute($data);
    return $statement->rowCount() > 0;
}


function userHasRatedProduct(int $userId,int $productId):bool
{
    $sql = "SELECT 1 FROM reviews WHERE user_id=:userId AND product_id = :productId";
    $statement = getDb()->prepare($sql);
    if (false === $statement) {
        return false;
    }
    $statement->execute([
        ':userId' => $userId,
        ':productId' => $productId,
    ]);
    return (bool)$statement->fetchColumn();
}

function getAvgRating(int $productId): ?float
{
    $status = 'PUBLIC';
    
    $sql ="SELECT SUM(`value`)/COUNT(`id`)
    FROM reviews
    WHERE `product_id` = :productId
    AND `status` = :status
    ";
       $statement = getDb()->prepare($sql);
       if (false === $statement) {
           return null;
       }
       $statement->execute([
           ':status'=>$status,
           ':productId' => $productId,
       ]);
       return (float)$statement->fetchColumn();
}