<?php


$routeParts = explode('/',$route);
if(count($routeParts) !== 5){
    echo "Ungültige URL";
    die();
}
$slug = $routeParts[3];
$fileName = $routeParts[4];

$sourceFilePath = STORAGE_DIR.'/productPictures/'.$slug.'/'.$fileName;
if(false === is_file($sourceFilePath)){
   http_response_code(404);
   exit();
}
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimetype = finfo_file($finfo,$sourceFilePath);

header('Content-Type:'.$mimetype);
readfile($sourceFilePath);