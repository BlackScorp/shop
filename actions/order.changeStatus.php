<?php

if(!isAdmin()){
    logData('ERROR','Keine Rechte für die Route');
    exit();
}

$postData = $_POST['order'];

foreach($postData as $orderData){

    $orderId = (int)$orderData['id'];
    $order = getOrderForUser($orderId);
    $newStatus = $orderData['status'];

    if(!$order){
        logData('WARNING','Order wurde nicht gefunden',['oderId'=>$orderId]);
        continue;
    }
    $changed = updateOrderStatus($newStatus,$orderId);
    if(!$changed){

        continue;
    }
    //TODO Mailsent
}

