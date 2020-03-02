<?php
error_reporting(-1);
ini_set('display_errors','On');

define('CONFIG_DIR',__DIR__.'/config');
require_once __DIR__.'/function/database.php';

$sql ="SELECT id,titel,description,price
FROM products";

$result = getDB()->query($sql);

require __DIR__.'/templates/main.php';
