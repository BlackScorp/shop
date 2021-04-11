<?php

$activationKey = getActivationKeyByUsername($username);
if (null === $activationKey) {
    echo "Account ist aktiviert";
    exit();
}


$isEmail = true;
$registrationDate = date('d.M.Y');
$activationLink = $projectUrl . 'index.php/account/activate/' . $username . '/' . $activationKey;
$currentYear = date('Y');

require_once TEMPLATES_DIR . '/activationMail.php';
