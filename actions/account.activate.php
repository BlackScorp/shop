<?php



$activated = activateAccount($username, $activationKey);
if (false === $activated) {
    echo "Ungültiger Account";
    exit();
}
flashMessage("Account wurde aktiviert");
header("Location: " . $baseUrl . "index.php");