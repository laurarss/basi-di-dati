<?php
//includo file connessione al db
include('db_connect.php');
//includo file header
include('header.php');
include('head.php');

if (isset($_SESSION['nomeUtente'])) {
    $nomeUtente = mysqli_real_escape_string($conn, $_SESSION['nomeUtente']);

// sql to delete a record
    $sql = "DELETE FROM `utenti` WHERE `utenti`.`nomeUtente` = '$nomeUtente';";

    if ($conn->query($sql) === TRUE) {
        //se la query è andata a buon fine
        echo '<div class="alert alert-success" role="alert"><p><strong>' . " Utente cancellato" . '</strong></p></div>';
        // chiudo la sessione
        unset($_SESSION['nomeUtente']);
        session_destroy();
    } else {
        echo '<div class="alert alert-danger" role="alert"><p><strong>' . "Si è verificato un errore" . '</strong></p></div>';
    }

    // close connection
    $conn->close();
}
?>


<div class="col-10 text-left">
    <a class="btn btn-outline-secondary btn-sm" href="index.php">
        <i class="fa fa-arrow-left"></i>
        Torna alla home
    </a>
</div>
