<?php

function saveDeliveryAddressForUser(int $userId,string $recipient,string $city,string $zipCode,string $street,string $streetNumber):int{
  $sql ="INSERT INTO delivery_adresses
  SET user_id = :userId,
  recipient = :recipient,
  city = :city,
  street = :street,
  streetNumber = :streetNumber,
  zipCode = :zipCode
  ";

  $statement = getDB()->prepare($sql);
  if(false === $statement){
    return 0;
  }

  $statement->execute([
    ':userId'=>$userId,
    ':recipient'=>$recipient,
    ':city'=>$city,
    ':street'=>$street,
    ':streetNumber'=>$streetNumber,
    ':zipCode'=>$zipCode
  ]);

  return (int)getDB()->lastInsertId();
}
