<?php
if(!isAdmin()){
    echo 'Kein Zugriff';
    exit();
}

$orderStatus = [
    "new",
    "canceled",
    "payed",
    "sent",
    "delivered"
];
$orders = getOrders();

require_once TEMPLATES_DIR.'/orders.php';