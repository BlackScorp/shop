<?php
session_start();
error_reporting(-1);
ini_set('display_errors','On');

define('CONFIG_DIR',__DIR__.'/config');
require __DIR__.'/includes.php';

$userId = getCurrentUserId();
setcookie('userId',$userId,strtotime('+30 days'));
