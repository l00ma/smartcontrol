<?php

include_once '/usr/lib/includes/db_connect.php';
include_once '/usr/lib/includes/functions.php';

sec_session_start(); // debut de session
if (isset($_POST['user'], $_POST['p'])) {
    $username = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
    $password = $_POST['p']; // mot de passe hashé
    
    if (login($username, $password, $mysqli) == true) {
        // Login !! 
        header("Location: ../welcome.php");
        exit();
    } else {
        // Mauvais identifiants !!
        header('Location: ../index.php?error=1');
        exit();
    }
} else {
    header('Location: ../error.php?err=Impossible de se connecter.');
    exit();
}