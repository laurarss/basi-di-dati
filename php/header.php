<?php
header('Content-type: text/html; charset=UTF-8');

// includes
include('server.php');

if (!isset($_SESSION)) {
    session_start();
}

// carico la navbar: ci sono due navbar distinte per utenti loggati e non
if (isset($_SESSION['nomeUtente'])) {
    include 'nav_auth.php';
} else {
    include 'nav_unauth.php';
}
?>

