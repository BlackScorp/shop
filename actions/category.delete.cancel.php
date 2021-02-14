<?php
if(isset($_SESSION['deleteCategory'])){
    unset($_SESSION['deleteCategory']);
}
$referrer = BASE_URL.'index.php';

header('Location: '.$referrer);