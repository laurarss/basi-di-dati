<?php
    //Apro la sessione e...
    session_start();
    //Recupero username e password dal form
    $username = $_POST['user'];
    $password = $_POST['pass'];
    //Salvo i dati nella variabile (array) globale $_SESSION
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;
?>