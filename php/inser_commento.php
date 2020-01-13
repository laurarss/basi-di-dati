<?php
//connessione al db
include('db_connect.php');
//header & nav
include('header.php');
include('head.php');

$nomeUtente = mysqli_real_escape_string($conn, $_SESSION['nomeUtente']);

if (isset($_GET['idPost'])) {
    if ($nomeUtente) {

        // $testo = mysqli_real_escape_string($conn, $_GET['']);

        $sqlNewComment =
            "INSERT INTO `commenti` (`idCommento`, `data`, `nota`, `idPost`, `autore`) VALUES (NULL, CURRENT_TIMESTAMP, 'ciao questo è un commento di prova.', '$idPost', '$nomeUtente')";

        $risNewComment = mysqli_query($sqlNewComment);
        if ($risNewComment) {
            header('Location: index.php');
        } else {
            echo "errore";
        }

        //chiudi connessione
        mysqli_close($conn);
    } else {
        echo "<div class='col-12 text-center'>Solo gli utenti loggati possono commentare. <a href='login.php'>Fai login qui<a></div>";
    }
}
?>