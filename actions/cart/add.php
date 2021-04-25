<?php

redirectIfNotLogged("/cart/add/" . $productId);
$result = addProductToCart($userId, $productId);
header("Location: " . $projectUrl . "index.php");