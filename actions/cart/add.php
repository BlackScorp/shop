<?php

redirectIfNotLogged("/cart/add/" . $parameter);
$result = addProductToCart($userId, $parameter);
header("Location: " . $projectUrl . "index.php");