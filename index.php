<?php
session_start();
error_reporting(-1);
ini_set('display_errors','On');

define('CONFIG_DIR',__DIR__.'/config');
require_once __DIR__.'/function/database.php';

$sql ="SELECT id,titel,description,price
FROM products";

$result = getDB()->query($sql);

$userId = 0;
$cartItems = 0;

if(isset($_SESSION['userId'])){
  $userId = (int) $_SESSION['userId'];
}
if(isset($_COOKIE['userId'])){
  $userId = (int) $_COOKIE['userId'];
}

$sql ="SELECT COUNT(id) FROM cart WHERE user_id =".$userId;
$cartResults = getDb()->query($sql);

$cartItems = $cartResults->fetchColumn();

require __DIR__.'/templates/main.php';
