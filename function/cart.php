<?php

function addProductToCart(int $userId, int $productId, int $quantity = 1)
{
    $sql = "INSERT INTO cart
  SET quantity=:quantity,user_id = :userId,product_id = :productId
  ON DUPLICATE KEY UPDATE quantity = quantity +:quantity
  ";

    $statement = getDB()->prepare($sql);
    $data = [
        ':userId' => $userId,
        ':productId' => $productId,
        ':quantity' => $quantity
    ];

    return $statement->execute($data);
}

function countProductsInCart(?int $userId)
{
    if (null === $userId) {
        return 0;
    }
    $sql = "SELECT COUNT(id) FROM cart WHERE user_id =" . $userId;
    $cartResults = getDB()->query($sql);
    if ($cartResults === false) {
        return 0;
    }
    $cartItems = $cartResults->fetchColumn();
    return $cartItems;
}

function getCartItemsForUserId(?int $userId): array
{
    if (null === $userId) {
        return [];
    }
    $sql = "SELECT product_id,title,description,price,slug,quantity
          FROM cart
          JOIN products ON(cart.product_id = products.id)
          WHERE user_id = :userId";

    $statement = getDb()->prepare($sql);
    if (false === $statement) {
        return [];
    }
    $data = [
        ':userId' => $userId
    ];
    $statement->execute($data);

    $found = [];
    while ($row = $statement->fetch()) {
        $row['mainImage'] = getProductMainImage($row['slug']);
        $found[] = $row;
    }
    return $found;
}

function getCartSumForUserId(?int $userId): int
{
    if (null === $userId) {
        return 0;
    }
    $sql = "SELECT SUM(price * quantity)
          FROM cart
          JOIN products ON(cart.product_id = products.id)
          WHERE user_id = " . $userId;
    $result = getDb()->query($sql);
    if ($result === false) {
        return 0;
    }
    return (int)$result->fetchColumn();
}

function deleteProductInCartForUserId(int $userId, int $productId): int
{
    $sql = "DELETE FROM cart
  WHERE user_id = :userId
  AND product_id = :productId";

    $statement = getDb()->prepare($sql);
    if (false === $statement) {
        return 0;
    }
    $data = [
        ':userId' => $userId,
        ':productId' => $productId
    ];

    return $statement->execute(
        $data
    );
}

function moveCartProductsToAnotherUser(int $sourceUserId, int $targetUserId): int
{
    if ($sourceUserId === $targetUserId) {
        return 0;
    }
    $oldCartItems = getCartItemsForUserId($sourceUserId);
    if (count($oldCartItems) === 0) {
        return 0;
    }
    $movedProducts = 0;

    foreach ($oldCartItems as $oldCartItem) {
        addProductToCart($targetUserId, (int)$oldCartItem['product_id'], (int)$oldCartItem['quantity']);
        $movedProducts += deleteProductInCartForUserId($sourceUserId, (int)$oldCartItem['product_id']);
    }

    return $movedProducts;
}

function clearCartForUser(int $userId)
{
    $sql = "DELETE FROM cart WHERE user_id = :userId";
    $statement = getDB()->prepare($sql);
    $statement->execute([':userId' => $userId]);
}
