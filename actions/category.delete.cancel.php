<?php
$redirectUrl = $_SESSION['redirectUrl'];
if(isset($_SESSION['deleteCategory'])){
    unset($_SESSION['deleteCategory']);
}
unset($_SESSION['redirectUrl']);

header('Location: '.$redirectUrl);