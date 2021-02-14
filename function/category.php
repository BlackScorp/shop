<?php

function getCategories(?int $categoryId): array
{
    $categories = [];
    $sql = "SELECT id,label,parentId,id=:categoryId as isPrimary
    FROM categories WHERE ";
    $tempSql = "parentId is null ";
    if ($categoryId) {
        $tempSql = "id=:categoryId OR parentId = :categoryId ";
    }
    $sql .= $tempSql;
    $sql .= "ORDER BY isPrimary DESC,`position`,label";

    $statement = getDB()->prepare($sql);
    if (false === $statement) {
        return $categories;
    }
    $statement->execute([':categoryId' => $categoryId]);
    if (0 === $statement->rowCount()) {
        return $categories;
    }
    while ($row = $statement->fetch()) {
        $categories[] = $row;
    }
    return $categories;
}

function findCategoryById(int $categoryId): ?array
{
    $sql = "SELECT id,label,parentId
    FROM categories
    WHERE id = :id";

    $statement = getDB()->prepare($sql);
    if (false === $statement) {
        return null;
    }
    $statement->execute([
        ':id' => $categoryId
    ]);

    if (0 === $statement->rowCount()) {
        return null;
    }

    $categoryData = $statement->fetch();

    return $categoryData;
}

function getParentCategory(?int $categoryId = null, array &$labels)
{
    if (!$categoryId) {
        return null;
    }
    $sql = "SELECT id,label,parentId FROM categories WHERE id = :categoryId";

    $statement = getDB()->prepare($sql);
    if (false === $statement) {
        return null;
    }
    $statement->execute([
        ':categoryId' => $categoryId
    ]);
    if (0 === $statement->rowCount()) {
        return null;
    }
    $row = $statement->fetch();

    $labels[] = $row;
    if ($row['parentId']) {
        getParentCategory((int)$row['parentId'], $labels);
    }
}

function createCategory(string $categoryName,?int $parentId): bool
{
    $sql ="INSERT INTO categories 
    SET label = :categoryName, 
    parentId = :parentId";
    $statement = getDB()->prepare($sql);
    if (false === $statement) {
        return false;
    }
    $statement->execute([
        ':categoryName' => $categoryName,
        ':parentId' => $parentId,
    ]);
    return $statement->rowCount() > 0;
}

function deleteCategory(int $categoryId): bool
{
 $sql ="DELETE FROM categories WHERE id = :categoryId";
 $statement = getDB()->prepare($sql);
 if (false === $statement) {
     return false;
 }
 $statement->execute([
    ':categoryId' => $categoryId
]);
return $statement->rowCount() > 0;
}