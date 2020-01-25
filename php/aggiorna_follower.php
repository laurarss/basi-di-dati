<?php

//includo file connessione al db
include('db_connect.php');

if (!isset($_SESSION)) {
    session_start();
}

$segui = $utenteSession = '';

if (isset($_POST['idBlog']) && isset($_SESSION['nomeUtente'])) {

    $idBlog = $_POST['idBlog'];
    $utenteSession = mysqli_real_escape_string($conn, $_SESSION['nomeUtente']);
    $isFollower = $_POST['isFollower'];
    $sqlUpdateFollow = '';

    if ($isFollower == true) {

        // sql cancellazione follower
        $sqlUpdateFollow = "DELETE FROM `follower` WHERE `idBlog` = $idBlog AND idUtente = '$utenteSession'";
    } else {

        // sql creazione nuovo follower
        $sqlUpdateFollow = "INSERT INTO `follower` (`idUtente`, `idBlog`) VALUES ('$utenteSession', '$idBlog')";
    }

    $risUpdateFollow = mysqli_query($conn, $sqlUpdateFollow);

    if($risUpdateFollow === false) {
        echo 'false';
    } else {
        echo 'true';
    }
}


