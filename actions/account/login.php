<?php

$isPost = isPost();
$username = "";
$password = "";
$errors = [];
$hasErrors = false;
if ($isPost) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password');

    if (false === (bool)$username) {
        $errors[] = "Benutzername ist leer";
    }
    if (false === (bool)$password) {
        $errors[] = "Passwort ist leer";
    }
    $userData = getUserDataForUsername($username);
    if ((bool)$username && 0 === count($userData)) {
        $errors[] = "Benutzername exestiert nicht";
    }
    if ((bool)$username &&
        isset($userData['activationKey']) &&
        false === is_null($userData['activationKey'])) {
        $errors[] = "Account wurde noch nicht aktiviert";
    }
    if ((bool)$password &&
        isset($userData['password']) &&
        false === password_verify($password, $userData['password'])
    ) {
        $errors[] = "Passwort stimmt nicht";
    }

    if (0 === count($errors)) {
        $_SESSION['userId'] = (int)$userData['id'];
        $_SESSION['userRights'] = $userData['userRights'];
        $redirectTarget = $baseUrl . 'index.php';
        if (isset($_SESSION['redirectTarget'])) {
            $redirectTarget = $_SESSION['redirectTarget'];
        }
        header("Location: " . $redirectTarget);
        exit();
    }
}
$hasErrors = count($errors) > 0;
