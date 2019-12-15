<?php
//includo file connessione al db
include('db_connect.php');
//includo file header
include('header.php');


if (isset($_GET['idBlog'])) {
    $nomeUtente = mysqli_real_escape_string($conn, $_SESSION['nomeUtente']);
    $idBlog = $_GET['idBlog'];

// sql to delete a record
    $sql = "DELETE FROM `blog` WHERE `idBlog` = $idBlog";

    if ($conn->query($sql) === TRUE) {
        //se la query è andata a buon fine
        header("Location: gestione_blog.php?nomeUtente=$nomeUtente ?>");
    } else {
        echo "Errore nel cancellare il record: " . $conn->error;
    }

    // close connection
    $conn->close();
}
?>
