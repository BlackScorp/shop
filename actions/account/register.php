<?php

$username = "";
$email = "";
$emailRepeat = "";
$password = "";
$passwordRepeat = "";
$errors = [];


if (isPost()) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password');
    $passwordRepeat = filter_input(INPUT_POST, 'passwordRepeat');
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $emailRepeat = filter_input(INPUT_POST, 'emailRepeat', FILTER_SANITIZE_EMAIL);

    if (false === (bool)$username) {
        $errors[] = "Benutzername ist leer";
    }

    if (false === (bool)$password) {
        $errors[] = "Passwort ist leer";
    }
    if (true === (bool)$username) {
        if (mb_strlen($username) < 4) {
            $errors [] = "Benutzername ist zu kurz, mindestens 4 Zeichen";
        }
        if (mb_strlen($username) > 10) {
            $errors [] = "Benutzername ist zu lang, maximal 10 Zeichen";
        }
        $usernameExists = usernameExists($username);
        if (true === $usernameExists) {
            $errors[] = "Benutzername bereits exestiert";
        }
    }
    if (true === (bool)$password) {
        if (mb_strlen($password) < 6) {
            $errors[] = "Passwort ist zu kurz";
        }
    }
    if ($password !== $passwordRepeat) {
        $errors[] = "Passwörter stimmen nicht überein";
    }
    if (false === (bool)$email) {
        $errors[] = "Email ist leer";
    }
    if (true === (bool)$email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email ist nicht gültig";
        }
        $emailExists = emailExists($email);

        if (true === $emailExists) {
            $errors[] = "E-Mail bereits exestiert";
        }
    }
    if ($email !== $emailRepeat) {
        $errors[] = "Email adressen stimmen nicht überein";
    }

    $hasErrors = count($errors) > 0;
    if (false === $hasErrors) {
        $created = createAccount($username, $password, $email);
        if (!$created) {
            $errors[] = "Account konnte nicht angelegt werden, versuchen Sie es später erneut";
        }
        if ($created) {
            $activationEmailUrl = $projectUrl . 'index.php/activationMail/' . $username;

            $message = new Swift_Message('Vielen dank für die Registrierung');
            $message->setBody(file_get_contents($activationEmailUrl), 'text/html');
            $message->setTo([$email => $username]);
            $message->setFrom([MAIL_NOREPLY => 'Mein Shop']);
            $send = sendMail($message);
            if (!$send) {
                $errors[] = "Account konnte nicht angelegt werden, versuchen Sie es später erneut";
            }
            if ($send) {
                flashMessage("Account wurde erstellt");
                header("Location: " . $baseUrl . "index.php");
            }
        }
    }
}
$hasErrors = count($errors) > 0;
