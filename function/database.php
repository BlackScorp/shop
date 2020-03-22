<?php

function getDB(){
  static $db;
  if($db instanceof PDO){
    return $db;
  }
  require_once CONFIG_DIR.'/database.php';
  $dsn = sprintf("mysql:host=%s;dbname=%s;charset=%s",DB_HOST,DB_DATABASE,DB_CHARSET);
  $db = new PDO($dsn,DB_USERNAME,DB_PASSWORD);
  return $db;
}
function printDBErrorMessage(){
  $info = getDB()->errorInfo();
  if(isset($info[2])){
    return $info[2];
  }
  return '';
}
