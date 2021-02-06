<?php

function saveDeliveryAddressForUser(int $userId, string $recipient, string $city, string $zipCode, string $street, string $streetNumber): int
{
    $sql = "INSERT INTO delivery_adresses
  SET user_id = :userId,
  recipient = :recipient,
  city = :city,
  street = :street,
  streetNumber = :streetNumber,
  zipCode = :zipCode
  ";

    $statement = getDB()->prepare($sql);
    if (false === $statement) {
        return 0;
    }

    $statement->execute([
        ':userId' => $userId,
        ':recipient' => $recipient,
        ':city' => $city,
        ':street' => $street,
        ':streetNumber' => $streetNumber,
        ':zipCode' => $zipCode
    ]);

    return (int)getDB()->lastInsertId();
}

function getDeliveryAddressDataForUser(int $deliveryAddresId, int $userId): ?array
{
    $sql = "SELECT id,recipient,city,street,streetNumber,zipCode
FROM delivery_adresses
WHERE user_id =:userId
AND id=:deliveryAddressId
LIMIT 1
";


    $statement = getDB()->prepare($sql);
    if (false === $statement) {
        return null;
    }


    $statement->execute([':userId' => $userId, ':deliveryAddressId' => $deliveryAddresId]);
    $address = $statement->fetch();
    return $address;
}

function getDeliveryAddressesForUser(int $userId): array
{
    $sql = "SELECT id,recipient,city,street,streetNumber,zipCode
FROM delivery_adresses
WHERE user_id =:userId";


    $statement = getDB()->prepare($sql);
    if (false === $statement) {
        return [];
    }

    $addresses = [];

    $statement->execute([':userId' => $userId]);

    while ($row = $statement->fetch()) {
        $addresses[] = $row;
    }

    return $addresses;
}

function deliveryAddressBelongsToUser(int $deliveryAddressId, int $userId): bool
{
    $sql = "SELECT id
FROM delivery_adresses
WHERE user_id = :userId AND id = :deliveryAddressId";

    $statement = getDB()->prepare($sql);
    if (false === $statement) {
        return false;
    }
    $statement->execute([
        ':userId' => $userId,
        ':deliveryAddressId' => $deliveryAddressId
    ]);

    return (bool)$statement->rowCount();
}
