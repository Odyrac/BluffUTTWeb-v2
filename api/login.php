<?php

include('./../components/env.php');
include('./../components/functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];

    if ($password === $passwordGlobal) {
        setcookie('password', $password, time() + 365 * 24 * 3600, '/');

        writeLog('../', 'Connexion');

        header('Location: ../panel.php');

        return;
    }

    header('Location: ../panel.php?error=auth');
}