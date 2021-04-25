<?php

$redirectTarget = $baseUrl . 'index.php';
if (isset($_SESSION['redirectTarget'])) {
    $redirectTarget = $_SESSION['redirectTarget'];
}
session_regenerate_id(true);
session_destroy();
header("Location: " . $redirectTarget);