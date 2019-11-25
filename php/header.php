<?php

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

<head>
    <meta charset="UTF-8">
    <title>BDD App</title>

    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/bbde602ffb.js" crossorigin="anonymous"></script>

    <!-- Link css generale -->
    <link rel="stylesheet" type="text/css" href="../css/general.css">
    <!-- Link css bootstrap -->
    <link href="../css/bootstrap/bootstrap.css" rel="stylesheet"/>
    <!-- Link css custom, con quel "?v=1.0" che "fixa" la cache e permette al file custom di funzionare con btsrp-->
    <link href="../css/style.css?v=1.0" rel="stylesheet" type="text/css" />



    <!-- todo: scaricare jquery e popper per install locale   -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>

    <!-- collegamento javascript bootstrap -->
    <script src="../js/bootstrap/bootstrap.min.js"></script>
</head>
